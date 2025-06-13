<?php

namespace App\Filament\Resources\MataPelajaranResource\Pages;

use App\Filament\Resources\MataPelajaranResource;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Actions;


class ListMataPelajarans extends ListRecords
{
    protected static string $resource = MataPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $mapel = MataPelajaran::with('guru.user')->get();

                    $pdf = Pdf::loadView('exports.mata-pelajaran-pdf', [
                        'mapel' => $mapel,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'daftar_mata_pelajaran.pdf'
                    );
                })
        ];
    }
}
