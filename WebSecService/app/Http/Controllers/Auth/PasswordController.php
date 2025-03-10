<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
            DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return back()->with('success', 'Password updated successfully!');
    }}
