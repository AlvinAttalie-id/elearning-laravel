<?php

namespace App\Filament\Resources\TugasResource\RelationManagers;

use App\Models\JawabanTugas;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class JawabanRelationManager extends RelationManager
{
    protected static string $relationship = 'jawaban';
    protected static ?string $title = 'Jawaban Siswa';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama')->label('Siswa'),
                TextColumn::make('submitted_at')->label('Dikumpulkan')->since(),
                TextColumn::make('jawaban')->label('Jawaban')->limit(50),
                TextColumn::make('nilai')->label('Nilai'),
                TextColumn::make('feedback')->label('Feedback')->limit(30),
            ])
            ->actions([
                Action::make('nilai')
                    ->label('Lihat / Nilai')
                    ->modalHeading('Penilaian Jawaban')
                    ->form([
                        Textarea::make('feedback'),
                        TextInput::make('nilai')->numeric()->minValue(0)->maxValue(100),
                    ])
                    ->action(function (JawabanTugas $record, array $data) {
                        $record->update($data);
                    }),
            ]);
    }
}
