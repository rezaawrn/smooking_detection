<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{
    public function store(Request $request)
    {
        if(!$request->hasFile('image')){
            return response()->json(['status' => 'error']);
        }

        $file = $request->file('image');
        $path = $file->store('pelanggaran', 'public');

        DB::table('pelanggarans')->insert([
            'image_path' => $path,
            'keterangan' => $request->keterangan ?? 'Tidak diketahui',
            'detected_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['status' => 'success']);
    }

    public function index()
    {
        $data = \DB::table('pelanggarans')
            ->orderBy('detected_at', 'desc')
            ->get();
            
        return view('pages.monitoring-pelanggaran', [
            'data' => $data,
            'type_menu' => 'pelanggaran'
        ]);
    }

    public function destroy($id)
    {
        try {
            $data = DB::table('pelanggarans')->where('id', $id)->first();

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
            }

            // hapus file
            if ($data->image_path && Storage::disk('public')->exists($data->image_path)) {
                Storage::disk('public')->delete($data->image_path);
            }

            // hapus database
            DB::table('pelanggarans')->where('id', $id)->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}