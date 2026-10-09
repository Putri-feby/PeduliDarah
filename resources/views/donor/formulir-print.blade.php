<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kuesioner Donor - {{ $registration->user->nama_lengkap ?? $registration->user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #000;
            background: #fff;
        }

        @media print {
            body { font-size: 8.5px; }
            .no-print { display: none !important; }
            @page { size: A4 landscape; margin: 6mm; }
        }

        .no-print {
            text-align: center;
            padding: 12px;
            background: #dc2626;
        }

        .no-print button {
            background: #fff;
            color: #dc2626;
            border: none;
            padding: 10px 30px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            margin: 0 6px;
        }

        .no-print a {
            color: #fff;
            margin-left: 16px;
            font-size: 13px;
        }

        .page {
            width: 277mm;
            min-height: 190mm;
            margin: 0 auto;
            background: #fff;
            border: 1.5px solid #000;
            display: flex;
            gap: 0;
        }

        /* ── LEFT HALF ── */
        .left-half {
            width: 50%;
            border-right: 1.5px solid #000;
            padding: 5px 6px;
            display: flex;
            flex-direction: column;
        }

        /* ── RIGHT HALF ── */
        .right-half {
            width: 50%;
            padding: 5px 6px;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        .header-box {
            border: 1.5px solid #000;
            margin-bottom: 4px;
        }

        .header-title {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 3px 4px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.3px;
        }

        .header-subtitle {
            text-align: center;
            font-size: 9px;
            padding: 2px 4px;
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .header-welcome {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid #000;
        }

        .header-welcome-left {
            padding: 3px 5px;
            border-right: 1px solid #000;
            font-size: 8px;
        }

        .header-welcome-right {
            padding: 3px 5px;
            font-size: 8px;
        }

        .bold { font-weight: bold; }

        /* ── DATA DONOR (bottom of left header) ── */
        .data-donor {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-top: 1px solid #000;
        }

        .data-col {
            padding: 3px 5px;
            font-size: 8px;
        }

        .data-col + .data-col {
            border-left: 1px solid #000;
        }

        .data-row {
            display: flex;
            gap: 3px;
            margin-bottom: 2px;
        }

        .data-label { min-width: 65px; }
        .data-value { flex: 1; border-bottom: 1px solid #555; min-width: 60px; }

        /* ── DONOR FREQUENCY ── */
        .freq-row {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 2px 5px;
            border-top: 1px solid #000;
            font-size: 8px;
            flex-wrap: wrap;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .cb {
            width: 9px; height: 9px;
            border: 1px solid #000;
            display: inline-block;
            flex-shrink: 0;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-weight: bold;
            font-size: 9px;
            margin: 4px 0 2px;
            text-decoration: underline;
        }

        /* ── QUESTION TABLE ── */
        .q-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        .q-table td {
            padding: 1px 2px;
            vertical-align: top;
            font-size: 8px;
            line-height: 1.35;
        }

        .q-num {
            width: 14px;
            text-align: right;
            padding-right: 2px;
            white-space: nowrap;
        }

        .q-text { flex: 1; }

        .q-cb-wrap {
            display: flex;
            gap: 2px;
            align-items: flex-start;
            padding-top: 1px;
            white-space: nowrap;
        }

        .q-label { font-size: 7.5px; }

        /* ── SIGNATURE AREA ── */
        .sig-area {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            gap: 8px;
        }

        .sig-box {
            flex: 1;
            text-align: center;
            font-size: 8px;
        }

        .sig-line {
            border-top: 1px solid #000;
            margin-top: 28px;
            padding-top: 2px;
        }

        /* ── BARCODE PLACEHOLDER ── */
        .barcode-area {
            text-align: right;
            margin-top: 3px;
            font-size: 7px;
        }

        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 8px;
            letter-spacing: 2px;
            border: 1px solid #000;
            display: inline-block;
            padding: 2px 4px;
        }

        .info-note {
            font-size: 7px;
            color: #333;
            margin-top: 3px;
            line-height: 1.4;
        }

        hr.divider {
            border: none;
            border-top: 1px solid #000;
            margin: 3px 0;
        }

        .right-header-box {
            border: 1.5px solid #000;
            margin-bottom: 4px;
        }

        .right-header-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .rhi-left { padding: 3px 5px; border-right: 1px solid #000; font-size: 8px; }
        .rhi-right { padding: 3px 5px; font-size: 8px; }

        .right-header-title {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 3px 4px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

{{-- PRINT BUTTON (hidden on print) --}}
<div class="no-print">
    <button onclick="window.print()">🖨️ Cetak Formulir</button>
    <a href="javascript:history.back()">← Kembali</a>
</div>

<div class="page">

    {{-- ═══════════════ LEFT HALF ═══════════════ --}}
    <div class="left-half">

        {{-- Header --}}
        <div class="header-box">
            <div class="header-title">UDD PMI Kota Tangsel</div>
            <div class="header-subtitle">Formulir Kuesioner dan Informed Consent Donor</div>

            <div class="header-welcome">
                <div class="header-welcome-left">
                    <div class="bold">Tempat Penyumbangan:</div>
                    <div>UDD PMI Kota Tangsel</div>
                    <div>Jl. AMD No.QPNTP17C00310</div>
                    <div>Kec.- Kota.- Tangerang</div>
                    <div>Telp.: HP: 0987230009</div>
                </div>
                <div class="header-welcome-right">
                    <div class="bold" style="font-size:10px;">Selamat Datang, Terima Kasih Atas Kesediaan Anda Melayangkan Waktu Untuk Menyumbangkan Darah</div>
                    <div style="font-size:7.5px; margin-top:3px;">Anda Boleh Bertanya Jika Anda Tidak Mengerti Setiap Langkah Untuk Keselamatan Anda</div>
                </div>
            </div>

            <div class="data-donor">
                <div class="data-col">
                    <div class="data-row">
                        <span class="data-label">No.KTP</span>
                        <span class="data-value">{{ $registration->user->nik ?? '___________________' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Nama Lengkap Donor</span>
                        <span class="data-value">{{ $registration->user->nama_lengkap ?? $registration->user->name }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Untuk</span>
                        <span class="data-value">Publ Reby Hand</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Tanggal Lahir</span>
                        <span class="data-value">{{ $registration->user->tanggal_lahir ? \Carbon\Carbon::parse($registration->user->tanggal_lahir)->format('d F Y') : '___________________' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Jenis Kelamin</span>
                        <span class="data-value">
                            @if($registration->user->jenis_kelamin === 'L') Laki-laki
                            @elseif($registration->user->jenis_kelamin === 'P') Perempuan
                            @else ___________________
                            @endif
                        </span>
                    </div>
                </div>
                <div class="data-col">
                    <div class="data-row">
                        <span class="data-label">No. Kartu Donor</span>
                        <span class="data-value">{{ $registration->eTicket->ticket_code ?? '___________________' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Pekerjaan</span>
                        <span class="data-value">___________________</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Nomor</span>
                        <span class="data-value">___________________</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Alamat</span>
                        <span class="data-value">___________________</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Tanggal Donor</span>
                        <span class="data-value">{{ now()->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Donor Frequency --}}
            <div class="freq-row">
                <span>Berdasarkan saudara donor pada waktu, bulan puasa?</span>
                <span class="checkbox-group"><span class="cb"></span>10X</span>
                <span class="checkbox-group"><span class="cb"></span>20X</span>
                <span class="checkbox-group"><span class="cb"></span>50X</span>
                <span class="checkbox-group"><span class="cb"></span>75X</span>
                <span class="checkbox-group"><span class="cb"></span>100X</span>
            </div>
            <div class="freq-row">
                <span>Berdasarkan saudara donor yang telah dirima -</span>
                <span style="margin-left:4px;">sekarang donor yang ke:</span>
                <span class="bold" style="margin-left:4px;">_____</span>
                <span>kali</span>
                <span class="checkbox-group" style="margin-left:8px;"><span class="cb"></span>YA</span>
                <span class="checkbox-group"><span class="cb"></span>Tidak</span>
            </div>
            <div class="freq-row">
                <span>Penghargaan yang telah diterima – Donor yang terakhir :</span>
                <span class="bold" style="margin-left:4px;">___________________</span>
            </div>
        </div>

        {{-- Questions Section --}}
        <div class="section-title">Dalam Hari ini:</div>
        <table class="q-table">
            @php
                $hariIni = [
                    '1. Apakah Anda sedang tidak enak badan?',
                    '2. Apakah Anda sedang tidak merasa minum alkohol?',
                ];
            @endphp
            @foreach($hariIni as $i => $q)
            <tr>
                <td class="q-num">{{ $i+1 }}.</td>
                <td>{{ substr($q, strpos($q, '. ')+2) }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Dalam 3 Hari Terakhir:</div>
        <table class="q-table">
            @php
                $tigaHari = [
                    'Apakah Anda pernah meminum obat dalam 3 hari terakhir?',
                    'Apakah Anda pernah vaksin dalam 3 hari?',
                    'Apakah Anda meminum vaksin dalam 3 hari?',
                ];
            @endphp
            @foreach($tigaHari as $i => $q)
            <tr>
                <td class="q-num">{{ $i+3 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Dalam 2 Minggu Terakhir:</div>
        <table class="q-table">
            @php
                $duaMinggu = [
                    'Apakah Anda pernah melakukan perjalanan ke luar negeri?',
                    'Apakah Anda pernah kontak dengan orang yang mengalami flu dalam 2 minggu?',
                    'Apakah Anda pernah menerima vaksinasi dalam 2 minggu?',
                ];
            @endphp
            @foreach($duaMinggu as $i => $q)
            <tr>
                <td class="q-num">{{ $i+6 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Dalam 2 Bulan Terakhir:</div>
        <table class="q-table">
            @php
                $duaBulan = [
                    'Apakah Anda pernah menerima suntikan dalam 2 bulan ?',
                    'Apakah Anda pernah menerima darah dari 38 derajat Celsius?',
                    'Apakah Anda pernah menerima transfusi darah dalam 2 bulan ?',
                ];
            @endphp
            @foreach($duaBulan as $i => $q)
            <tr>
                <td class="q-num">{{ $i+9 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Dalam 1 Tahun Terakhir:</div>
        <table class="q-table">
            @php
                $satutahun = [
                    'Apakah Anda pernah menjalani operasi dalam 1 tahun?',
                    'Apakah Anda pernah tinggal di area penyebaran penyakit dalam 1 tahun?',
                    'Apakah Anda pernah menjalani prosedur operasi gigi dalam 1 tahun?',
                    'Apakah Anda pernah mendapat tato atau tindik badan?',
                    'Apakah Anda pernah memiliki kontak seksual dengan orang yang tidak dikenal?',
                    'Apakah Anda pernah mengganti pasangan seksual dalam 1 tahun?',
                    'Apakah Anda pernah memakai narkoba atau obat terlarang?',
                ];
            @endphp
            @foreach($satutahun as $i => $q)
            <tr>
                <td class="q-num">{{ $i+12 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Dalam 5 Tahun Terakhir:</div>
        <table class="q-table">
            <tr>
                <td class="q-num">19.</td>
                <td>Apakah Anda pernah mendapat suntikan dalam 5 tahun?</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">Tidak</span>
                        <span class="q-label" style="margin-left:3px;">Pilih Pelajar</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Disclaimer --}}
        <div class="info-note" style="margin-top:4px; border-top:1px solid #000; padding-top:3px;">
            Saya telah mendapatkan dan membaca informasi yang diberikan dan menjawab pertanyaan secara jujur. Saya menyatakan sanggup untuk memberikan informasi jika ditemukan hal yang tidak sesuai dengan apa yang saya sampaikan. Bila terdapat hasil pemeriksaan yang diperiksa dari laboratorium yang menyatakan bahwa sampel darah saya mengandung unsur yang membahayakan (seperti HIV, Hepatitis B, Hepatitis C, Sifilis dan infeksi lainnya), maka saya bersedia untuk diberitahu dan siap diarahkan untuk mengambil tindakan demi keselamatan diri dan keluarga. Bila tidak terdapat kontra indikasi pemeriksaan tersebut, maka saya setuju untuk melanjutkan proses pengambilan.
        </div>

        <div class="sig-area" style="margin-top:4px;">
            <div class="sig-box">
                <div>Tanda Tangan Petugas</div>
                <div class="sig-line">( __________________ )</div>
            </div>
            <div class="sig-box">
                <div>Tanda Tangan Pendonor</div>
                <div class="sig-line">( __________________ )</div>
            </div>
        </div>

    </div>

    {{-- ═══════════════ RIGHT HALF ═══════════════ --}}
    <div class="right-half">

        {{-- Right header info --}}
        <div class="right-header-box">
            <div class="right-header-title">Pilih dan Lengkapi Jawaban Anda dengan Tanda Centang ✓</div>
            <div class="right-header-inner">
                <div class="rhi-left">
                    <div class="bold">UDD PMI Kota Tangsel</div>
                    <div>Jl. AMD NO.QPNP17C00310</div>
                    <div>Kec.- Kota.- Tangerang</div>
                    <div>Telp.: HP: 0987230009</div>
                </div>
                <div class="rhi-right">
                    <div class="data-row">
                        <span class="data-label">No. Formulir Donor</span>
                        <span class="data-value">{{ $registration->eTicket->ticket_code ?? '___________' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Tanggal Donor</span>
                        <span class="data-value">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">No. Tumit Barcode</span>
                        <span class="data-value">___________</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Questions right side (Pilih Jawaban) --}}
        <div class="section-title">Dalam 1 Tahun Terakhir:</div>
        <table class="q-table">
            @php
                $rightQ = [
                    'Pernahkah berhubungan seksual dengan seseorang yang berhubungan seksual dengan orang lain?',
                    'Apakah Anda pernah berhubungan seksual dengan seseorang yang menggunakan obat yang disuntikkan?',
                    'Apakah Anda pernah berhubungan seksual dengan seseorang yang mendapatkan bayaran?',
                    'Apakah Anda pernah berhubungan seksual dengan seseorang yang terinfeksi HIV/AIDS?',
                    'Apakah Anda pernah berhubungan seksual dengan seseorang yang sedang mengidap hepatitis ?',
                    'Apakah Anda memiliki riwayat hubungan sesama jenis?',
                    'Apakah wanita, apakah Anda sedang hamil atau menyusui?',
                    'Apakah Anda pernah menerima cangkok organ atau jaringan?',
                    'Adakah dari tubuh Anda yang tidak bisa lebih dari 72 jam?',
                    'Apakah Anda pernah mengalami tekanan darah dengan reaksi serius?',
                    'Apakah Anda pernah melakukan kontak terhadap darah dari orang lain?',
                ];
            @endphp
            @foreach($rightQ as $i => $q)
            <tr>
                <td class="q-num">{{ $i+20 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">TIDAK</span>
                        <span class="q-label" style="margin-left:3px;">Tidak Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Medis Kelainan 1:</div>
        <table class="q-table">
            @php
                $medis1 = [
                    'Medis kelainan 1?',
                    'Medis kelainan 2?',
                    'Berhubungan Seksual dengan orang baru yang tidak dikenal?',
                    'Mengalami komplikasi akibat transfusi darah sebelumnya?',
                    'Mengalami penyakit kulit untuk dikembalikan?',
                    'Memerlukan/menerima faktor pembekuan?',
                    'Menderita penyakit kronis Anda (Arthritis)?',
                    'Menderita Kelainan 3?',
                    'Berhubungan dengan darah atau produk darah dalam 3 hari?',
                    'Pernah tinggal di luar negeri lebih dari 5 tahun?',
                    'Mengkonsumsi obat resep atau tanpa resep dalam 2 hari terakhir (tidak termasuk vitamin)',
                ];
            @endphp
            @foreach($medis1 as $i => $q)
            <tr>
                <td class="q-num">{{ $i+31 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">TIDAK</span>
                        <span class="q-label" style="margin-left:3px;">Tidak Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title" style="margin-top:3px;">Pernah tinggal di Atika ?</div>
        <table class="q-table">
            @php $pernah = ['Pernah tinggal di Afrika ?', 'Berhubungan seksual dengan seseorang yang pernah tinggal di Afrika?']; @endphp
            @foreach($pernah as $i => $q)
            <tr>
                <td class="q-num">{{ $i+42 }}.</td>
                <td>{{ $q }}</td>
                <td>
                    <div class="q-cb-wrap">
                        <span class="cb"></span><span class="q-label">YA</span>
                        <span class="cb" style="margin-left:3px;"></span><span class="q-label">TIDAK</span>
                        <span class="q-label" style="margin-left:3px;">Tidak Pelajar</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        {{-- Barcode --}}
        <div class="barcode-area">
            <div class="barcode-text">0 0 5 1 2 3 4 5 6 7 4 0 3 5 5</div>
            <div style="font-size:7px; margin-top:1px;">No. Formulir Donor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Halaman 1 dari 2</div>
        </div>

        {{-- Signature Right --}}
        <div class="sig-area" style="margin-top:5px;">
            <div class="sig-box">
                <div>Tanda Tangan Petugas</div>
                <div class="sig-line">( __________________ )</div>
            </div>
            <div class="sig-box">
                <div>Tanda Tangan Pendonor</div>
                <div class="sig-line">( __________________ )</div>
            </div>
        </div>

    </div>

</div>

<script>
    // Auto trigger print dialog when page loads (optional - comment out if not desired)
    // window.onload = function() { window.print(); }
</script>
</body>
</html>
