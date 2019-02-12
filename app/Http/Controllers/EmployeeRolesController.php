<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\AccEmployee;
use App\AccActivity;
use App\AccEmployeeRole;

class EmployeeRolesController extends Controller
{
    public function index(AccEmployee $employee) {
        $employee_roles = AccEmployeeRole::where('employee_id', $employee->id)->get();
        return view('access.employee_roles.index', compact('employee', 'employee_roles'));
    }
    
    public function create(AccEmployee $employee) {
        return view('access.employee_roles.create', compact('employee'));
    }
    
    public function store(AccEmployee $employee) {
        $input = Input::all();
        $error = "";
        $existing_permissions = AccEmployeeRole::where('role_id', $input['role_id'])->where('employee_id', $employee->id);
        if ($existing_permissions->count() != 0) {
            $error .= "Permission already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error);
        } else {
            $input['employee_id'] = $employee->id;
            unset($input['privileged_link_id']);
            $employee_role = AccEmployeeRole::create($input);
            if ($employee_role) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Permission was created - '.$employee_role->role->privilegedLink->title.' | '.$employee_role->role->title.' for '.$employee->username.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('employees.employee_roles.index', $employee->slug())
                        ->with('success', '<strong>Successful!</strong><br />Permission has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function destroy(AccEmployee $employee, AccEmployeeRole $employee_role) {
        $halo_user = Session::get('halo_user');
        $role = $employee_role->role;
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Permission was deleted - '.$role->privilegedLink->title.' | '.$role->title.' for '.$employee->username.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        $employee_role->delete();
        return Redirect::route('employees.employee_roles.index', $employee->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Permission has been deleted.');
    }
}
