<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TugasResource\Pages;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class TugasResource extends Resource
{
    protected static ?string $model = Tugas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $pluralLabel = 'Tugas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(Kelas::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive(),

                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->options(function (callable $get) {
                        $kelasId = $get('kelas_id');
                        if (!$kelasId) return [];

                        $kelas = Kelas::with('mataPelajaran')->find($kelasId);

                        return $kelas?->mataPelajaran->pluck('nama_mapel', 'id') ?? [];
                    })
                    ->required()
                    ->searchable(),

                TextInput::make('judul')
                    ->label('Judul Tugas')
                    ->required()
                    ->maxLength(255),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(4),

                DatePicker::make('tanggal_deadline')
                    ->label('Tanggal Deadline')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kelas.nama')->label('Kelas')->sortable()->searchable(),
                TextColumn::make('mapel.nama_mapel')->label('Mata Pelajaran')->sortable()->searchable(),
                TextColumn::make('judul')->label('Judul')->limit(30)->searchable(),
                TextColumn::make('tanggal_deadline')->label('Deadline')->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\TugasResource\RelationManagers\JawabanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTugas::route('/'),
            'create' => Pages\CreateTugas::route('/create'),
            'edit' => Pages\EditTugas::route('/{record}/edit'),
        ];
    }
}
