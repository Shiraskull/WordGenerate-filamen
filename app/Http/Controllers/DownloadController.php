<?php

namespace App\Http\Controllers;

use App\Models\WordGnerate;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function docx($record){
        // dd($record);
        $data = WordGnerate::findOrFail($record);
        // dd($data);

        if ($record) {
            $filePath = public_path($data->path);

            // Pastikan file ada sebelum mencoba mengunduhnya
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            // Jika file tidak ada, bisa mengarahkan ke halaman lain atau memberikan pesan kesalahan
            // session()->flash('error', 'File tidak ditemukan.');
        }

        return redirect()->route('filament.resources.word-generate.index');
    }
}
