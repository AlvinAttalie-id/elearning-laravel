<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalPelajaranResource\Pages;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class JadwalPelajaranResource extends Resource
{
    protected static ?string $model = JadwalPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $pluralLabel = 'Jadwal Pelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(fn() => \App\Models\Kelas::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive(), // Penting untuk trigger perubahan

                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->options(function (callable $get) {
                        $kelasId = $get('kelas_id');
                        if (!$kelasId) return [];

                        $kelas = \App\Models\Kelas::with('mataPelajaran')->find($kelasId);

                        return $kelas?->mataPelajaran
                            ->pluck('nama_mapel', 'id')
                            ->toArray() ?? [];
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $guruId = \App\Models\MataPelajaran::find($state)?->guru_id;
                        $set('guru_id', $guruId);
                    }),

                Select::make('guru_id')
                    ->label('Guru Pengampu')
                    ->options(function () {
                        return \App\Models\Guru::with('user')->get()
                            ->pluck('user.name', 'id');
                    })
                    ->disabled()
                    ->dehydrated() // tetap dikirim ke server meskipun disabled
                    ->required(),

                Select::make('hari')
                    ->label('Hari')
                    ->required()
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ]),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->required(),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kelas.nama')->label('Kelas')->sortable()->searchable(),
                TextColumn::make('mataPelajaran.nama_mapel')->label('Mata Pelajaran')->sortable()->searchable(),
                TextColumn::make('guru.user.name')->label('Guru Pengampu')->sortable()->searchable(),
                TextColumn::make('hari')->label('Hari'),
                TextColumn::make('jam_mulai')->label('Mulai'),
                TextColumn::make('jam_selesai')->label('Selesai'),
            ])
            ->filters([
                //
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalPelajarans::route('/'),
            'create' => Pages\CreateJadwalPelajaran::route('/create'),
            'edit' => Pages\EditJadwalPelajaran::route('/{record}/edit'),
        ];
    }
}
