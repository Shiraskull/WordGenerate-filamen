<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\WordGenerateResource\Pages;
use App\Filament\Resources\WordGenerateResource\RelationManagers;
use App\Models\WordGenerate;
use App\Models\WordGnerate;
use DateTime;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

use function Laravel\Prompts\text;

class WordGenerateResource extends Resource
{
    protected static ?string $model = WordGnerate::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Judul')
                    ->columns(2)
                    ->schema([
                        TextInput::make('judul')
                        ->columnSpanFull(),
                        // DatePicker::make('tanggal'),
                    ]),
                    // Step::make('awal')
                    // ->columns(2)
                    // ->schema([
                    //     TextInput::make('title')
                    //     ->Label('Kabupaten'),
                    //     TextInput::make('kepaladinas')
                    //         ->label('Kepala Dinas'),
                    //     FileUpload::make('foto_dinas')
                    // ]),
                    Step::make('Bab 1')
                    ->schema([
                        TinyEditor::make('latar_belakang'),
                        TinyEditor::make('tujuan'),
                        TinyEditor::make('strategis'),
                        TinyEditor::make('demografi'),
                    ]),
                    // Step::make('Bab 2')
                    // ->schema([
                    //     Textarea::make('latarbelakang'),
                    // ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kabupaten'),
                TextColumn::make('created_at')
                    ->label('Tanggal'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('download')
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Download')
                ->url(fn (WordGnerate $record): string => route('download.docx', $record))
        ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWordGenerates::route('/'),
            'create' => Pages\CreateWordGenerate::route('/create'),
            'edit' => Pages\EditWordGenerate::route('/{record}/edit'),
            'download' => Pages\DownloadWord::route('/{record}/download'),
        ];
    }
}
