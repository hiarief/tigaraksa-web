<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->latest();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function($user) {
                    $roles = '';
                    foreach ($user->roles as $role) {
                        $roles .= '<span class="badge badge-info mr-1">' . $role->name . '</span>';
                    }
                    return $roles;
                })
                ->addColumn('created_at', function($user) {
                    return $user->created_at->format('d M Y');
                })
                ->addColumn('action', function($user) {
                    $editBtn = '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(' . $user->id . ')"><i class="fas fa-trash"></i> Delete</button>';

                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        return view('auth.users.index');
    }

    public function create()
    {
        $desa = DB::table('indonesia_villages')->where('district_code', 360303)->get();
        $roles = Role::all();
        return view('auth.users.create', compact('roles', 'desa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'desa' => 'required|exists:indonesia_villages,code',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => 'array',
        ]);

        $village = DB::table('indonesia_villages')
            ->where('code', $validated['desa'])
            ->first();

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'desa' => $validated['desa'],
            'namadesa' => $village->name,
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        $desa = DB::table('indonesia_villages')
            ->where('district_code', 360303)
            ->orderBy('name')
            ->get();

        return view('auth.users.edit', compact('user', 'roles', 'desa'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'desa' => 'required|exists:indonesia_villages,code',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'roles' => 'required|array|min:1',
        ], [
            'roles.required' => 'Pilih minimal satu role',
            'roles.min' => 'Pilih minimal satu role',
            'desa.required' => 'Desa harus dipilih',
            'desa.exists' => 'Desa tidak valid',
        ]);

        // Get village name
        $village = DB::table('indonesia_villages')
            ->where('code', $validated['desa'])
            ->first();

        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'desa' => $validated['desa'],
            'namadesa' => $village->name,
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
