<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Keluarga - {{ $kepalaKeluarga->no_kk ?? '' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 8mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }

        .container {
            width: 100%;
            max-width: 277mm;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            margin-bottom: 8px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .header table {
            width: 100%;
        }

        .header .logo {
            width: 90px;
            text-align: center;
            vertical-align: top;
        }

        .header .logo img {
            width: 70px;
            height: auto;
            margin-top: 5px;
        }

        .header .logo-text {
            font-size: 6pt;
            font-weight: bold;
            margin-top: 3px;
        }

        .header .title {
            text-align: center;
            vertical-align: top;
            padding-top: 8px;
        }

        .header h1 {
            font-size: 22pt;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* INFO SECTION */
        .info-section {
            margin-bottom: 8px;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 1px 0;
            font-size: 8pt;
        }

        .info-label {
            width: 130px;
        }

        .info-colon {
            width: 5px;
        }

        .info-value {
            width: 280px;
        }

        .info-label-right {
            width: 110px;
            padding-left: 10px;
        }

        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            font-size: 7pt;
            vertical-align: middle;
        }

        .data-table th {
            background-color: #f8f8f8;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }

        .data-table .col-number {
            background-color: #f0f0f0;
            font-size: 6pt;
            font-style: italic;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        /* FOOTER */
        .footer {
            margin-top: 12px;
        }

        .footer table {
            width: 100%;
        }

        .footer td {
            vertical-align: top;
            font-size: 7.5pt;
        }

        .footer .signature-box {
            text-align: center;
        }

        .footer .signature-name {
            margin-top: 45px;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 1px;
            min-width: 160px;
            font-weight: bold;
        }

        .footer .qr-code {
            width: 55px;
            height: 55px;
            margin: 5px auto 3px;
        }

        .footer .official-info {
            font-size: 6.5pt;
            line-height: 1.3;
        }

        .footer-note {
            text-align: center;
            margin-top: 8px;
        }

        .footer-note .title {
            font-size: 6.5pt;
            font-weight: bold;
        }

        .footer-note .disclaimer {
            font-size: 6pt;
            font-style: italic;
            line-height: 1.3;
            margin-top: 3px;
        }

        /* PRINT */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Specific column widths */
        .col-no {
            width: 20px;
        }

        .col-nama {
            width: 140px;
        }

        .col-nik {
            width: 30px;
        }

        .col-jk {
            width: 55px;
        }

        .col-tempat {
            width: 85px;
        }

        .col-tgl {
            width: 65px;
        }

        .col-agama {
            width: 60px;
        }

        .col-pendidikan {
            width: 100px;
        }

        .col-pekerjaan {
            width: 90px;
        }

        .col-darah {
            width: 60px;
        }

        .col-status {
            width: 55px;
        }

        .col-cerai {
            width: 55px;
        }

        .col-tgl-cerai {
            width: 65px;
        }

        .col-hub {
            width: 90px;
        }

        .col-wn {
            width: 85px;
        }

        .col-paspor {
            width: 70px;
        }

        .col-kitap {
            width: 70px;
        }

        .col-ortu {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="logo">

                    </td>
                    <td class="title">
                        <h1>KARTU KELUARGA</h1>
                        <h2>No. {{ $kepalaKeluarga->no_kk ?? '' }}</h2>
                    </td>
                    <td style="width: 90px;"></td>
                </tr>
            </table>
        </div>

        <!-- INFO SECTION -->
        <div class="info-section">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="logo" rowspan="5" colspan="4">
                        <img src="{{ asset('images/garuda.png') }}" alt="Garuda Pancasila">
                        <div class="logo-text">REPUBLIK INDONESIA</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Nama Kepala Keluarga</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $data->where('hubungan_id', 1)->first()->nama ?? '-' }}</td>
                    <td class="info-label-right">Desa/Kelurahan</td>
                    <td class="info-colon">:</td>
                    <td>{{ strtoupper($kepalaKeluarga->desa ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Alamat</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ strtoupper($kepalaKeluarga->kp ?? '-') }}</td>
                    <td class="info-label-right">Kecamatan</td>
                    <td class="info-colon">:</td>
                    <td>{{ strtoupper($kepalaKeluarga->kecamatan ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="info-label">RT/RW</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $kepalaKeluarga->rt ?? '-' }}/{{ $kepalaKeluarga->rw ?? '-' }}</td>
                    <td class="info-label-right">Kabupaten/Kota</td>
                    <td class="info-colon">:</td>
                    <td>{{ strtoupper($kepalaKeluarga->kabupaten ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Kode Pos</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">-</td>
                    <td class="info-label-right">Provinsi</td>
                    <td class="info-colon">:</td>
                    <td>{{ strtoupper($kepalaKeluarga->provinsi ?? '-') }}</td>
                </tr>
            </table>
        </div>

        <!-- TABEL BAGIAN ATAS (Kolom 1-9) -->
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" class="col-no">No</th>
                    <th rowspan="2" class="col-nama">Nama Lengkap</th>
                    <th rowspan="2" class="col-nik">NIK</th>
                    <th rowspan="2" class="col-jk">Jenis<br>Kelamin</th>
                    <th rowspan="2" class="col-tempat">Tempat Lahir</th>
                    <th rowspan="2" class="col-tgl">Tanggal<br>Lahir</th>
                    <th rowspan="2" class="col-agama">Agama</th>
                    <th rowspan="2" class="col-pendidikan">Pendidikan</th>
                    <th rowspan="2" class="col-pekerjaan">Jenis Pekerjaan</th>
                    <th rowspan="2" class="col-darah">Golongan<br>Darah</th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-number">&nbsp;</td>
                    <td class="col-number">(1)</td>
                    <td class="col-number">(2)</td>
                    <td class="col-number">(3)</td>
                    <td class="col-number">(4)</td>
                    <td class="col-number">(5)</td>
                    <td class="col-number">(6)</td>
                    <td class="col-number">(7)</td>
                    <td class="col-number">(8)</td>
                    <td class="col-number">(9)</td>
                </tr>
                @for ($i = 1; $i <= 10; $i++)
                    @if (isset($data[$i - 1]))
                        @php $anggota = $data[$i-1]; @endphp
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-bold">{{ $anggota->nama }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">{{ $anggota->no_nik }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                @if (strtoupper($anggota->jenkel) == 'LAKI-LAKI' || strtoupper($anggota->jenkel) == 'L')
                                    LAKI-LAKI
                                @else
                                    PEREMPUAN
                                @endif
                            </td>
                            <td style="font-size: 6.5pt;">{{ $anggota->tmpt_lahir }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d-m-Y') }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">{{ strtoupper($anggota->agama) }}</td>
                            <td style="font-size: 6.5pt;">{{ strtoupper($anggota->pendidikan) }}</td>
                            <td style="font-size: 6.5pt;">{{ strtoupper($anggota->pekerjaan) }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                {{ strtoupper($anggota->golongan_darah) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>

        <!-- TABEL BAGIAN BAWAH (Kolom 10-17) -->
        <table class="data-table" style="margin-top: -1px;">
            <thead>
                <tr>
                    <th rowspan="2" class="col-no">No</th>
                    <th rowspan="2" style="width: 110px;">Status<br>Perkawinan</th>
                    <th rowspan="2" style="width: 110px;">Tanggal<br>Perkawinan</th>
                    <th rowspan="2" class="col-hub">Status Hubungan<br>Dalam Keluarga</th>
                    <th rowspan="2" class="col-wn">Kewarganegaraan</th>
                    <th colspan="2" style="width: 140px;">Dokumen Imigrasi</th>
                    <th colspan="2" style="width: 200px;">Nama Orang Tua</th>
                </tr>
                <tr>
                    {{--  <th class="col-status"></th>
                    <th class="col-cerai"></th>  --}}
                    <th class="col-paspor">No. Paspor</th>
                    <th class="col-kitap">No. KITAP</th>
                    <th class="col-ortu">Ayah</th>
                    <th class="col-ortu">Ibu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-number"></td>
                    <td class="col-number">(10)</td>
                    <td class="col-number">(11)</td>
                    <td class="col-number">(12)</td>
                    <td class="col-number">(13)</td>
                    <td class="col-number">(14)</td>
                    <td class="col-number">(15)</td>
                    <td class="col-number">(16)</td>
                    <td class="col-number">(17)</td>
                </tr>
                @for ($i = 1; $i <= 10; $i++)
                    @if (isset($data[$i - 1]))
                        @php $anggota = $data[$i-1]; @endphp
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center" style="font-size: 6.5pt;"> {{ $anggota->status_perkawinan }}
                                {{--  @if (strpos($anggota->status_perkawinan, 'KAWIN') !== false && strpos($anggota->status_perkawinan, 'BELUM') === false)
                                    KAWIN
                                @elseif(strpos($anggota->status_perkawinan, 'BELUM') !== false)
                                    BELUM KAWIN
                                @endif  --}}
                            </td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                {{--  @if (strpos($anggota->status_perkawinan, 'CERAI') !== false)
                                    CERAI
                                @endif  --}}
                            </td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                {{ strtoupper($anggota->hubungan_keluarga) }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">
                                {{ strtoupper($anggota->kewarganegaraan ?? 'WNI') }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">{{ $anggota->no_paspor ?? '' }}</td>
                            <td class="text-center" style="font-size: 6.5pt;">{{ $anggota->no_kitas ?? '' }}</td>
                            <td style="font-size: 6.5pt;">{{ $anggota->nm_ayah ?? '' }}</td>
                            <td style="font-size: 6.5pt;">{{ $anggota->nm_ibu ?? '' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>

        <!-- FOOTER -->
        <div class="footer">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 35%;">
                        Dikeluarkan Tanggal: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                    </td>
                    <td style="width: 30%;" class="signature-box">
                        <div style="font-weight: bold; margin-bottom: 2px;">KEPALA KELUARGA</div>
                        <div class="signature-name">
                            {{ $data->where('hubungan_id', 1)->first()->nama ?? '-' }}
                        </div>
                    </td>
                    <td style="width: 35%;" class="signature-box"></td>
                    {{--  <td style="width: 35%;" class="signature-box">
                        <div style="font-weight: bold;">KEPALA DINAS</div>
                        <div style="font-size: 6.5pt;">KEPENDUDUKAN DAN PENCATATAN SIPIL</div>
                        <div style="margin: 3px 0;">
                            <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" class="qr-code">
                        </div>
                        <div class="official-info">
                            Hj. IRMA NOVRITA, S.Sos., M.Si<br>
                            NIP. 196811091989092001
                        </div>
                    </td>  --}}
                </tr>
            </table>
        </div>

        <!-- FOOTER NOTE -->
        <div class="footer-note">
            <div class="title">Tanda Tangan/Cap Jempol</div>
            <div class="disclaimer">
                Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan
                oleh Balai Sertifikasi Elektronik (BSrE), BSSN
            </div>
        </div>
    </div>

    <!-- Auto print saat halaman dibuka -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
