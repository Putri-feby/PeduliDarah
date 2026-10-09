# Entity Relationship Diagram (ERD)
# Sistem E-Ticket Donor Darah - Multi-Role Structure

## Tabel Utama

### 1. users (Tabel Akun Umum)
| Atribut | Tipe Data | Constraint | Deskripsi |
|---------|-----------|------------|-----------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik untuk setiap user |
| role | ENUM('donor', 'staff') | NOT NULL, DEFAULT 'donor' | Role user (donor atau staff) |
| nama_lengkap | VARCHAR(255) | NOT NULL | Nama lengkap user |
| email | VARCHAR(255) | NOT NULL, UNIQUE | Email user (harus unik) |
| no_telp | VARCHAR(20) | NOT NULL | Nomor telepon user |
| password | VARCHAR(255) | NOT NULL | Password terenkripsi |
| created_at | TIMESTAMP | NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NULL | Waktu update terakhir |

---

### 2. donor_profiles (Tabel Profil Pendonor)
| Atribut | Tipe Data | Constraint | Deskripsi |
|---------|-----------|------------|-----------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik untuk setiap profil donor |
| user_id | BIGINT UNSIGNED | FOREIGN KEY (users.id), ON DELETE CASCADE | ID user terkait (One-to-One) |
| jenis_kelamin | ENUM('pria', 'wanita', 'lainnya') | NOT NULL | Jenis kelamin pendonor |
| nik | VARCHAR(20) | NOT NULL, UNIQUE | Nomor Induk Kependudukan (harus unik) |
| golongan_darah | ENUM('A', 'B', 'AB', 'O') | NOT NULL | Golongan darah pendonor |
| tanggal_lahir | DATE | NOT NULL | Tanggal lahir pendonor |
| berat_badan | DECIMAL(5,2) | NOT NULL | Berat badan dalam kg |
| riwayat_penyakit | TEXT | NULL | Riwayat penyakit pendonor |
| pernah_donor | TINYINT(1) | DEFAULT 0 | Status pernah donor darah (0/1) |
| detail_riwayat_donor | TEXT | NULL | Detail riwayat donor darah |
| alergi | VARCHAR(255) | NULL | Alergi pendonor |
| obat | TEXT | NULL | Obat yang sedang dikonsumsi |
| created_at | TIMESTAMP | NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NULL | Waktu update terakhir |

---

### 3. staff_profiles (Tabel Profil Staff PMI)
| Atribut | Tipe Data | Constraint | Deskripsi |
|---------|-----------|------------|-----------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik untuk setiap profil staff |
| user_id | BIGINT UNSIGNED | FOREIGN KEY (users.id), ON DELETE CASCADE | ID user terkait (One-to-One) |
| jenis_kelamin | ENUM('pria', 'wanita', 'lainnya') | NOT NULL | Jenis kelamin staff |
| nik | VARCHAR(20) | NOT NULL, UNIQUE | Nomor Induk Kependudukan (harus unik) |
| unit_pmi | VARCHAR(255) | NOT NULL | Unit PMI tempat staff bekerja |
| nomor_pegawai | VARCHAR(50) | NOT NULL | Nomor pegawai staff |
| foto_id_card | VARCHAR(255) | NULL | Path foto ID card pegawai |
| created_at | TIMESTAMP | NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NULL | Waktu update terakhir |

---

## Relasi Antar Tabel

### users ↔ donor_profiles
- **Kardinalitas**: One-to-One (1:1)
- **Foreign Key**: donor_profiles.user_id → users.id
- **Constraint**: ON DELETE CASCADE
- **Deskripsi**: Satu user dengan role 'donor' memiliki tepat satu profil donor. Jika user dihapus, profil donor juga dihapus.

### users ↔ staff_profiles
- **Kardinalitas**: One-to-One (1:1)
- **Foreign Key**: staff_profiles.user_id → users.id
- **Constraint**: ON DELETE CASCADE
- **Deskripsi**: Satu user dengan role 'staff' memiliki tepat satu profil staff. Jika user dihapus, profil staff juga dihapus.

---

## Diagram Relasi

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ PK  id          │
│     role        │
│     nama_lengkap│
│     email (U)   │
│     no_telp     │
│     password    │
│     created_at  │
│     updated_at  │
└────────┬────────┘
         │
         │ 1:1
         │
    ┌────┴────┐
    │         │
    ▼         ▼
┌──────────────┐  ┌──────────────┐
│donor_profiles│  │staff_profiles│
├──────────────┤  ├──────────────┤
│ PK  id       │  │ PK  id       │
│ FK  user_id  │  │ FK  user_id  │
│     jenis_    │  │     jenis_    │
│     kelamin   │  │     kelamin   │
│     nik (U)   │  │     nik (U)   │
│     golongan_ │  │     unit_pmi  │
│     darah     │  │     nomor_    │
│     tanggal_   │  │     pegawai   │
│     lahir     │  │     foto_id_  │
│     berat_    │  │     card      │
│     badan     │  │     created_  │
│     riwayat_  │  │     at        │
│     penyakit  │  │     updated_  │
│     pernah_   │  │     at        │
│     donor     │  └──────────────┘
│     detail_   │
│     riwayat_  │
│     donor     │
│     alergi    │
│     obat      │
│     created_  │
│     at        │
│     updated_  │
│     at        │
└──────────────┘
```

---

## Catatan Penting

### Constraint Unik
1. **users.email** - Email harus unik untuk setiap user
2. **donor_profiles.nik** - NIK harus unik untuk setiap profil donor
3. **staff_profiles.nik** - NIK harus unik untuk setiap profil staff

### Kardinalitas Relasi
- **users → donor_profiles**: 1:1 (Satu user donor memiliki satu profil donor)
- **users → staff_profiles**: 1:1 (Satu user staff memiliki satu profil staff)

### Aturan Bisnis
1. Satu user hanya memiliki satu role (donor atau staff)
2. User dengan role 'donor' wajib memiliki data di donor_profiles
3. User dengan role 'staff' wajib memiliki data di staff_profiles
4. NIK di donor_profiles dan staff_profiles terpisah (tidak boleh duplikat di masing-masing tabel)
5. Email di users harus unik di seluruh sistem

---

## Tabel Pendukung (Sudah Ada)

### donation_schedules
- Menyimpan jadwal kegiatan donor darah
- Relasi dengan users melalui admin_id (jika diperlukan)

### donation_registrations
- Menyimpan pendaftaran donor ke jadwal tertentu
- Relasi dengan users (user_id) dan donation_schedules (schedule_id)

### etickets
- Menyimpan tiket elektronik untuk donor
- Relasi dengan users (user_id) dan donation_schedules (schedule_id)

### collaborations
- Menyimpan data kolaborator/instansi
- Relasi dengan users melalui admin_id (jika diperlukan)

### queues
- Menyimpan data antrian donor
- Relasi dengan users (user_id) dan donation_schedules (schedule_id)
