<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use Lava;
use DB;
use App\AccEmployee;
use App\AccActivity;
use App\AccOpco;

use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function index() {
        return view('welcome');
    }
    
    public static function hashPassword($password, $times) {
        $hashed_password = hash("sha512", $password, false);
        if ($times > 1) {
            return LoginController::hashPassword($hashed_password, $times-1);
        } else {
            return $hashed_password;
        }
    }
    
    public function authenticate() {
        $input = Input::all();
        $employees = AccEmployee::where('username', $input['username']);
        if ($employees->count() != 0) {
            $employee = $employees->first();
            if ($employee->password == LoginController::hashPassword($input['password'].$employee->salt, 8)) {
                if ($employee->change_password) {
                    return Redirect::route('change_password', $employee->slug())
                            ->with('success', '<span class="font-weight-bold">Password change required!</span><br />Update your password to continue.');
                } else {
                    if ($employee->active) {
                        if (!isset($_SESSION)) session_start();
                        $_SESSION['halo_user'] = $employee;
                        Session::put('halo_user', $employee);
                        AccActivity::create([
                            'employee_id' => $employee->id,
                            'detail' => 'User logged in.',
                            'source_ip' => $_SERVER['REMOTE_ADDR']
                        ]);
                        $employee->update(['last_login' => date('Y-m-d H:i:s'), 'login_attempts' => 0]);
                        return Redirect::route('dashboard');
                    } else {
                        return Redirect::back()
                                ->with('error', '<span class="font-weight-bold">Login error!</span><br />User account is inactive.');
                    }
                }
            } else {
                $login_attempts = $employee->login_attempts + 1;
                $employee->update(['login_attempts' => $login_attempts, 'last_attempt' => date('Y-m-d H:i:s')]);
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Login error!</span><br />Invalid password.');
            }
        } else {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Login error!</span><br />User does not exist.');
        }
    }
    
    static function checkAccess() {
        if (Session::has('halo_user')) {
            return true;
        } else {
            return false;
        }
    }
    
    public function change_password(AccEmployee $employee) {
        return view('change_password', compact('employee'));
    }
    
    public function update_password(AccEmployee $employee) {
        $input = array_except(Input::all(), '_method');
        $input['password'] = LoginController::hashPassword($input['password'].$employee->salt, 8);
        $input['change_password'] = false;
        unset($input['password2']);
        if ($employee->update($input)) {
            $halo_user = $employee;
            AccActivity::create([
                'employee_id' => $halo_user->id,
                'detail' => 'Password was updated - '.$employee->username.'.',
                'source_ip' => $_SERVER['REMOTE_ADDR']
            ]);
            return Redirect::route('welcome')
                    ->with('success', '<span class="font-weight-bold">Password change successful!</span><br />You can now log in.');
        } else {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                    ->withInput();
        }
    }
    
    public function dashboard() {
        $current_month = DB::table('tmp_fin_config')->whereId(1)->first()->current_month;
        $current_year = DB::table('tmp_fin_config')->whereId(1)->first()->current_year;
        
        $billing_performance = Lava::DataTable();
        $billing_performance->addStringColumn('OPCO');
        $billing_performance->addNumberColumn('Year '.$current_year.' Budget');
        $billing_performance->addNumberColumn($current_month.' '.$current_year.' Budget');
        $billing_performance->addNumberColumn($current_month.' '.$current_year.' Actual');
        foreach (AccOpco::where('active', true)->get() as $opco) {
            $year_end_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget;
            $month_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget;
            $month_actual = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual;
            $billing_performance->addRow([$opco->title, $year_end_budget, $month_budget, $month_actual]);
        }
        
        Lava::ColumnChart('Billing Performance', $billing_performance, [
            'title' => 'Billing Performance as at '.$current_month.' '.$current_year,
            'fontName' => 'Poppins',
            'height' => '400',
            'width' => '100%'
        ]);
        
        $gross_margin_performance = Lava::DataTable();
        $gross_margin_performance->addStringColumn('OPCO');
        $gross_margin_performance->addNumberColumn('Year '.$current_year.' Budget');
        $gross_margin_performance->addNumberColumn($current_month.' '.$current_year.' Budget');
        $gross_margin_performance->addNumberColumn($current_month.' '.$current_year.' Actual');
        foreach (AccOpco::where('active', true)->get() as $opco) {
            $year_end_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_end_budget;
            $month_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_budget;
            $month_actual = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_actual;
            $gross_margin_performance->addRow([$opco->title, $year_end_budget, $month_budget, $month_actual]);
        }
        
        Lava::ColumnChart('Gross Margin Performance', $gross_margin_performance, [
            'title' => 'Gross Margin Performance as at '.$current_month.' '.$current_year,
            'fontName' => 'Poppins',
            'height' => '400',
            'width' => '100%'
        ]);
        
        $net_contribution_performance = Lava::DataTable();
        $net_contribution_performance->addStringColumn('OPCO');
        $net_contribution_performance->addNumberColumn('Year '.$current_year.' Budget');
        $net_contribution_performance->addNumberColumn($current_month.' '.$current_year.' Budget');
        $net_contribution_performance->addNumberColumn($current_month.' '.$current_year.' Actual');
        foreach (AccOpco::where('active', true)->get() as $opco) {
            $year_end_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_end_budget;
            $month_budget = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_budget;
            $month_actual = DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_actual;
            $net_contribution_performance->addRow([$opco->title, $year_end_budget, $month_budget, $month_actual]);
        }
        
        Lava::ColumnChart('Net Contribution Performance', $net_contribution_performance, [
            'title' => 'Net Contribution Performance as at '.$current_month.' '.$current_year,
            'fontName' => 'Poppins',
            'height' => '400',
            'width' => '100%'
        ]);
        
        $mid_performance = Lava::DataTable();
        $mid_performance->addStringColumn('Year');
        $mid_performance->addNumberColumn('Budget');
        $mid_performance->addNumberColumn('Actual');
        $mid_performance->addRow([date('Y')-1, 1000000000, 600000000]);
        $mid_performance->addRow([date('Y'), 1500000000, 900000000]);
        
        Lava::ColumnChart('Budget/Actual', $mid_performance, [
            'title' => 'Performance',
            'fontName' => 'Poppins'
        ]);
        
        $client = new Client();
        $res = $client->request('GET', DB::table('acc_config')->whereId(1)->first()->master_url.'/api/getLinks', [
            'query' => [
                'username' => Session::get('halo_user')->username
            ]
        ]);
        $links = json_decode($res->getBody());
        
        return view('dashboard', compact('links'));
    }
    
    public function logout() {
        if (Session::has('halo_user')) {
            $employee = Session::get('halo_user');
            Session::forget('halo_user');
            if (!isset($_SESSION)) session_start();
            unset($_SESSION['halo_user']);
            AccActivity::create([
                'employee_id' => $employee->id, 
                'detail' => 'User logged out.', 
                'source_ip' => $_SERVER["REMOTE_ADDR"]
            ]);
        }
        return Redirect::route('welcome')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />You have logged out.');
    }
}
