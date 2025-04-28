<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Artisan;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordResetLinkMail;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use ValidatesRequests;

    public function list(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('show_users')) abort(401);

        $query = User::select('*');
        if ($request->filled('keywords')) {
            $query->where('name', 'like', '%' . $request->keywords . '%')
                  ->orWhere('email', 'like', '%' . $request->keywords . '%');
        }
        $users = $query->paginate(10);

        return view('users.list', compact('users'));
    }

    public function register(Request $request)
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->credit = 0.00;
        $user->save();

        $customerRole = Role::findByName('Customer');
        $user->syncRoles([$customerRole]);

        if (!$customerRole->hasPermissionTo('purchase_products')) {
            $customerRole->givePermissionTo('purchase_products');
            Artisan::call('cache:clear');
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    // public function doLogin(Request $request)
    // {
    //     if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
    //     }

    //     $user = User::where('email', $request->email)->first();
    //     Auth::setUser($user);

    //     return redirect('/');
    // }
    public function doLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->is_blocked) {
            Auth::logout();
            return redirect()->route('login')->withErrors('Your account has been blocked by an admin.');
        }

        // تسجيل الإجراء
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Login',
            'description' => "User {$user->name} logged in.",
        ]);

        return redirect()->route('profile')->with('success', 'Logged in successfully!');
    }

    return redirect()->back()->withErrors('Invalid email or password.');
}
    public function doLogout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('show_users')) {
                return redirect()->route('users_list');
            }
        }

        $permissions = [];
        foreach ($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        $purchases = $user->hasRole('Customer') ? Purchase::where('user_id', $user->id)->with('product')->paginate(10) : collect([]);

        return view('users.profile', compact('user', 'permissions', 'purchases'));
    }

    public function edit(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach (Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
    
        $user = User::findOrFail($request->id);
    
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'roles' => ['required', 'array'],
        ]);
    
        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $this->validate($request, [
                'password' => ['string', 'min:6', 'confirmed'],
            ]);
            $user->password = bcrypt($request->password);
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
    
        if (auth()->user()->hasRole('Admin')) {
            $user->syncRoles($request->roles);
    
            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            } else {
                $user->syncPermissions([]);
            }
        }
    
        return redirect()->route('users_list')->with('success', 'User updated successfully.');
    }

    public function delete(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('delete_users')) abort(401);

        if ($user->id === auth()->user()->id) {
            return redirect()->back()->withErrors('You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users_list')->with('success', 'User deleted successfully!');
    }

    public function editPassword(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user)
    {
        if (auth()->id() == $user?->id) {
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                Auth::logout();
                return redirect('/');
            }
        } else if (!auth()->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users_list');
    }

    public function createEmployee()
    {
        if (!auth()->user()->hasPermissionTo('create_employee')) {
            \Log::error('Unauthorized attempt to create employee by user ID: ' . auth()->user()->id);
            abort(403, 'Unauthorized action.');
        }

        return view('users.create_employee');
    }

    public function storeEmployee(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create_employee')) {
            \Log::error('Unauthorized attempt to store employee by user ID: ' . auth()->user()->id);
            abort(403, 'Unauthorized action.');
        }
    
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        $employee = new User();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = bcrypt($request->password);
        $employee->save();
    
        $employee->assignRole('Employee');
    
        \Log::info('Employee created successfully: User ID ' . $employee->id);
    
        return redirect()->route('users_list')->with('success', 'Employee created successfully!');
    }

    public function listCustomers(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('show_users')) {
            abort(403, 'Unauthorized action.');
        }

        $customerRoleId = \DB::table('roles')->where('name', 'Customer')->value('id');
        $customerIds = \DB::table('model_has_roles')
            ->where('role_id', $customerRoleId)
            ->where('model_type', 'App\\Models\\User')
            ->pluck('model_id');

        $customers = User::whereIn('id', $customerIds)->paginate(10);

        return view('users.customers', compact('customers'));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->withErrors('You do not have permission to change passwords.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users_list')->with('success', 'Password updated successfully!');
    }

    public function addCredit(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('add_credit_to_customers')) {
            \Log::error('Unauthorized attempt to add credit by user ID: ' . auth()->user()->id);
            abort(403, 'Unauthorized action.');
        }

        if (!$user->hasRole('Customer')) {
            \Log::error('Attempt to add credit to non-customer: User ID ' . $user->id . ' does not have Customer role.');
            return redirect()->back()->withErrors('You can only add credit to customers.');
        }

        $request->validate([
            'credit' => ['required', 'numeric', 'min:0'],
        ]);

        $user->credit += $request->credit;
        $user->save();

        \Log::info('Credit added successfully: User ID ' . $user->id . ', Credit Added: ' . $request->credit . ', New Credit: ' . $user->credit);

        return redirect()->route('customers_list')->with('success', 'Credit added successfully.');
    }

    public function resetCredit(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('Employee')) {
            abort(403, 'Only Employees can reset credit.');
        }

        if ($user->hasRole('Customer') && !$user->hasRole('Admin') && !$user->hasRole('Employee')) {
            $user->credit = 0;
            $user->save();
            return redirect()->route('users_list')->with('success', 'Credit reset successfully!');
        }

        return redirect()->back()->withErrors('You can only reset credit for customers.');
    }

    public function showForgetPasswordForm()
    {
        return view('users.forget_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = route('password.reset', ['token' => $token, 'email' => $user->email]);

        Mail::to($user->email)->send(new PasswordResetLinkMail($resetLink));
        return redirect()->back()->with('success', 'A password reset link has been sent to your email.');
    }

    public function showResetPasswordForm(Request $request)
{
    $token = $request->query('token');
    $email = $request->query('email');

    if (!$token || !$email) {
        \Log::warning('Invalid reset link: Token or Email missing', ['token' => $token, 'email' => $email]);
        return redirect()->route('password.request')->withErrors('Invalid reset link.');
    }

    \Log::info('Processing reset link: Token=' . $token . ', Email=' . $email);
    return view('users.reset_password', compact('token', 'email'));
}
public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'token' => 'required',
        'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
    ]);

    $reset = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$reset || now()->diffInHours($reset->created_at) > 1) {
        return redirect()->back()->withErrors('Invalid or expired token.');
    }

    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    DB::table('password_resets')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
}

