<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\Siswa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $siswas = Siswa::with('user', 'kelas')->whereHas('user.roles', fn($q) => $q->where('name', 'murid'))->get();

                    $pdf = Pdf::loadView('exports.siswa-pdf', ['siswas' => $siswas]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'daftar_siswa.pdf'
                    );
                }),
        ];
    }
}
