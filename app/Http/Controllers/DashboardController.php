<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DashboardController extends Controller
{
    public function edit_profile(){
        return view('admin.profile.edit');
    }

    public function update_profile(Request $request){

        $user = array(
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "about_supplier" => $request->about_supplier,
        );

        User::whereId(auth()->user()->id)->update($user);

        return back()->with("success", "Profile successfully updated.");
    }

    public function change_password(){
        return view('admin.profile.change_password');
    }

    public function change_password_post(Request $request){
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = array(
            "password" => Hash::make($request->new_password),
        );

        User::whereId(auth()->user()->id)->update($user);

        return back()->with("success", "Password change successfully.");
    }
}
