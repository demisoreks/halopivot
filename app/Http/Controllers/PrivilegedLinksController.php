<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\AccPrivilegedLink;
use App\AccActivity;
use App\AccRole;

class PrivilegedLinksController extends Controller
{
    public function index() {
        $privileged_links = AccPrivilegedLink::all();
        return view('access.privileged_links.index', compact('privileged_links'));
    }
    
    public function create() {
        return view('access.privileged_links.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_privileged_links = AccPrivilegedLink::where('title', $input['title']);
        if ($existing_privileged_links->count() != 0) {
            $error .= "Privileged link already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            $privileged_link = AccPrivilegedLink::create($input);
            if ($privileged_link) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Privileged link was created - '.$privileged_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('privileged_links.index')
                        ->with('success', '<strong>Successful!</strong><br />Privileged link has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AccPrivilegedLink $privileged_link) {
        return view('access.privileged_links.edit', compact('privileged_link'));
    }
    
    public function update(AccPrivilegedLink $privileged_link) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_privileged_links = AccPrivilegedLink::where('title', $input['title'])->where('id', '<>', $privileged_link->id);
        if ($existing_privileged_links->count() != 0) {
            $error .= "Privileged link already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            if ($privileged_link->update($input)) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Privileged link was updated - '.$privileged_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('privileged_links.index')
                        ->with('success', '<strong>Successful!</strong><br />Privileged link has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AccPrivilegedLink $privileged_link) {
        $input['active'] = false;
        $privileged_link->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Privileged link was disabled - '.$privileged_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('privileged_links.index')
                ->with('success', '<strong>Successful!</strong><br />Privileged link has been disabled.');
    }
    
    public function enable(AccPrivilegedLink $privileged_link) {
        $input['active'] = true;
        $privileged_link->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Privileged link was enabled - '.$privileged_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('privileged_links.index')
                ->with('success', '<strong>Successful!</strong><br />Privileged link has been enabled.');
    }
    
    public function get_roles(int $privileged_link_id) {
        return AccRole::where('privileged_link_id', $privileged_link_id)->where('active', true)->orderBy('title')->get()->toJson();
    }
}
