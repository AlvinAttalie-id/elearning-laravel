<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Models\Kelas;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class SiswaKelas extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $title = 'Daftar Siswa';
    protected static string $view = 'filament.resources.kelas-resource.pages.siswa-kelas';

    public Kelas $kelas;

    public function mount(Kelas $kelas): void
    {
        $this->kelas = $kelas->load('siswa.user');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->kelas->siswa()->getQuery()->with('user')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Action::make('lihatDetail')
                    ->label('Lihat Nilai')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.siswa.detail', ['siswa' => $record->id]))
                    ->color('primary'),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->url(fn($record) => route('export.detail-nilai', ['siswa' => $record->id]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
