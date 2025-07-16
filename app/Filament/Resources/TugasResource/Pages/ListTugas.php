<?php

namespace App\Filament\Resources\TugasResource\Pages;

use App\Filament\Resources\TugasResource;
use App\Models\Tugas;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListTugas extends ListRecords
{
    protected static string $resource = TugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('ringkas')
                ->label('Export Ringkas')
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
                    $tasks = Tugas::with(['kelas', 'mataPelajaran'])
                        ->whereIn('kelas_id', $data['kelas_id'])
                        ->orderBy('kelas_id')
                        ->orderBy('tanggal_deadline')
                        ->get();

                    $pdf = Pdf::loadView('exports.tugas-ringkas-pdf', compact('tasks'));

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'tugas_ringkas.pdf'
                    );
                }),
            Action::make('detail')
                ->label('Export Detail')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->form([
                    Select::make('kelas_id')
                        ->label('Pilih 1 Kelas')
                        ->options(Kelas::all()->pluck('nama', 'id'))
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    $kelas = Kelas::findOrFail($data['kelas_id']);

                    $tasks = Tugas::with([
                        'mataPelajaran',
                        'jawaban.siswa.user',
                    ])
                        ->where('kelas_id', $kelas->id)
                        ->orderBy('tanggal_deadline')
                        ->get();

                    $pdf = Pdf::loadView('exports.tugas-detail-pdf', [
                        'kelas' => $kelas,
                        'tasks' => $tasks,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'tugas_detail_' . str($kelas->nama)->slug() . '.pdf'
                    );
                }),
        ];
    }
}
