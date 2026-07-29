<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Alumni IKA SMAN Kajuara / IKA SMAN 8 Bone</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #1e293b;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
        }
        .header h2 {
            margin: 3px 0 0 0;
            font-size: 14px;
            color: #d97706;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #64748b;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge-approved {
            color: #166534;
            font-weight: bold;
        }
        .badge-pending {
            color: #9f1239;
            font-weight: bold;
        }
        .footer-sign {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .footer-sign p {
            margin: 2px 0;
        }
        .sign-space {
            height: 60px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="background: #0f172a; color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold;">📄 Laporan Siap Dicetak / Disimpan PDF</span>
        <button onclick="window.print()" style="background: #f59e0b; color: #0f172a; font-weight: bold; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <div class="header">
        <h1>IKATAN ALUMNI SMAN KAJUARA / IKA SMAN 8 BONE</h1>
        <h2>DAFTAR ANGGOTA ALUMNI TERDAFTAR</h2>
        <p>Sekretariat: Kab. Bone, Sulawesi Selatan | Portal Resmi: ikasman8bone.org</p>
    </div>

    <div class="meta-info">
        <div><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</div>
        <div><strong>Total Data:</strong> {{ count($alumniList) }} Alumni</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Nama Lengkap & Gelar</th>
                <th style="text-align: center;">L/P</th>
                <th style="text-align: center;">Angkatan</th>
                <th>Profesi / Pekerjaan</th>
                <th>Domisili Kota</th>
                <th>No. WhatsApp / HP</th>
                <th>Status Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alumniList as $index => $alm)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $alm->nama }}</strong>
                        @if($alm->is_berprestasi)
                            <span style="color: #d97706; font-size: 10px;">⭐ Featured</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $alm->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }}</td>
                    <td style="text-align: center;">{{ $alm->angkatan }}</td>
                    <td>{{ $alm->profesi ?? '-' }}</td>
                    <td>{{ $alm->domisili ?? '-' }}</td>
                    <td>{{ $alm->no_hp ?? '-' }}</td>
                    <td>
                        @if($alm->status == 'pending')
                            <span class="badge-pending">Pending</span>
                        @else
                            <span class="badge-approved">Approved</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #94a3b8;">Tidak ada data alumni.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Bone, {{ date('d F Y') }}</p>
        <p><strong>Pengurus Pusat IKA SMAN Kajuara / IKA SMAN 8 Bone</strong></p>
        <div class="sign-space"></div>
        <p><u>( Sekretariat IKA )</u></p>
    </div>

    <script>
        // Auto trigger print when opened directly
        window.onload = function() {
            // window.print();
        };
    </script>
</body>
</html>
