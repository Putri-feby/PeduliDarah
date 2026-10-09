<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Peduli Darah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            display: flex;
            overflow: hidden;
            max-height: 95vh;
        }
        .left-panel {
            width: 35%;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 20s infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-20px, -20px) rotate(180deg); }
        }
        .right-panel {
            width: 65%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .role-card {
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }
        .role-card:hover {
            border-color: #dc2626;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
        }
        .role-card.selected {
            border-color: #dc2626;
            background: #fef2f2;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }
        .role-card input[type="radio"] {
            display: none;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
            color: #374151;
            font-size: 13px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .form-row-full {
            grid-column: 1 / -1;
        }
        .btn {
            padding: 12px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-primary {
            background: #dc2626;
            color: white;
        }
        .btn-primary:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        .file-upload {
            border: 2px dashed #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            border-color: #dc2626;
            background: #fef2f2;
        }
        .file-upload input {
            display: none;
        }
        .error-message {
            color: #dc2626;
            font-size: 11px;
            margin-top: 4px;
            display: none;
        }
        .form-group.error input,
        .form-group.error select,
        .form-group.error textarea {
            border-color: #dc2626;
        }
        .form-group.error .error-message {
            display: block;
        }
        .form-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .form-section.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-height: none;
            }
            .left-panel {
                width: 100%;
                padding: 30px;
            }
            .right-panel {
                width: 100%;
                padding: 30px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div style="text-align: center; position: relative; z-index: 1;">
                <div style="margin: 0 auto 20px; display: flex; justify-content: center; background-color: white; padding: 15px 25px; border-radius: 12px; display: inline-block;">
                    <img src="{{ asset('images/logo-pmi.svg') }}" alt="Palang Merah Indonesia" style="height: 70px; width: auto;">
                </div>

                <p style="font-size: 14px; opacity: 0.8; line-height: 1.6;">Bergabung untuk Menyelamatkan Nyawa</p>
                <div style="margin-top: 24px; padding: 12px; background: rgba(255,255,255,0.1); border-radius: 10px; backdrop-filter: blur(10px);">
                    <i class="fas fa-shield-alt" style="margin-right: 6px;"></i>
                    <span style="font-size: 12px;">Data Anda aman dan terlindungi</span>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <form id="registrationForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Step 1: Pilih Jenis Akun -->
                <div class="form-section active" id="accountTypeSection">
                    <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 6px;">Pilih Jenis Akun</h2>
                    <p style="color: #6b7280; font-size: 13px; margin-bottom: 20px;">Silakan pilih jenis akun yang akan didaftarkan.</p>

                    <label class="role-card" onclick="selectRole('donor')">
                        <input type="radio" name="role" value="donor" required>
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; background: #fef2f2; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <i class="fas fa-hand-holding-heart" style="font-size: 20px; color: #dc2626;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Pendonor</h3>
                                <p style="font-size: 12px; color: #6b7280;">Mendaftar sebagai pendonor darah untuk mengikuti kegiatan donor darah dan membantu sesama.</p>
                            </div>
                            <div class="radio-indicator" style="width: 18px; height: 18px; border: 2px solid #e5e7eb; border-radius: 50%; margin-left: 12px;"></div>
                        </div>
                    </label>

                    <label class="role-card" onclick="selectRole('staff')">
                        <input type="radio" name="role" value="staff">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; background: #fef2f2; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <i class="fas fa-user-tie" style="font-size: 20px; color: #dc2626;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Staff PMI</h3>
                                <p style="font-size: 12px; color: #6b7280;">Mendaftar sebagai petugas PMI untuk mengelola kegiatan donor darah dan data pendonor.</p>
                            </div>
                            <div class="radio-indicator" style="width: 18px; height: 18px; border: 2px solid #e5e7eb; border-radius: 50%; margin-left: 12px;"></div>
                        </div>
                    </label>
                </div>

                <!-- Common Data Diri Section -->
                <div class="form-section" id="commonDataSection">
                    <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 6px;">Data Diri</h2>
                    <p style="color: #6b7280; font-size: 13px; margin-bottom: 20px;">Lengkapi data diri Anda untuk melanjutkan registrasi.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" required placeholder="Masukkan nama lengkap" maxlength="100" onkeypress="return isAlpha(event)" oninput="validateName(this)">
                            <div class="error-message">Nama lengkap harus diisi</div>
                            <div id="nameWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">Nama hanya boleh diisi dengan huruf dan spasi</div>
                            <div id="nameLengthWarning" style="color: #d97706; font-size: 12px; margin-top: 4px; display: none;">Batas maksimal karakter telah tercapai (100 karakter).</div>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" required placeholder="nama@email.com" oninput="validateEmail(this)">
                            <div class="error-message">Email harus valid</div>
                            <div id="emailWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">Format email tidak valid</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nomor Telepon *</label>
                            <input type="text" name="no_telp" id="no_telp" required placeholder="Contoh : 08123456789" maxlength="15" onkeypress="return isNumeric(event)" oninput="validatePhone(this)">
                            <div class="error-message">Nomor telepon harus diisi</div>
                            <div id="phoneWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">Nomor telepon hanya boleh diisi dengan angka</div>
                            <div id="phoneLengthWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">Nomor telepon minimal 11 angka</div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                            <div class="error-message">Jenis kelamin harus dipilih</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>NIK *</label>
                            <input type="text" name="nik" id="nik" required placeholder="Masukkan nomor NIK" maxlength="16" oninput="validateNIK(this)" onkeypress="return isNumeric(event)">
                            <div class="error-message">NIK harus diisi</div>
                            <div id="nikWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">NIK hanya boleh diisi dengan angka</div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" required>
                            <div class="error-message">Tanggal lahir harus diisi</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password *</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" style="padding-right: 40px;" oninput="validatePassword(this)">
                                <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af; padding: 0;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message">Password harus diisi</div>
                            <div id="passwordLengthWarning" style="color: #dc2626; font-size: 12px; margin-top: 4px; display: none;">Password minimal 8 karakter.</div>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password *</label>
                            <div style="position: relative;">
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password" style="padding-right: 40px;">
                                <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af; padding: 0;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message">Password tidak cocok</div>
                        </div>
                    </div>
                </div>

                <!-- Pendonor Form Section -->
                <div class="form-section" id="donorFormSection">
                    <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 6px;">Informasi Kesehatan</h2>
                    <p style="color: #6b7280; font-size: 13px; margin-bottom: 20px;">Informasi kesehatan Anda penting untuk keamanan proses donor darah.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Golongan Darah *</label>
                            <select name="golongan_darah" required>
                                <option value="">Pilih golongan darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                            <div class="error-message">Golongan darah harus dipilih</div>
                        </div>
                        <div class="form-group">
                            <label>Rhesus *</label>
                            <select name="rhesus" required>
                                <option value="">Pilih rhesus</option>
                                <option value="+">+</option>
                                <option value="-">-</option>
                            </select>
                            <div class="error-message">Rhesus harus dipilih</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Pernah Donor Darah? *</label>
                            <select name="pernah_donor" required>
                                <option value="">Pilih</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div class="error-message">Pilih salah satu</div>
                        </div>
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="form-group form-row-full">
                        <label>Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit" rows="2" placeholder="Jelaskan riwayat penyakit yang pernah atau sedang Anda derita (jika ada)"></textarea>
                    </div>

                    <div class="form-group form-row-full">
                        <label>Detail Riwayat Donor</label>
                        <textarea name="detail_riwayat_donor" rows="2" placeholder="Jelaskan kapan dan di mana Anda pernah donor darah (jika pernah)"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Alergi</label>
                            <input type="text" name="alergi" placeholder="Sebutkan jika Anda memiliki alergi tertentu">
                        </div>
                        <div class="form-group">
                            <label>Obat</label>
                            <input type="text" name="obat" placeholder="Sebutkan obat yang sedang Anda konsumsi (jika ada)">
                        </div>
                    </div>
                </div>

                <!-- Staff PMI Form Section -->
                <div class="form-section" id="staffFormSection">
                    <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 6px;">Data Staff</h2>
                    <p style="color: #6b7280; font-size: 13px; margin-bottom: 20px;">Lengkapi data staff PMI Anda.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Unit PMI *</label>
                            <select name="unit_pmi" required>
                                <option value="">Pilih Unit PMI</option>
                                @foreach($pmis as $pmi)
                                    <option value="{{ $pmi->name }}">{{ $pmi->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message">Unit PMI harus dipilih</div>
                        </div>
                        <div class="form-group">
                            <label>Nomor Pegawai *</label>
                            <input type="text" name="nomor_pegawai" required placeholder="Masukkan nomor pegawai">
                            <div class="error-message">Nomor pegawai harus diisi</div>
                        </div>
                    </div>

                    <div class="form-group form-row-full">
                        <label>Upload ID Card Pegawai *</label>
                        <div class="file-upload" onclick="document.getElementById('foto_id_card').click()">
                            <input type="file" name="foto_id_card" id="foto_id_card" accept="image/*" required onchange="handleFileUpload(this)">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: #dc2626; margin-bottom: 8px;"></i>
                            <p style="color: #6b7280; font-size: 12px;">Klik untuk upload atau drag & drop</p>
                            <p style="color: #9ca3af; font-size: 11px; margin-top: 4px;">Format: JPG, PNG (Max 5MB)</p>
                            <div id="employeeFileName" style="margin-top: 8px; color: #dc2626; font-weight: 500;"></div>
                        </div>
                        <div class="error-message">ID Card pegawai harus diupload</div>
                    </div>
                </div>

                <!-- Navigation -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <button type="button" class="btn" id="backBtn" onclick="goBack()" style="background: #f3f4f6; color: #6b7280; display: none;">
                        <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="goNext()">
                        Selanjutnya<i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </button>
                    <button type="button" class="btn btn-primary" id="submitBtn" style="display: none;" onclick="submitForm()">
                        <i class="fas fa-user-plus" style="margin-right: 8px;"></i>Daftar
                    </button>
                </div>

                <div style="text-align: center; margin-top: 16px;">
                    <span style="color: #6b7280; font-size: 13px;">Sudah memiliki akun? </span>
                    <a href="{{ route('login') }}" style="color: #dc2626; font-weight: 600; text-decoration: none;">Masuk disini</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentSection = 0;
        const sections = ['accountTypeSection', 'commonDataSection', 'donorFormSection', 'staffFormSection'];
        let selectedRole = null;

        function selectRole(role) {
            selectedRole = role;
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('selected');
                const radio = card.querySelector('input[type="radio"]');
                const indicator = card.querySelector('.radio-indicator');
                if (radio.value === role) {
                    card.classList.add('selected');
                    radio.checked = true;
                    indicator.style.background = '#dc2626';
                    indicator.style.borderColor = '#dc2626';
                } else {
                    indicator.style.background = 'transparent';
                    indicator.style.borderColor = '#e5e7eb';
                }
            });
        }

        function showSection(index) {
            sections.forEach((sectionId, i) => {
                const section = document.getElementById(sectionId);
                if (i === index) {
                    section.classList.add('active');
                } else {
                    section.classList.remove('active');
                }
            });

            // Update navigation buttons
            document.getElementById('backBtn').style.display = index > 0 ? 'inline-flex' : 'none';

            // Check if current section is role-specific form (donor or staff)
            const isRoleSpecificSection = index === 2 || index === 3;
            
            if (isRoleSpecificSection) {
                document.getElementById('nextBtn').style.display = 'none';
                document.getElementById('submitBtn').style.display = 'inline-flex';
            } else {
                document.getElementById('nextBtn').style.display = 'inline-flex';
                document.getElementById('submitBtn').style.display = 'none';
            }

            currentSection = index;
        }

        function validateCurrentSection() {
            const currentSectionElement = document.getElementById(sections[currentSection]);
            const inputs = currentSectionElement.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                const formGroup = input.closest('.form-group') || input.closest('.role-card');
                if (!input.value.trim()) {
                    isValid = false;
                    if (formGroup) {
                        formGroup.classList.add('error');
                    }
                } else {
                    if (formGroup) {
                        formGroup.classList.remove('error');
                    }
                }
            });

            // Special validation for password
            if (currentSection === 1) {
                const password = document.querySelector('input[name="password"]');
                const passwordConfirm = document.querySelector('input[name="password_confirmation"]');
                
                if (password && password.value.length > 0) {
                    if (password.value.length < 8) {
                        isValid = false;
                        password.closest('.form-group').classList.add('error');
                        const lengthWarning = document.getElementById('passwordLengthWarning');
                        if (lengthWarning) lengthWarning.style.display = 'block';
                    }
                }

                if (password.value !== passwordConfirm.value) {
                    isValid = false;
                    passwordConfirm.closest('.form-group').classList.add('error');
                }

                // Special validation for Email
                const emailInput = document.getElementById('email');
                if (emailInput && emailInput.value.length > 0) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailInput.value)) {
                        isValid = false;
                        const formGroup = emailInput.closest('.form-group');
                        if (formGroup) {
                            formGroup.classList.add('error');
                            const emailWarning = document.getElementById('emailWarning');
                            if (emailWarning) {
                                emailWarning.style.display = 'block';
                            }
                        }
                    }
                }

                // Special validation for Phone Number minimum length
                const phoneInput = document.getElementById('no_telp');
                if (phoneInput && phoneInput.value.length > 0) {
                    if (phoneInput.value.length < 11) {
                        isValid = false;
                        const formGroup = phoneInput.closest('.form-group');
                        if (formGroup) {
                            formGroup.classList.add('error');
                            const phoneLengthWarning = document.getElementById('phoneLengthWarning');
                            if (phoneLengthWarning) {
                                phoneLengthWarning.style.display = 'block';
                            }
                        }
                    }
                }

                // Special validation for NIK - must be exactly 16 digits
                const nikInput = document.getElementById('nik');
                if (nikInput && nikInput.value.length > 0) {
                    if (nikInput.value.length !== 16) {
                        isValid = false;
                        const formGroup = nikInput.closest('.form-group');
                        if (formGroup) {
                            formGroup.classList.add('error');
                            const errorDiv = formGroup.querySelector('.error-message');
                            if (errorDiv) {
                                errorDiv.textContent = 'NIK harus tepat 16 digit';
                            }
                        }
                    } else {
                        const formGroup = nikInput.closest('.form-group');
                        if (formGroup) {
                            formGroup.classList.remove('error');
                            const errorDiv = formGroup.querySelector('.error-message');
                            if (errorDiv) {
                                errorDiv.textContent = 'NIK harus diisi';
                            }
                        }
                    }
                }
            }

            return isValid;
        }

        function isNumeric(event) {
            const key = event.key;
            // Allow only numbers (0-9)
            if (!/^\d$/.test(key)) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        function isAlpha(event) {
            const key = event.key;
            // Allow only letters (a-z, A-Z) and space
            if (!/^[a-zA-Z\s]$/.test(key)) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        function validateNIK(input) {
            const nikWarning = document.getElementById('nikWarning');
            const value = input.value;

            // Check if value contains non-numeric characters
            if (/\D/.test(value)) {
                nikWarning.style.display = 'block';
                input.value = value.replace(/\D/g, ''); // Remove non-numeric characters
            } else {
                nikWarning.style.display = 'none';
            }
        }

        function validatePhone(input) {
            const phoneWarning = document.getElementById('phoneWarning');
            const phoneLengthWarning = document.getElementById('phoneLengthWarning');
            let value = input.value;

            // Check if value contains non-numeric characters
            if (/\D/.test(value)) {
                phoneWarning.style.display = 'block';
                input.value = value.replace(/\D/g, ''); // Remove non-numeric characters
                value = input.value;
            } else {
                phoneWarning.style.display = 'none';
            }

            if (value.length > 0 && value.length < 11) {
                phoneLengthWarning.style.display = 'block';
            } else {
                phoneLengthWarning.style.display = 'none';
            }
        }

        function validatePassword(input) {
            const lengthWarning = document.getElementById('passwordLengthWarning');
            const value = input.value;

            if (value.length > 0 && value.length < 8) {
                lengthWarning.style.display = 'block';
                input.closest('.form-group').classList.add('error');
            } else {
                lengthWarning.style.display = 'none';
                input.closest('.form-group').classList.remove('error');
            }
        }

        function validateEmail(input) {
            const emailWarning = document.getElementById('emailWarning');
            const value = input.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (value.length > 0 && !emailRegex.test(value)) {
                emailWarning.style.display = 'block';
                input.closest('.form-group').classList.add('error');
            } else {
                emailWarning.style.display = 'none';
                input.closest('.form-group').classList.remove('error');
            }
        }

        function validateName(input) {
            const nameWarning = document.getElementById('nameWarning');
            const nameLengthWarning = document.getElementById('nameLengthWarning');
            let value = input.value;

            // Check if value contains non-letter characters (except spaces)
            if (/[^a-zA-Z\s]/.test(value)) {
                nameWarning.style.display = 'block';
                input.value = value.replace(/[^a-zA-Z\s]/g, ''); // Remove non-letter characters
                value = input.value;
            } else {
                nameWarning.style.display = 'none';
            }

            if (value.length >= 100) {
                nameLengthWarning.style.display = 'block';
            } else {
                nameLengthWarning.style.display = 'none';
            }
        }

        function showDuplicateError(fieldName, message) {
            const input = document.querySelector(`[name="${fieldName}"]`) || document.getElementById(fieldName);
            if (input) {
                const formGroup = input.closest('.form-group');
                if (formGroup) {
                    formGroup.classList.add('error');
                    const errorDiv = formGroup.querySelector('.error-message');
                    if (errorDiv) {
                        errorDiv.textContent = message;
                        errorDiv.style.display = 'block';
                    }
                }
            }
        }

        function resetDuplicateErrors() {
            const fields = ['email', 'no_telp', 'nik'];
            fields.forEach(fieldName => {
                const input = document.querySelector(`[name="${fieldName}"]`) || document.getElementById(fieldName);
                if (input) {
                    const formGroup = input.closest('.form-group');
                    if (formGroup) {
                        formGroup.classList.remove('error');
                        const errorDiv = formGroup.querySelector('.error-message');
                        if (errorDiv) {
                            if (fieldName === 'email') errorDiv.textContent = 'Email harus valid';
                            if (fieldName === 'no_telp') errorDiv.textContent = 'Nomor telepon harus diisi';
                            if (fieldName === 'nik') errorDiv.textContent = 'NIK harus diisi';
                            errorDiv.style.display = '';
                        }
                    }
                }
            });
        }

        async function goNext() {
            if (validateCurrentSection()) {
                if (currentSection === 0) {
                    // From account type to common data
                    if (!selectedRole) {
                        alert('Silakan pilih jenis akun terlebih dahulu');
                        return;
                    }
                    showSection(1);
                } else if (currentSection === 1) {
                    // From common data to role-specific form
                    const nextBtn = document.getElementById('nextBtn');
                    const originalText = nextBtn.innerHTML;
                    nextBtn.disabled = true;
                    nextBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memeriksa...';
                    
                    try {
                        const email = document.querySelector('input[name="email"]').value;
                        const no_telp = document.getElementById('no_telp').value;
                        const nik = document.getElementById('nik').value;
                        
                        const response = await fetch('/check-duplicates', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ email, no_telp, nik })
                        });
                        
                        const result = await response.json();
                        
                        let hasDuplicate = false;
                        resetDuplicateErrors();
                        
                        if (result.email) {
                            showDuplicateError('email', 'Email ini sudah terdaftar');
                            hasDuplicate = true;
                        }
                        if (result.no_telp) {
                            showDuplicateError('no_telp', 'no telah terdaftar');
                            hasDuplicate = true;
                        }
                        if (result.nik) {
                            showDuplicateError('nik', 'NIK ini sudah terdaftar');
                            hasDuplicate = true;
                        }
                        
                        if (hasDuplicate) {
                            return; // stay on this section
                        }
                        
                        if (selectedRole === 'donor') {
                            showSection(2); // donor form
                        } else if (selectedRole === 'staff') {
                            showSection(3); // staff form
                        }
                    } catch (error) {
                        console.error('Error checking duplicates:', error);
                        alert('Terjadi kesalahan saat memeriksa data. Silakan coba lagi.');
                    } finally {
                        nextBtn.disabled = false;
                        nextBtn.innerHTML = originalText;
                    }
                }
            }
        }

        function goBack() {
            if (currentSection === 1) {
                showSection(0);
            } else if (currentSection === 2 || currentSection === 3) {
                showSection(1);
            }
        }

        function handleFileUpload(input) {
            const fileName = document.getElementById('employeeFileName');
            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name;
                input.closest('.form-group').classList.remove('error');
            }
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Remove error state on input
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', function() {
                this.closest('.form-group')?.classList.remove('error');
            });
        });

        function submitForm() {
            console.log('submitForm called');
            
            // Validate current section
            const isValid = validateCurrentSection();
            console.log('Validation result:', isValid);
            
            if (!isValid) {
                console.log('Validation failed, form not submitted');
                return;
            }
            
            console.log('Validation passed, submitting form');
            
            // Create FormData
            const formData = new FormData(document.getElementById('registrationForm'));
            
            // Log form data
            console.log('Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            // Check for missing required fields
            const requiredFields = ['role', 'nama_lengkap', 'email', 'no_telp', 'jenis_kelamin', 'nik', 'tanggal_lahir', 'password', 'password_confirmation'];
            const missingFields = [];
            
            requiredFields.forEach(field => {
                if (!formData.has(field) || formData.get(field) === '') {
                    missingFields.push(field);
                }
            });
            
            if (missingFields.length > 0) {
                console.error('Missing required fields:', missingFields);
                alert('Field yang belum diisi: ' + missingFields.join(', '));
                return;
            }
            
            // Submit via AJAX
            fetch('{{ route('register') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                console.log('Response data:', data);
                
                if (response.ok) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message || 'Registrasi berhasil! Silakan login.',
                        icon: 'success',
                        confirmButtonText: 'Lanjut Login',
                        confirmButtonColor: '#dc2626'
                    }).then((result) => {
                        window.location.href = '{{ route('login') }}';
                    });
                } else if (response.status === 422) {
                    // Handle Laravel/PHP validation errors
                    let validationErrors = '';
                    if (data.errors) {
                        if (Array.isArray(data.errors)) {
                            validationErrors = data.errors.join('\n');
                        } else {
                            validationErrors = Object.values(data.errors).flat().join('\n');
                        }
                    } else if (data.message) {
                        validationErrors = data.message;
                    }
                    Swal.fire({
                        title: 'Validasi Gagal!',
                        text: validationErrors,
                        icon: 'warning',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#dc2626'
                    });
                } else {
                    Swal.fire({
                        title: 'Oops...',
                        text: data.message || 'Terjadi kesalahan pada server.',
                        icon: 'error',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#dc2626'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Oops...',
                    text: 'Terjadi kesalahan pada koneksi.',
                    icon: 'error',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#dc2626'
                });
            });
        }

        // Form submission (backup)
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submit event triggered');
            submitForm();
        });

        // Initialize
        showSection(0);
    </script>
</body>
</html>
