<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListKelas extends ListRecords
{
    protected static string $resource = KelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('export_kelas_mapel')
                ->label('Export Kelas & Mapel')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Select::make('kelas_id')
                        ->label('Pilih Kelas (boleh banyak)')
                        ->options(Kelas::all()->pluck('nama', 'id'))
                        ->multiple()
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    $daftarKelas = Kelas::with([
                        'waliKelas.user',
                        'mataPelajaran.guru.user',
                    ])
                        ->whereIn('id', $data['kelas_id'])
                        ->get();

                    $pdf = Pdf::loadView('exports.kelas-mapel-pdf', [
                        'daftarKelas' => $daftarKelas,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'kelas_mapel.pdf'
                    );
                }),


            Action::make('export_wali_siswa')
                ->label('Export Wali & Siswa')
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->form([
                    Select::make('kelas_id')
                        ->label('Pilih 1 Kelas')
                        ->options(Kelas::all()->pluck('nama', 'id'))
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    $kelas = Kelas::with([
                        'waliKelas.user',
                        'siswa.user',
                    ])->findOrFail($data['kelas_id']);

                    $pdf = Pdf::loadView('exports.kelas-siswa-pdf', compact('kelas'));

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'wali_siswa_' . str($kelas->nama)->slug() . '.pdf'
                    );
                }),
        ];
    }
}
