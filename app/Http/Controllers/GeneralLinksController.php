<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\AccGeneralLink;
use App\AccActivity;

class GeneralLinksController extends Controller
{
    public function index() {
        $general_links = AccGeneralLink::all();
        return view('access.general_links.index', compact('general_links'));
    }
    
    public function create() {
        return view('access.general_links.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_general_links = AccGeneralLink::where('title', $input['title']);
        if ($existing_general_links->count() != 0) {
            $error .= "General link already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $general_link = AccGeneralLink::create($input);
            if ($general_link) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'General link was created - '.$general_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('general_links.index')
                        ->with('success', '<span class="font-weight-bold">Oops!</span><br />General link has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AccGeneralLink $general_link) {
        return view('access.general_links.edit', compact('general_link'));
    }
    
    public function update(AccGeneralLink $general_link) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_general_links = AccGeneralLink::where('title', $input['title'])->where('id', '<>', $general_link->id);
        if ($existing_general_links->count() != 0) {
            $error .= "General link already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($general_link->update($input)) {
                $halo_user = Session::get('halo_user');
                AccActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'General link was updated - '.$general_link->title.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('general_links.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />General link has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AccGeneralLink $general_link) {
        $input['active'] = false;
        $general_link->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'General link was disabled - '.$general_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('general_links.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />General link has been disabled.');
    }
    
    public function enable(AccGeneralLink $general_link) {
        $input['active'] = true;
        $general_link->update($input);
        $halo_user = Session::get('halo_user');
        AccActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'General link was enabled - '.$general_link->title.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('general_links.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />General link has been enabled.');
    }
}
