<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $pluralLabel = 'Kelas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Kelas'),

                Select::make('mataPelajaran')
                    ->label('Mata Pelajaran')
                    ->multiple()
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->reactive()
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $guruNames = MataPelajaran::whereIn('id', $state)
                            ->with('guru.user')
                            ->get()
                            ->map(fn($mapel) => $mapel->nama_mapel . ' - ' . optional($mapel->guru?->user)->name)
                            ->implode(', ');
                        $set('daftarGuruMapel', $guruNames);
                    }),

                Textarea::make('daftarGuruMapel')
                    ->label('Guru Pengampu Mata Pelajaran')
                    ->disabled()
                    ->dehydrated(false)
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('wali_kelas_id')
                    ->label('Wali Kelas')
                    ->options(function () {
                        return Guru::whereHas('user.roles', function ($q) {
                            $q->where('name', 'Guru');
                        })
                            ->with('user')
                            ->get()
                            ->pluck('user.name', 'id');
                    })
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('waliKelas.user.name')
                    ->label('Wali Kelas')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('mataPelajaran.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->limitList(3)
                    ->bulleted()
                    ->separator(','),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                // Tambah filter jika dibutuhkan
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
            // Tambah RelationManagers jika dibutuhkan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
