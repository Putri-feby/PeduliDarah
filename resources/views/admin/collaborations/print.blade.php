<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan Kolaborasi - {{ $collaboration->event_name }}</title>
    <style>
        /* CSS reset & base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 0;
        }
        
        /* Print layout settings */
        @media print {
            .no-print,
            .no-print-bar {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
            }
            body {
                background: #fff;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            /* Force background colors & gradients to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4;
                margin: 0; /* Remove browser default headers/footers */
            }
            .letter-container {
                padding: 15mm 15mm 15mm 20mm;
            }
        }

        /* Styling for screen view */
        .no-print-bar {
            background: #dc2626;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .btn-print {
            background: #fff;
            color: #dc2626;
            border: none;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-back {
            color: #fff;
            text-decoration: underline;
            font-size: 14px;
        }

        /* Document Styling */
        .letter-container {
            width: 210mm;
            min-height: auto;
            margin: 0 auto;
            padding: 8mm 10mm 8mm 15mm;
            background: #fff;
        }

        /* Kop Surat (Header Banner) */
        .header-banner {
            display: flex;
            align-items: stretch;
            height: 55px;
            border-bottom: 2px solid #000;
            margin-bottom: 12px;
            overflow: hidden;
            width: 100%;
        }
        .banner-gradient {
            flex-grow: 1;
            background: linear-gradient(to right, 
                #c10c19 0%, #c10c19 45%, 
                #d83143 45%, #d83143 65%, 
                #e85b6c 65%, #e85b6c 78%, 
                #f28a99 78%, #f28a99 88%, 
                #fbbfc7 88%, #fbbfc7 100%
            );
        }
        .banner-logo-section {
            background: #fff;
            padding: 5px 0 5px 15px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            width: 210px;
        }
        .banner-logo {
            width: 38px;
            height: 38px;
            margin-right: 6px;
        }
        .banner-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-family: Arial, sans-serif;
            font-size: 11.5px;
            font-weight: bold;
            color: #000;
            line-height: 1.15;
            text-transform: uppercase;
        }

        /* Meta details (Nomor, Hal, Tanggal) */
        .meta-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .meta-left {
            width: 60%;
        }
        .meta-right {
            width: 40%;
            text-align: right;
        }
        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* Recipient address */
        .recipient-section {
            margin-bottom: 10px;
        }
        .recipient-section p {
            margin-bottom: 2px;
        }

        /* Letter Body */
        .letter-body {
            text-align: justify;
        }
        .salutation {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .paragraph {
            text-indent: 30px;
            margin-bottom: 8px;
            text-align: justify;
        }

        /* Event Details Table */
        .event-details-table {
            width: 85%;
            margin: 6px auto;
            border-collapse: collapse;
        }
        .event-details-table td {
            padding: 2px 6px;
            vertical-align: top;
        }
        .event-details-table td.label {
            width: 30%;
            font-weight: bold;
        }
        .event-details-table td.colon {
            width: 3%;
        }

        /* Signatures section */
        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 80px;
        }
        .signature-title {
            margin-bottom: 40px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Footer line info */
        .letter-footer {
            margin-top: 15px;
            border-top: 2px solid #dc2626;
            padding-top: 8px;
            font-size: 10.5px;
            color: #dc2626;
            text-align: center;
            font-family: Arial, sans-serif;
            line-height: 1.4;
            font-weight: bold;
        }

        /* Rundown Page Styling */
        .rundown-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .rundown-subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            font-weight: bold;
        }
        .rundown-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .rundown-table th, .rundown-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 13px;
        }
        .rundown-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: center;
        }
        .rundown-table td.center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (hidden during print) -->
    <div class="no-print no-print-bar">
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak / Simpan PDF
        </button>
        <a href="{{ route('admin.collaborations.show', $collaboration) }}" class="btn-back">
            Kembali ke Detail
        </a>
    </div>

    <!-- Page 1: Surat Permohonan -->
    <div class="letter-container">
        
        <!-- Header Banner -->
        <div class="header-banner">
            <div class="banner-gradient"></div>
            <div class="banner-logo-section">
                <!-- Official PMI Logo SVG (5-Petal Flower and Red Cross) -->
                <svg class="banner-logo" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <g id="petal-red">
                            <circle cx="50" cy="30" r="16.5" fill="#dc2626" />
                        </g>
                        <g id="petal-white">
                            <circle cx="50" cy="30" r="14" fill="white" />
                        </g>
                    </defs>
                    <!-- Solid red shape first -->
                    <use href="#petal-red" transform="rotate(0 50 50)" />
                    <use href="#petal-red" transform="rotate(72 50 50)" />
                    <use href="#petal-red" transform="rotate(144 50 50)" />
                    <use href="#petal-red" transform="rotate(216 50 50)" />
                    <use href="#petal-red" transform="rotate(288 50 50)" />
                    
                    <!-- Solid white shape on top -->
                    <use href="#petal-white" transform="rotate(0 50 50)" />
                    <use href="#petal-white" transform="rotate(72 50 50)" />
                    <use href="#petal-white" transform="rotate(144 50 50)" />
                    <use href="#petal-white" transform="rotate(216 50 50)" />
                    <use href="#petal-white" transform="rotate(288 50 50)" />
                    
                    <!-- Central mask to clean up center -->
                    <circle cx="50" cy="50" r="16" fill="white" />
                    
                    <!-- Red Cross in the center -->
                    <rect x="45" y="32" width="10" height="36" fill="#dc2626" />
                    <rect x="32" y="45" width="36" height="10" fill="#dc2626" />
                </svg>
                <div class="banner-text">
                    <div>Palang</div>
                    <div>Merah</div>
                    <div>Indonesia</div>
                </div>
            </div>
        </div>

        <!-- Meta Section -->
        <div class="meta-section">
            <div class="meta-left">
                <table class="meta-table">
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>x</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>1 (Satu) Berkas Rundown</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td><strong>Permohonan Kolaborasi Kegiatan Donor Darah</strong></td>
                    </tr>
                </table>
            </div>
            <div class="meta-right">
                <p>Tangerang, {{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Recipient Section -->
        <div class="recipient-section">
            <p>Kepada Yth.</p>
            <p><strong>Pimpinan Unit Donor Darah</strong></p>
            <p><strong>{{ $collaboration->pmi_id ?? 'Palang Merah Indonesia' }}</strong></p>
            <p>Di -</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;Tempat</p>
        </div>

        <!-- Letter Body -->
        <div class="letter-body">
            <p class="salutation">Salam Kemanusiaan !!</p>
            
            <p class="paragraph">
                Bersama ini dengan hormat disampaikan bahwa, dalam rangka meningkatkan kepedulian sosial terhadap sesama dan membantu menjaga ketersediaan stok darah nasional, kami dari <strong>{{ $collaboration->name }}</strong> bermaksud untuk menyelenggarakan kegiatan sosial donor darah secara kolaboratif. Oleh karena itu, kami mengajukan permohonan kerjasama kolaborasi pelaksanaan kegiatan donor darah kepada {{ $collaboration->pmi_id }}.
            </p>
            
            <p class="paragraph">
                Adapun rincian rencana pelaksanaan kegiatan tersebut adalah sebagai berikut:
            </p>

            <!-- Event Details Table -->
            <table class="event-details-table">
                <tr>
                    <td class="label">Nama Kegiatan</td>
                    <td class="colon">:</td>
                    <td>{{ $collaboration->event_name }}</td>
                </tr>
                <tr>
                    <td class="label">Hari / Tanggal</td>
                    <td class="colon">:</td>
                    <td>
                        @if($collaboration->proposed_date)
                            {{ date('l, d F Y', strtotime($collaboration->proposed_date)) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Waktu Pelaksanaan</td>
                    <td class="colon">:</td>
                    <td>{{ $collaboration->proposed_time }} WIB - Selesai</td>
                </tr>
                <tr>
                    <td class="label">Lokasi</td>
                    <td class="colon">:</td>
                    <td>{{ $collaboration->location }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Event</td>
                    <td class="colon">:</td>
                    <td>{{ $collaboration->event_type ?? 'Publik' }}</td>
                </tr>
                <tr>
                    <td class="label">Target Pendonor</td>
                    <td class="colon">:</td>
                    <td>{{ $collaboration->estimated_donors }} Calon Pendonor</td>
                </tr>
            </table>

            <p class="paragraph">
                Untuk menunjang kelancaran kegiatan tersebut, kami dari pihak penyelenggara telah menyiapkan beberapa fasilitas pendukung di lokasi, yang meliputi: 
                <strong>
                    {{ $collaboration->has_room ? 'Ruangan Acara' : '' }}
                    {{ $collaboration->has_furniture ? ', Meja & Kursi' : '' }}
                    {{ $collaboration->has_electricity ? ', Listrik/Daya' : '' }}
                    {{ $collaboration->has_parking ? ', Area Parkir' : '' }}
                </strong>.
                Kami sangat mengharapkan bantuan dari pihak {{ $collaboration->pmi_id }} untuk dapat memfasilitasi tim medis (afapresis/aftap), unit logistik donor darah, serta kantong darah yang dibutuhkan selama pelaksanaan acara.
            </p>
            
            <p class="paragraph">
                Demikian surat permohonan kerjasama kolaborasi ini kami sampaikan. Atas perhatian, dukungan, dan partisipasi aktif yang diberikan demi misi kemanusiaan ini, kami ucapkan terima kasih banyak.
            </p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Mengetahui,</p>
                <p class="signature-title"><strong>Petugas Penerima PMI</strong></p>
                <p class="signature-name">{{ $collaboration->admin->nama_lengkap ?? '_____________________' }}</p>
                <p>Staff {{ $collaboration->pmi_id }}</p>
            </div>
            <div class="signature-box">
                <p>&nbsp;</p>
                <p class="signature-title">Hormat Kami, <br><strong>Perwakilan Pengaju (PIC)</strong></p>
                <p class="signature-name">{{ $collaboration->pic_name }}</p>
                <p>PIC {{ $collaboration->name }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="letter-footer">
            <div>Markas Palang Merah Indonesia {{ $collaboration->pmi_id ?? 'Kota Serang' }} :</div>
            <div>Jalan Raya Utama, Kantor PMI {{ $collaboration->pmi_id ?? 'Kota Serang' }}</div>
            <div>Telp/Whatsapp : xxxxx</div>
        </div>

    </div>

</body>
</html>
