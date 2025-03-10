<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); 
        return view('profile', compact('user')); 
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password); // تحديث كلمة المرور
            $user->save();

            return redirect()->back()->with('success', 'تم تحديث كلمة المرور بنجاح.');
        }

        return redirect()->back()->with('error', 'كلمة المرور القديمة غير صحيحة.');
    }
}