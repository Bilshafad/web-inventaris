<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Barang;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBarang extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationLabel = 'Laporan Barang';
    protected static ?string $navigationGroup = 'Manajemen Inventaris';
    protected static string $view = 'filament.pages.laporan-barang';

    public function table(Table $table): Table
    {
        return $table
            ->query(Barang::query())
            ->columns([
                TextColumn::make('kode_barang')->label('Kode Barang')->sortable()->searchable(),
                TextColumn::make('nama_barang')->label('Nama Barang'),
                TextColumn::make('tanggal_pemeriksaan')->label('Tanggal Pemeriksaan')->date('d M Y'),
                TextColumn::make('status_barang')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baik' => 'success',
                        'rusak' => 'danger',
                        'perlu_perbaikan' => 'warning',
                        default => 'gray',
                    }),
            ]);
    }

    public function print()
    {
        $data = Barang::all();
        $pdf = Pdf::loadView('reports.barang', ['barangs' => $data])
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-barang.pdf'
        );
    }
}
