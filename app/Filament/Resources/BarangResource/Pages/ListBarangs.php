<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Barang;
use Filament\Notifications\Notification;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;

    // 🧹 Hapus tombol CreateAction di atas
    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada CreateAction di sini → tombol “New barang” atas hilang
        ];
    }
}
