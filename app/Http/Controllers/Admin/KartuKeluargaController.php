<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        return view('admin.kependudukan.kartukeluarga.index');
    }

    public function indexData(Request $request)
    {
        if ($request->ajax()) {

            $desaId = auth()->user()->desa;
            $userId = auth()->user()->id;

            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->leftJoin('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->where('t1.sts_hub_kel', 1)
                ->where('t2.desa', $desaId)
                ->where('t1.sts_mati', 0)
                ->where('t3.id', $userId)
                ->select([
                    't2.id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    't1.nama as nama',
                    't1.tgl_lahir as tgl_lahir',
                    't1.tmpt_lahir as tmpt_lahir',
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't1.created_at',
                    't1.id as anggota_id'
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('tmpt_lahir', fn($row) => strtoupper($row->tmpt_lahir))
                ->editColumn('tgl_lahir', fn($row) => date('d-m-Y', strtotime($row->tgl_lahir)))
                ->addColumn('alamat', function($row) {
                    return strtoupper(
                        $row->kp . ', RT. ' . $row->rt . '/' . $row->rw .
                        ', DS. ' . $row->desa . ', KEC. ' . $row->kecamatan
                    );
                })
                ->addColumn('aksi', function ($row) {

                    $viewUrl   = route('kependudukan.kartu.keluarga.show', $row->id);
                    $editUrl   = route('kependudukan.kartu.keluarga.edit', $row->anggota_id);
                    $deleteUrl = route('kependudukan.kartu.keluarga.delete', $row->anggota_id);

                    return '
                        <div class="btn-group btn-group-sm text-center" role="group">
                            <a href="'.$viewUrl.'"
                            class="btn bg-gradient-info"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="Lihat">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="'.$editUrl.'"
                            class="btn bg-gradient-warning"
                            title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button type="button"
                                class="btn bg-gradient-danger"
                                title="Hapus"
                                onclick="deleteData('.$row->id.')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function crceate()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function delete($id)
    {
        $data = DB::table('t_kartu_keluarga_anggota')->where('id', $id)->first();
        dd($data);
    }
}