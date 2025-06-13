<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;


class ListKelas extends ListRecords
{
    protected static string $resource = KelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                // form filter: pilih kelas
                ->form([
                    Select::make('kelas_id')
                        ->label('Pilih Kelas')
                        ->options(\App\Models\Kelas::all()->pluck('nama', 'id'))
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    // Ambil data lengkap kelas terpilih
                    $kelas = Kelas::with([
                        'waliKelas.user',
                        'mataPelajaran.guru.user',
                        'siswa.user',
                    ])->findOrFail($data['kelas_id']);

                    $pdf = Pdf::loadView('exports.kelas-pdf', compact('kelas'));

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'kelas_' . str($kelas->nama)->slug() . '.pdf'
                    );
                }),
        ];
    }
}
