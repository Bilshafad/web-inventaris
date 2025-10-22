<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kondisi Barang per Bulan';
    protected static ?string $maxHeight = '350px';
    protected static ?int $sort = 2;

    // BARU: Mengatur lebar widget menjadi penuh (12/12 kolom)
    protected int | string | array $columnSpan = 'full'; 

    // Tambahkan properti filter bulan
    protected function getFilters(): ?array
    {
        // Menampilkan daftar bulan dari Januari sampai Desember
        return collect(range(1, 12))
            ->mapWithKeys(fn ($m) => [
                $m => Carbon::create()->month($m)->translatedFormat('F')
            ])
            ->toArray();
    }

    protected function getData(): array
    {
        // Ambil bulan dari filter, jika tidak ada pakai bulan sekarang
        $bulanDipilih = $this->filter ?? now()->month;

        // Ambil data jumlah barang per status pada bulan yang dipilih
        $data = Barang::select(
                DB::raw("SUM(CASE WHEN status_barang = 'baik' THEN 1 ELSE 0 END) as baik"),
                DB::raw("SUM(CASE WHEN status_barang = 'perlu_perbaikan' THEN 1 ELSE 0 END) as perlu_perbaikan"),
                DB::raw("SUM(CASE WHEN status_barang = 'rusak' THEN 1 ELSE 0 END) as rusak")
            )
            ->whereMonth('created_at', $bulanDipilih)
            ->first();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Barang',
                    'data' => [
                        $data->baik ?? 0,
                        $data->perlu_perbaikan ?? 0,
                        $data->rusak ?? 0,
                    ],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.7)', // hijau
                        'rgba(234, 179, 8, 0.7)', // kuning
                        'rgba(239, 68, 68, 0.7)', // merah
                    ],
                    'borderColor' => [
                        'rgba(34, 197, 94, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Baik', 'Perlu Perbaikan', 'Rusak'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'font' => ['size' => 13],
                        'color' => '#e5e7eb',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['color' => '#e5e7eb'],
                    'grid' => ['color' => 'rgba(255,255,255,0.1)'],
                ],
                'x' => [
                    'ticks' => ['color' => '#e5e7eb'],
                    'grid' => ['color' => 'rgba(255,255,255,0.1)'],
                ],
            ],
        ];
    }
}
