<?php

namespace App\Filament\Resources\WordGenerateResource\Pages;

use App\Filament\Resources\WordGenerateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWordGenerate extends EditRecord
{
    protected static string $resource = WordGenerateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
