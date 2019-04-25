<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\AccRole;
use App\AccActivity;
use App\AccPrivilegedLink;

class RolesController extends Controller
{
    public function index(AccPrivilegedLink $privileged_link) {
        $roles = AccRole::where('privileged_link_id', $privileged_link->id)->get();
        return view('access.roles.index', compact('privileged_link', 'roles'));
    }
    
    public function create(AccPrivilegedLink $privileged_link) {
        return view('access.roles.create', compact('privileged_link'));
    }
    
    public function store(AccPrivilegedLink $privileged_link) {
        $input = Input::all();
        $error = "";
        $existing_roles = AccRole::where('title', $input['title'])->where('privileged_link_id', $privileged_link->id);
        if ($existing_roles->count() != 0) {
            $error .= "Role already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $input['privileged_link_id'] = $privileged_link->id;
            $role = AccRole::create($input);
            if ($role) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Role was created - '.$role->title.' for '.$privileged_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('privileged_links.roles.index', $privileged_link->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Role has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AccPrivilegedLink $privileged_link, AccRole $role) {
        return view('access.roles.edit', compact('privileged_link', 'role'));
    }
    
    public function update(AccPrivilegedLink $privileged_link, AccRole $role) {
        $input = Input::all();
        $error = "";
        $existing_roles = AccRole::where('title', $input['title'])->where('privileged_link_id', $privileged_link->id)->where('id', '<>', $role->id);
        if ($existing_roles->count() != 0) {
            $error .= "Role already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($role->update($input)) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Role was uupdated - '.$role->title.' for '.$privileged_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('privileged_links.roles.index', $privileged_link->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Role has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AccPrivilegedLink $privileged_link, AccRole $role) {
        $input['active'] = false;
        $role->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Role was disabled - '.$role->title.' for '.$privileged_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('privileged_links.roles.index', $privileged_link->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Role has been disabled.');
    }
    
    public function enable(AccPrivilegedLink $privileged_link, AccRole $role) {
        $input['active'] = true;
        $role->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Role was enabled - '.$role->title.' for '.$privileged_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('privileged_links.roles.index', $privileged_link->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Role has been enabled.');
    }
}
