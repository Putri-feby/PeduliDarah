CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('donor', 'staff') NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE donor_profiles (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    nik VARCHAR(20) UNIQUE NOT NULL,
    foto_ktp VARCHAR(255),
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    golongan_darah ENUM('A', 'B', 'AB', 'O') NOT NULL,
    berat_badan DECIMAL(5,2) NOT NULL,
    riwayat_penyakit TEXT,
    pernah_donor BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE staff_profiles (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    nik VARCHAR(20) UNIQUE NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    unit_pmi VARCHAR(100) NOT NULL,
    nomor_pegawai VARCHAR(50) UNIQUE NOT NULL,
    foto_id_card VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