public function test()
{
    $users = \App\Models\User::all();

    return view('test', compact('users'));
}

public function blockUser(Request $request, User $user)
{
    if (!auth()->user()->hasRole('Admin')) {
        abort(403, 'Only Admins can block users.');
    }

    if ($user->hasRole('Admin')) {
        return redirect()->back()->withErrors('You cannot block an Admin.');
    }

    $user->is_blocked = true;
    $user->save();

    // حذفنا السطر دا: Auth::logoutOtherDevices($user->password);

    \App\Models\ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'Block User',
        'description' => "Admin blocked user {$user->name} (ID: {$user->id}).",
    ]);

    return redirect()->route('users_list')->with('success', 'User blocked successfully!');
}
public function unblockUser(Request $request, User $user)
{
    if (!auth()->user()->hasRole('Admin')) {
        abort(403, 'Only Admins can unblock users.');
    }

    $user->is_blocked = false;
    $user->save();

    // تسجيل الإجراء
    \App\Models\ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'Unblock User',
        'description' => "Admin unblocked user {$user->name} (ID: {$user->id}).",
    ]);

    return redirect()->route('users_list')->with('success', 'User unblocked successfully!');
}

public function activityLogs()
{
    if (!auth()->user()->hasRole('Admin')) {
        abort(403, 'Only Admins can view activity logs.');
    }

    $logs = \App\Models\ActivityLog::with('user')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('users.activity_logs', compact('logs'));
}
}