<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::withCount(['users', 'permissions'])->latest();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('guard_name', function ($role) {
                    return '<span class="badge badge-secondary">' . $role->guard_name . '</span>';
                })
                ->addColumn('users_count_link', function ($role) {
                    if ($role->users_count > 0) {
                        return '<a href="javascript:void(0)" class="badge badge-info view-users" data-id="' . $role->id . '" style="cursor: pointer; font-size: 14px;">
                            ' . $role->users_count . ' <i class="fas fa-external-link-alt ml-1"></i>
                        </a>';
                    }
                    return '<span class="badge badge-secondary">' . $role->users_count . '</span>';
                })
                ->addColumn('permissions_count_expand', function ($role) {
                    if ($role->permissions_count > 0) {
                        return '<a href="javascript:void(0)" class="badge badge-success expand-permissions" data-id="' . $role->id . '" style="cursor: pointer; font-size: 14px;">
                            ' . $role->permissions_count . ' <i class="fas fa-chevron-down ml-1"></i>
                        </a>';
                    }
                    return '<span class="badge badge-secondary">' . $role->permissions_count . '</span>';
                })
                ->addColumn('created_at', function ($role) {
                    return $role->created_at->format('d M Y');
                })
                ->addColumn('action', function ($role) {
                    $editBtn = '<a href="' . route('admin.roles.edit', $role->id) . '" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>';

                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $role->id . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>';

                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['guard_name', 'users_count_link', 'permissions_count_expand', 'action'])
                ->make(true);
        }

        return view('auth.roles.index');
    }

    public function getUsersByRole($id)
    {
        $role = Role::findOrFail($id);
        $users = $role->users()->select('id', 'name', 'username','namadesa', 'created_at')->get();

        return response()->json([
            'role_name' => $role->name,
            'users' => $users
        ]);
    }

    public function getPermissionsByRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions()->select('id', 'name', 'guard_name')->get();

        return response()->json([
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        // Group permissions berdasarkan prefix (sebelum tanda -)
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'other';
        });

        return view('auth.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        // Group permissions berdasarkan prefix
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'other';
        });

        // Ambil permissions yang sudah dimiliki role
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('auth.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $validated['name'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diupdate');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus'
        ]);
    }

}
