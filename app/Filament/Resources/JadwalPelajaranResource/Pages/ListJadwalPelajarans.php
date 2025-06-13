<?php

namespace App\Filament\Resources\JadwalPelajaranResource\Pages;

namespace App\Filament\Resources\JadwalPelajaranResource\Pages;

use App\Filament\Resources\JadwalPelajaranResource;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Actions;


class ListJadwalPelajarans extends ListRecords
{
    protected static string $resource = JadwalPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Select::make('kelas_id')
                        ->label('Pilih Kelas')
                        ->options(Kelas::all()->pluck('nama', 'id'))
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    $kelas = Kelas::findOrFail($data['kelas_id']);
                    $jadwal = JadwalPelajaran::with(['mataPelajaran', 'guru.user'])
                        ->where('kelas_id', $kelas->id)
                        ->orderBy('hari')
                        ->orderBy('jam_mulai')
                        ->get();

                    $pdf = Pdf::loadView('exports.jadwal-pelajaran-pdf', [
                        'kelas' => $kelas,
                        'jadwal' => $jadwal,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'jadwal_pelajaran_' . str($kelas->nama)->slug() . '.pdf'
                    );
                }),
        ];
    }
}
