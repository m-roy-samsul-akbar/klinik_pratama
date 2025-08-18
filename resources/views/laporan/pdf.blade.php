<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan Pasien</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .wrap-border {
            border: 2px solid #000;
            padding: 20px;
            margin: 10px;
        }

        .kop {
            position: relative;
            margin-bottom: 20px;
        }

        .kop img {
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
        }

        .kop-text {
            text-align: center;
            margin-left: 90px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 12px;
        }

        .judul-laporan {
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="wrap-border">

        <!-- KOP SURAT tanpa bingkai sendiri -->
        <div class="kop">
            <img src="{{ public_path('assets/images/klinik.png') }}" alt="Logo Klinik">
            <div class="kop-text">
                <h2>KLINIK AISYIYAH "HAJI. MAFROH"</h2>
                <p>Jl. Pancasila No.35, RT.11/RW.04, Grogol,</p>
                <p>Kec. Dukuhturi, Kabupaten Tegal, Jawa Tengah 52192</p>
                <p>Telepon: 0853-2971-6127</p>
            </div>
        </div>

        <!-- Judul Laporan -->
        <h4 class="judul-laporan">Laporan Kunjungan Pasien</h4>

        <!-- Tabel -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor RM</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Diagnosis</th>
                    <th>Obat/Resep</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row['tanggal'] }}</td>
                        <td>{{ $row['nomor_rm'] }}</td>
                        <td>{{ $row['nama'] }}</td>
                        <td>{{ $row['keluhan'] }}</td>
                        <td>{{ $row['diagnosis'] }}</td>
                        <td>{{ $row['obat'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
