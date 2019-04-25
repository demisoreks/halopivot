<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use Mail;
use App\AccEmployee;
use App\AccActivity;

class EmployeesController extends Controller
{
    public function index() {
        $employees = AccEmployee::all();
        return view('access.employees.index', compact('employees'));
    }
    
    public function create() {
        return view('access.employees.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $raw_password = $input['password2'];
        unset($input['password2']);
        $existing_employees = AccEmployee::where('username', $input['username']);
        if ($existing_employees->count() != 0) {
            $error .= "Username already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if (isset($input['password']) && $input['password'] != "") {
                $input['salt'] = substr(LoginController::hashPassword($input['username'], 7), 10, 50);
                $input['password'] = LoginController::hashPassword($input['password'].$input['salt'], 8);
            } else {
                unset($input['password']);
            }
            $employee = AccEmployee::create($input);
            if ($employee) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Employee was created - '.$employee->username.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                
                if (isset($input['password']) && $input['password'] != "") {
                    $name = explode('.', $input['username']);
                    
                    $email_data = [
                        'first_name' => strtoupper($name[0]),
                        'link' => 'http://halopivot.halogensecurity.com',
                        'username' => $input['username'],
                        'password' => $raw_password
                    ];
                    
                    $recipient = $input['username'].'@halogensecurity.com';

                    Mail::send('emails.new_user', $email_data, function ($m) use ($recipient) {
                        $m->from('hens@halogensecurity.com', 'Halogen e-Notification Service');
                        $m->to($recipient)->subject('Welcome to HaloPivot!');
                    });
                }
                
                return Redirect::route('employees.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Employee has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AccEmployee $employee) {
        return view('access.employees.edit', compact('employee'));
    }
    
    public function update(AccEmployee $employee) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $raw_password = $input['password2'];
        unset($input['password2']);
        $existing_employees = AccEmployee::where('username', $input['username'])->where('id', '<>', $employee->id);
        if ($existing_employees->count() != 0) {
            $error .= "Username already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if (isset($input['password']) && $input['password'] != "") {
                $input['salt'] = substr(LoginController::hashPassword($input['username'], 7), 10, 50);
                $input['password'] = LoginController::hashPassword($input['password'].$input['salt'], 8);
            } else {
                unset($input['password']);
            }
            if ($employee->update($input)) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Employee was updated - '.$employee->username.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                
                if (isset($input['password']) && $input['password'] != "") {
                    $name = explode('.', $input['username']);
                    
                    $email_data = [
                        'first_name' => strtoupper($name[0]),
                        'link' => 'http://halopivot.halogensecurity.com',
                        'username' => $input['username'],
                        'password' => $raw_password
                    ];
                    
                    $recipient = $input['username'].'@halogensecurity.com';

                    Mail::send('emails.password_reset', $email_data, function ($m) use ($recipient) {
                        $m->from('hens@halogensecurity.com', 'Halogen e-Notification Service');
                        $m->to($recipient)->subject('HaloPivot Password Reset');
                    });
                }
                
                return Redirect::route('employees.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Employee has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AccEmployee $employee) {
        $input['active'] = false;
        $employee->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Employee was disabled - '.$employee->username.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('employees.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Employee has been disabled.');
    }
    
    public function enable(AccEmployee $employee) {
        $input['active'] = true;
        $employee->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Employee was enabled - '.$employee->username.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('employees.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Employee has been enabled.');
    }
}
