<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
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
        $existing_employees = AccEmployee::where('username', $input['username']);
        if ($existing_employees->count() != 0) {
            $error .= "Username already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            $employee = AccEmployee::create($input);
            if ($employee) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Employee was created - '.$employee->username.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('employees.index')
                        ->with('success', '<strong>Successful!</strong><br />Employee has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
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
        $existing_employees = AccEmployee::where('username', $input['username'])->where('id', '<>', $employee->id);
        if ($existing_employees->count() != 0) {
            $error .= "Username already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            if ($employee->update($input)) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Employee was updated - '.$employee->username.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('employees.index')
                        ->with('success', '<strong>Successful!</strong><br />Employee has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
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
                ->with('success', '<strong>Successful!</strong><br />Employee has been disabled.');
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
                ->with('success', '<strong>Successful!</strong><br />Employee has been enabled.');
    }
}
