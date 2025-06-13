<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Siswa & Guru';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $modelLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Nama User')
                    ->required(),

                Forms\Components\TextInput::make('nis')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),

                Forms\Components\TextInput::make('alamat')
                    ->required(),

                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(function () {
                        return Kelas::withCount('siswa')
                            ->get()
                            ->filter(fn($kelas) => $kelas->siswa_count < 10)
                            ->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('Email'),

                TextColumn::make('nis')
                    ->label('NIS'),

                TextColumn::make('user.roles.name')
                    ->label('Role')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'murid');
            });
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }

    /**
     * Validasi custom saat membuat siswa
     */
    public static function beforeCreate(array $data): void
    {
        $kelas = Kelas::withCount('siswa')->find($data['kelas_id']);
        if ($kelas && $kelas->siswa_count >= 10) {
            throw ValidationException::withMessages([
                'kelas_id' => 'Kelas ini sudah penuh. Maksimal hanya 10 siswa.',
            ]);
        }
    }

    public static function beforeUpdate(array $data, Siswa $record): void
    {
        // Cek hanya jika user mencoba ganti kelas
        if ($data['kelas_id'] != $record->kelas_id) {
            $kelas = Kelas::withCount('siswa')->find($data['kelas_id']);
            if ($kelas && $kelas->siswa_count >= 10) {
                throw ValidationException::withMessages([
                    'kelas_id' => 'Kelas ini sudah penuh. Maksimal hanya 10 siswa.',
                ]);
            }
        }
    }
}
