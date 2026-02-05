<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $permissions = Permission::withCount('roles');

            return DataTables::of($permissions)
                ->addIndexColumn()

                ->editColumn('guard_name', function($permission) {
                    return '<span class="badge badge-secondary">'.$permission->guard_name.'</span>';
                })

                ->editColumn('roles_count', function($permission) {
                    return $permission->roles_count . ' role(s)';
                })

                ->editColumn('created_at', function($permission) {
                    return $permission->created_at->format('d M Y');
                })

                ->addColumn('action', function($permission) {

                    $editBtn = '<a href="'.route('admin.permissions.edit', $permission->id).'" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';

                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger btn-delete"
                                    data-id="'.$permission->id.'">
                                    <i class="fas fa-trash"></i> Delete
                                </button>';

                    return $editBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['guard_name','action'])

                ->make(true);
        }

        return view('auth.permissions.index');
    }


    public function create()
    {
        return view('auth.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('auth.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diupdate');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission berhasil dihapus'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $deletedCount = Permission::whereIn('id', $validated['ids'])->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' permission berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus permission: ' . $e->getMessage()
            ], 500);
        }
    }
}
