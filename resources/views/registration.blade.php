<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="container">
        <h1>Registrasi E-Ticket Donor Darah</h1>
        <div class="progress-step">
            <div class="step active">Jenis Akun</div>
            <div class="step">Data Diri</div>
            <div class="step">Data Khusus</div>
        </div>
        <form>
            <div class="account-type">
                <h2>Pilih Jenis Akun</h2>
                <div class="card-selection">
                    <label class="card">
                        <input type="radio" name="role" value="donor">
                        <div class="card-content">
                            <h3>Pendonor</h3>
                            <p>Mendaftar sebagai pendonor darah.</p>
                        </div>
                    </label>
                    <label class="card">
                        <input type="radio" name="role" value="staff">
                        <div class="card-content">
                            <h3>Staff PMI</h3>
                            <p>Mendaftar sebagai petugas PMI.</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="personal-data">
                <h2>Data Diri</h2>
                <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" id="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" required>
                </div>
                <div class="form-group">
                    <label for="birthplace">Tempat Lahir</label>
                    <input type="text" id="birthplace" required>
                </div>
                <div class="form-group">
                    <label for="birthdate">Tanggal Lahir</label>
                    <input type="date" id="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select id="gender" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" required>
                    <span class="eye-icon">👁️</span>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Konfirmasi Password</label>
                    <input type="password" id="confirm-password" required>
                    <span class="eye-icon">👁️</span>
                </div>
            </div>
            <div class="health-info" style="display:none;">
                <h2>Informasi Kesehatan</h2>
                <div class="form-group">
                    <label for="blood-type">Golongan Darah</label>
                    <select id="blood-type">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="weight">Berat Badan (kg)</label>
                    <input type="number" id="weight" required>
                </div>
                <div class="form-group">
                    <label for="medical-history">Riwayat Penyakit</label>
                    <textarea id="medical-history"></textarea>
                </div>
                <div class="form-group">
                    <label>Pernah Donor Darah?</label>
                    <input type="radio" name="donation-history" value="yes"> Ya
                    <input type="radio" name="donation-history" value="no"> Tidak
                </div>
                <div class="form-group optional-fields" style="display:none;">
                    <label for="donation-frequency">Frekuensi Donor</label>
                    <input type="text" id="donation-frequency">
                </div>
                <div class="form-group optional-fields" style="display:none;">
                    <label for="last-donation">Donor Terakhir</label>
                    <input type="date" id="last-donation">
                </div>
            </div>
            <div class="staff-info" style="display:none;">
                <h2>Data Staff PMI</h2>
                <div class="form-group">
                    <label for="unit">Unit PMI</label>
                    <input type="text" id="unit" required>
                </div>
                <div class="form-group">
                    <label for="employee-number">Nomor Pegawai</label>
                    <input type="text" id="employee-number" required>
                </div>
                <div class="form-group">
                    <label for="id-card">Upload ID Card Pegawai</label>
                    <input type="file" id="id-card" accept="image/jpeg, image/png, application/pdf">
                </div>
            </div>
            <button type="submit">Daftar</button>
        </form>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
