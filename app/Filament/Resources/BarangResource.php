<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Inventaris Barang';
    protected static ?string $navigationGroup = 'Manajemen Inventaris';
    protected static ?string $pluralModelLabel = 'Barang';
    protected static ?string $modelLabel = 'Barang';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('kode_barang')
                ->label('Kode Barang')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50),

            TextInput::make('nama_barang')
                ->label('Nama Barang')
                ->required(),

            DatePicker::make('tanggal_pemeriksaan')
                ->label('Tanggal Pemeriksaan')
                ->required(),

            Select::make('status_barang')
                ->label('Status Barang')
                ->options([
                    'baik' => 'Baik',
                    'rusak' => 'Rusak',
                    'perlu_perbaikan' => 'Perlu Perbaikan',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_barang')
                    ->label('Kode Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tanggal_pemeriksaan')
                    ->label('Tanggal Pemeriksaan')
                    ->date('d M Y'),

                TextColumn::make('status_barang')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baik' => 'success',
                        'rusak' => 'danger',
                        'perlu_perbaikan' => 'warning',
                        default => 'gray',
                    }),
            ])

            // Tambahkan tombol di header atas tabel
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Tambah Barang')
                ->icon('heroicon-o-plus'),

                // 🧹 Tombol Clear All Data
                Action::make('clear_all')   
                    ->label('Clear All Data')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function () {
                        Barang::truncate();

                        Notification::make()
                            ->title('Semua data berhasil dihapus!')
                            ->success()
                            ->send();
                    }),
            ])

            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
