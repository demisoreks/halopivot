<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccEmployee;
use App\AccEmployeeRole;

class ApisController extends Controller
{
    public function get_roles(Request $request) {
        $employee = AccEmployee::where('username', $request->username)->first();
        $employee_roles = AccEmployeeRole::where('employee_id', $employee->id)->get();
        $result = [];
        foreach ($employee_roles as $employee_role) {
            if ($request->link_id == $employee_role->role->privilegedLink->id && $employee_role->role->privilegedLink->active && $employee_role->role->active) {
                array_push($result, $employee_role->role->title);
            }
        }
        return $result;
    }
    
    public function get_links(Request $request) {
        $employee = AccEmployee::where('username', $request->username)->first();
        $employee_roles = AccEmployeeRole::where('employee_id', $employee->id)->get();
        $result = [];
        foreach ($employee_roles as $employee_role) {
            $new = [
                "order_no" => $employee_role->role->privilegedLink->order_no,
                "title" => $employee_role->role->privilegedLink->title,
                "url" => $employee_role->role->privilegedLink->url
            ];
            if (!in_array($new, $result) && $employee_role->role->privilegedLink->active) {    
                array_push($result, $new);
            }
        }
        $order = [];
        foreach ($result as $key => $row) {
            $order[$key] = $row['order_no'];
        }
        array_multisort($order, SORT_ASC, $result);
        return $result;
    }
}
