@extends('layouts.app')

@section('title', 'Profil Donor')

@section('content')
<style>
    .profile-wrap {
        height: calc(100vh - 4rem);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        box-sizing: border-box;
        background: #f9fafb;
    }

    .pcard {
        background: #fff;
        border-radius: 1rem;
        border: 1px solid #f1f1f1;
        box-shadow: 0 1px 8px rgba(220,38,38,0.05);
    }

    /* ─── Header row ─── */
    .header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.6rem 1rem;
        flex-shrink: 0;
    }
    .header-row .left {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .hicon {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #fff0f0;
        display: flex; align-items: center; justify-content: center;
        color: #dc2626;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .htitle { font-size: 0.95rem; font-weight: 800; color: #1f2937; line-height: 1.1; }
    .htitle span { color: #dc2626; }
    .hsub { font-size: 0.68rem; color: #9ca3af; }
    .edit-btn {
        display: inline-flex; align-items: center; gap: 5px;
        border: 1.5px solid #dc2626; color: #dc2626; background: #fff;
        border-radius: 0.5rem; padding: 4px 14px;
        font-size: 0.75rem; font-weight: 600; text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }
    .edit-btn:hover { background: #dc2626; color: #fff; }

    /* ─── Hero banner ─── */
    .hero-banner {
        background: linear-gradient(135deg, #fff0f0 0%, #ffe4e4 100%);
        border-radius: 1rem;
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .hero-banner::after {
        content: '';
        position: absolute;
        right: -20px; top: -20px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(220,38,38,0.07);
    }
    .avatar-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: #ffd0d0;
        display: flex; align-items: center; justify-content: center;
        position: relative; flex-shrink: 0;
    }
    .avatar-circle .shield {
        position: absolute; bottom: 2px; right: 2px;
        width: 20px; height: 20px; border-radius: 50%;
        background: #dc2626;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
    }
    .donor-badge {
        display: inline-flex; align-items: center; gap: 4px;
        background: #fff; color: #dc2626;
        border: 1.5px solid #fca5a5; border-radius: 999px;
        padding: 1px 10px; font-size: 0.7rem; font-weight: 600;
        margin-bottom: 4px;
    }

    /* ─── Info grid ─── */
    .section-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.82rem; font-weight: 700; color: #dc2626;
        padding: 0.5rem 1rem 0.3rem;
        flex-shrink: 0;
    }
    .section-label .slicon {
        width: 22px; height: 22px; border-radius: 50%;
        background: #fff0f0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; color: #dc2626;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.45rem;
        padding: 0 0.75rem 0.75rem;
        flex: 1;
    }

    .info-card {
        background: #fff;
        border: 1.5px solid #f3f4f6;
        border-radius: 0.75rem;
        padding: 0.5rem 0.7rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .info-card:hover {
        border-color: #fca5a5;
        box-shadow: 0 2px 8px rgba(220,38,38,0.07);
    }
    .iicon {
        width: 32px; height: 32px; border-radius: 50%;
        background: #fff0f0;
        display: flex; align-items: center; justify-content: center;
        color: #dc2626; font-size: 0.8rem; flex-shrink: 0;
    }
    .ilabel { font-size: 0.62rem; color: #9ca3af; font-weight: 500; margin-bottom: 1px; }
    .ivalue { font-size: 0.82rem; font-weight: 700; color: #1f2937; }
    .ivalue.red { color: #dc2626; }

    /* ─── Motivation strip ─── */
    .moti-strip {
        display: flex; align-items: center; gap: 0.75rem;
        background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
        border: 1.5px solid #fecaca;
        border-radius: 0.75rem;
        padding: 0.55rem 1rem;
        flex-shrink: 0;
        position: relative; overflow: hidden;
    }
    .moti-strip .bg-ico {
        position: absolute; right: 1rem; font-size: 2.5rem;
        color: rgba(220,38,38,0.08);
    }
    .moti-icon {
        width: 32px; height: 32px; border-radius: 50%;
        background: #fff; border: 1.5px solid #fca5a5;
        display: flex; align-items: center; justify-content: center;
        color: #dc2626; font-size: 0.8rem; flex-shrink: 0;
    }
</style>

<div class="profile-wrap">

    {{-- HEADER --}}
    <div class="pcard header-row">
        <div class="left">
            <div class="hicon"><i class="fas fa-user"></i></div>
            <div>
                <div class="htitle">Profil <span>Donor</span></div>
                <div class="hsub">Informasi pribadi dan riwayat donor darah Anda</div>
            </div>
        </div>
        <a href="#" class="edit-btn">
            <i class="fas fa-pencil-alt" style="font-size:0.65rem;"></i> Edit Profil
        </a>
    </div>

    {{-- HERO --}}
    <div class="hero-banner pcard">
        <div class="avatar-circle">
            <i class="fas fa-user" style="color:#dc2626;font-size:1.7rem;"></i>
            <div class="shield">
                <i class="fas fa-shield-alt" style="color:#fff;font-size:0.5rem;"></i>
            </div>
        </div>
        <div style="z-index:1;">
            <div style="font-size:1.25rem;font-weight:900;color:#1f2937;line-height:1.1;margin-bottom:5px;">
                {{ $user->nama_lengkap ?? $user->name }}
            </div>
            <div class="donor-badge">
                <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> Donor Aktif
            </div>
            <div style="font-size:0.72rem;color:#6b7280;display:flex;align-items:center;gap:5px;margin-top:3px;">
                <i class="far fa-calendar-alt" style="color:#dc2626;"></i>
                Bergabung sejak {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}
            </div>
        </div>
    </div>

    {{-- INFO PRIBADI --}}
    <div class="pcard" style="flex:1;display:flex;flex-direction:column;overflow:hidden;">
        <div class="section-label">
            <div class="slicon"><i class="fas fa-user"></i></div>
            Informasi Pribadi
        </div>

        <div class="info-grid">
            <div class="info-card">
                <div class="iicon"><i class="fas fa-id-card"></i></div>
                <div>
                    <div class="ilabel">Nama Lengkap</div>
                    <div class="ivalue">{{ $user->nama_lengkap ?? $user->name }}</div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="ilabel">Email</div>
                    <div class="ivalue">{{ $user->email }}</div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-phone"></i></div>
                <div>
                    <div class="ilabel">No. Telepon</div>
                    <div class="ivalue">{{ $user->no_telp ?? '-' }}</div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-venus-mars"></i></div>
                <div>
                    <div class="ilabel">Jenis Kelamin</div>
                    <div class="ivalue">
                        @if($user->jenis_kelamin === 'L') Laki-laki
                        @elseif($user->jenis_kelamin === 'P') Perempuan
                        @else {{ $user->jenis_kelamin ?? '-' }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-fingerprint"></i></div>
                <div>
                    <div class="ilabel">NIK</div>
                    <div class="ivalue">{{ $user->nik ?? '-' }}</div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-tint"></i></div>
                <div>
                    <div class="ilabel">Golongan Darah</div>
                    <div class="ivalue">{{ $donorProfile->golongan_darah ?? '-' }}</div>
                </div>
            </div>
            <div class="info-card">
                <div class="iicon"><i class="fas fa-plus"></i></div>
                <div>
                    <div class="ilabel">Rhesus</div>
                    <div class="ivalue">{{ $donorProfile->rhesus ?? '-' }}</div>
                </div>
            </div>

            <div class="info-card">
                <div class="iicon"><i class="fas fa-hand-holding-heart"></i></div>
                <div>
                    <div class="ilabel">Total Donor Darah</div>
                    <div class="ivalue red">{{ $donationCount }} kali</div>
                    @if($donationCount > 0)
                    <div style="font-size:0.6rem;color:#9ca3af;">Terima kasih ❤️</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MOTIVASI --}}
    <div class="moti-strip">
        <div class="moti-icon"><i class="fas fa-shield-alt"></i></div>
        <div style="z-index:1;">
            <div style="font-size:0.8rem;font-weight:700;color:#dc2626;">Tetap Sehat, Tetap Berdonasi</div>
            <div style="font-size:0.7rem;color:#6b7280;">Jaga kesehatan dan penuhi syarat donor darah agar Anda dapat terus membantu sesama.</div>
        </div>
        <div class="bg-ico"><i class="fas fa-users"></i></div>
    </div>

</div>
@endsection
