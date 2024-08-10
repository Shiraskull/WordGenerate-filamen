<?php

namespace App\Filament\Resources\WordGenerateResource\Pages;

use App\Filament\Resources\WordGenerateResource;
use App\Models\WordGene;
use App\Models\WordGnerate;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Response;

class DownloadWord extends Page
{
    protected static string $resource = WordGenerateResource::class;
    public WordGnerate $record;

    public function mount($record)
    {
        // $this->record = WordGnerate::findOrFail($record);
        // dd($record);

        if ($record) {
            $filePath = public_path($record->kabupaten. '.docx');

            // Pastikan file ada sebelum mencoba mengunduhnya
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            // Jika file tidak ada, bisa mengarahkan ke halaman lain atau memberikan pesan kesalahan
            // session()->flash('error', 'File tidak ditemukan.');
        }

        return redirect()->route('filament.resources.word-generate.index');
    }
    protected static string $view = 'filament.resources.word-generates.index';
    // Jika ada view khusus, pastikan diinisialisasi
    // protected static string $view = 'filament.resources.word-generate-resource.pages.download-word';
}

