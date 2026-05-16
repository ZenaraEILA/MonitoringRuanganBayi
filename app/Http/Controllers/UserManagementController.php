<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * ✅ Display list of all users
     */
    public function index()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.users.index', [
                'users' => $users,
                'totalUsers' => User::count(),
                'totalAdmins' => User::where('role', 'admin')->count(),
                'totalPetugas' => User::where('role', 'petugas')->count(),
                'totalPublic' => User::where('role', 'public')->count(),
                'activeUsers' => User::where('is_active', true)->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('User Management Index Error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Gagal memuat data user.');
        }
    }

    /**
     * Show form to create new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,petugas,public',
            'job_title' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        $securityCode = Str::random(20);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'] ?? null,
            'hospital_id' => $request->hospital_id,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'job_title' => $validated['job_title'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'is_on_about_page' => $request->has('is_on_about_page'),
            'security_code' => $securityCode,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
            'canChangeRole' => Auth::user()->canChangeRoleOf($user),
        ]);
    }

    /**
     * Show form to edit user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,petugas,public',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'hospital_id' => $request->hospital_id,
            'role' => $validated['role'],
            'job_title' => $request->job_title,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'is_on_about_page' => $request->has('is_on_about_page'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Delete user account
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus diri sendiri.');
        }

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) return redirect()->back()->with('error', 'Pilih user terlebih dahulu.');

        $ids = array_filter($ids, fn($id) => (int)$id !== (int)Auth::id());
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            if ($user->profile_photo_path) Storage::disk('public')->delete($user->profile_photo_path);
            $user->delete();
        }

        return redirect()->route('admin.users.index')->with('success', count($ids) . ' akun dihapus.');
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate(['role' => 'required|in:admin,petugas,public']);
        if ($user->id === Auth::id()) return redirect()->back()->with('error', 'Gagal.');

        $user->updateRole($validated['role']);
        return redirect()->back()->with('success', 'Role diperbarui.');
    }

    /**
     * Deactivate user
     */
    public function deactivateUser(User $user)
    {
        if ($user->id === Auth::id()) return redirect()->back()->with('error', 'Gagal.');
        $user->deactivate();
        return redirect()->back()->with('success', 'User dinonaktifkan.');
    }

    /**
     * Activate user
     */
    public function activateUser(User $user)
    {
        $user->activate();
        return redirect()->back()->with('success', 'User diaktifkan.');
    }

    /**
     * Refresh Security Code
     */
    public function refreshSecurityCode(User $user)
    {
        $user->update(['security_code' => Str::random(20)]);
        return redirect()->back()->with('success', 'Code diperbarui.');
    }
}
