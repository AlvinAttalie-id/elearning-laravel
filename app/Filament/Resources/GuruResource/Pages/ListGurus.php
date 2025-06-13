<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use App\Models\Guru;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;

class ListGurus extends ListRecords
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $gurus = Guru::with('user')->whereHas('user.roles', fn($q) => $q->where('name', 'Guru'))->get();

                    $pdf = Pdf::loadView('exports.guru-pdf', ['gurus' => $gurus]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'daftar_guru.pdf'
                    );
                }),
        ];
    }
}
