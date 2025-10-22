<?php

namespace App\Filament\Widgets;

use App\Models\Barang; // ✅ pakai model Barang, bukan Patient
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BarangStat extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Barang Baik', Barang::where('status_barang', 'baik')->count())
                ->description('Total barang dalam kondisi baik')
                ->color('success'),

            Stat::make('Barang Rusak', Barang::where('status_barang', 'rusak')->count())
                ->description('Total barang rusak')
                ->color('danger'),  

            Stat::make('Perlu Perbaikan', Barang::where('status_barang', 'perlu_perbaikan')->count())
                ->description('Total barang yang perlu diperbaiki')
                ->color('warning'),
        ];
    }
}
