<?php

namespace App\Exports;

use App\Models\KajianAwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKajianAwalExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return KajianAwal::with('pendaftaran.pasien')->latest()->get();
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('d-m-Y'),
            $row->nomor_rekam_medis,
            optional($row->pendaftaran->pasien)->nama ?? '-',
            $row->keluhan ?? '-',
            $row->diagnosis ?? '-',
            $row->obat ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nomor RM',
            'Nama Pasien',
            'Keluhan',
            'Diagnosis',
            'Obat/Resep',
        ];
    }
}

