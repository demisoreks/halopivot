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

use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function index() {
        return view('welcome');
    }
    
    public function authenticate() {
        $input = Input::all();
        $employees = AccEmployee::where('username', $input['username']);
        if ($employees->count() != 0) {
            $employee = $employees->first();
            // authentication
            if ($input['password'] == "123456") {
                if ($employee->active) {
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
                            ->with('error', '<strong>Login error!</strong><br />User account is inactive.');
                }
            } else {
                $login_attempts = $employee->login_attempts + 1;
                $employee->update(['login_attempts' => $login_attempts, 'last_attempt' => date('Y-m-d H:i:s')]);
                return Redirect::back()
                        ->with('error', '<strong>Login error!</strong><br />Invalid password.');
            }
        } else {
            return Redirect::back()
                    ->with('error', '<strong>Login error!</strong><br />User does not exist.');
        }
    }
    
    static function checkAccess() {
        if (Session::has('halo_user')) {
            return true;
        } else {
            return false;
        }
    }
    
    public function dashboard() {
        $performance = Lava::DataTable();
        $performance->addStringColumn('OPCO');
        $performance->addNumberColumn('Budget');
        $performance->addNumberColumn('Actual');
        $performance->addRow(['Academy', 1000000000, 600000000]);
        $performance->addRow(['Armada', 1500000000, 900000000]);
        $performance->addRow(['ArmourX', 600000000, 350000000]);
        $performance->addRow(['Avant', 600000000, 250000000]);
        $performance->addRow(['Avert', 900000000, 700000000]);
        $performance->addRow(['PS', 2500000000, 1350000000]);
        
        Lava::ColumnChart('Performance', $performance, [
            'title' => 'YTD Performance'
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
