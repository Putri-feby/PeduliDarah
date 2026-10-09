@extends('layouts.app')

@section('title', 'Scan Tiket')

@section('content')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Scan Tiket Pendonor</h1>
                    <p class="mt-2 text-gray-600">Verifikasi tiket donor darah dengan memasukkan kode tiket</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.tickets.history') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat Scan
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-day text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Hari Ini</p>
                        <p class="text-2xl font-semibold text-gray-900" id="stat-today">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-week text-green-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Minggu Ini</p>
                        <p class="text-2xl font-semibold text-gray-900" id="stat-week">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-yellow-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Bulan Ini</p>
                        <p class="text-2xl font-semibold text-gray-900" id="stat-month">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-red-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-semibold text-gray-900" id="stat-total">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scan Options -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-qrcode mr-2 text-red-600"></i>
                Scan Kode Tiket
            </h2>
            
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button type="button" 
                            id="qrScanTab" 
                            class="tab-button active py-2 px-1 border-b-2 border-red-500 font-medium text-sm text-red-600">
                        <i class="fas fa-camera mr-2"></i>
                        QR Scanner
                    </button>
                    <button type="button" 
                            id="manualTab" 
                            class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-keyboard mr-2"></i>
                        Manual Input
                    </button>
                </nav>
            </div>

            <!-- QR Scanner Tab -->
            <div id="qrScanContent" class="tab-content">
                <div class="space-y-6">
                    <div class="text-center">
                        <div id="qrScanner" class="relative mx-auto" style="max-width: 400px;">
                            <div id="qr-reader" class="w-full rounded-lg overflow-hidden" style="display: none;"></div>
                            <div id="qrScannerPlaceholder" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-600 mb-4">Klik "Start Scanner" untuk memulai</p>
                                    <button type="button" 
                                            id="startScannerBtn"
                                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                        <i class="fas fa-play mr-2"></i>
                                        Start Scanner
                                    </button>
                                </div>
                            </div>
                            <div id="qrScannerActive" class="hidden">
                                <div class="mt-4 text-center">
                                    <button type="button" 
                                            id="stopScannerBtn"
                                            class="px-4 py-2 bg-red-600 text-white font-medium rounded hover:bg-red-700 transition-colors">
                                        <i class="fas fa-stop mr-1"></i>
                                        Stop Scanner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">
                                Arahkan kamera ke QR code pada tiket pendonor
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Input Tab -->
            <div id="manualContent" class="tab-content hidden">
                <form id="manualForm" class="space-y-6">
                    <div>
                        <label for="manual_ticket_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Tiket
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="manual_ticket_code" 
                                   name="ticket_code" 
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 text-lg"
                                   placeholder="Masukkan kode tiket (contoh: 4F72547D)"
                                   autocomplete="off"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" id="clearManualBtn" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Masukkan kode tiket tanpa prefix "TICKET-". Contoh: 4F72547D
                        </p>
                        <div class="mt-2 p-2 bg-blue-50 rounded text-sm text-blue-700">
                            <strong>Test Code:</strong> 4F72547D (untuk testing)
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" 
                                id="manualVerifyBtn"
                                class="px-8 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Verifikasi Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Result Display -->
        <div id="resultContainer" class="hidden">
            <!-- Results will be inserted here -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab elements
    const qrScanTab = document.getElementById('qrScanTab');
    const manualTab = document.getElementById('manualTab');
    const qrScanContent = document.getElementById('qrScanContent');
    const manualContent = document.getElementById('manualContent');
    
    // Manual form elements
    const manualForm = document.getElementById('manualForm');
    const manualTicketCodeInput = document.getElementById('manual_ticket_code');
    const manualVerifyBtn = document.getElementById('manualVerifyBtn');
    const clearManualBtn = document.getElementById('clearManualBtn');
    
    // QR scanner elements
    const startScannerBtn = document.getElementById('startScannerBtn');
    const stopScannerBtn = document.getElementById('stopScannerBtn');
    const qrReaderElement = document.getElementById('qr-reader');
    
    // QR Scanner variables
    let html5QrCode = null;
    let scannerActive = false;

    // Load statistics
    loadStats();

    // Tab switching
    qrScanTab.addEventListener('click', function() {
        switchTab('qr');
    });

    manualTab.addEventListener('click', function() {
        switchTab('manual');
    });

    function switchTab(tab) {
        // Reset tab styles
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-red-500', 'text-red-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Activate selected tab
        if (tab === 'qr') {
            qrScanTab.classList.add('active', 'border-red-500', 'text-red-600');
            qrScanTab.classList.remove('border-transparent', 'text-gray-500');
            qrScanContent.classList.remove('hidden');
        } else {
            manualTab.classList.add('active', 'border-red-500', 'text-red-600');
            manualTab.classList.remove('border-transparent', 'text-gray-500');
            manualContent.classList.remove('hidden');
            manualTicketCodeInput.focus();
        }
    }

    // QR Scanner controls
    startScannerBtn.addEventListener('click', startQRScanner);
    stopScannerBtn.addEventListener('click', stopQRScanner);

    function startQRScanner() {
        console.log('Initializing QR Scanner...');
        startScannerBtn.disabled = true;
        startScannerBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memulai...';
        
        qrReaderElement.style.display = 'block';
        qrScannerPlaceholder.classList.add('hidden');
        qrScannerActive.classList.remove('hidden');
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText, decodedResult) => {
                // Handle on success condition with the decoded text or result.
                console.log(`Scan result: ${decodedText}`, decodedResult);
                
                // Pause scanning to prevent multiple scans
                stopQRScanner();
                
                // Extract TICKET-XXXXXXX pattern if it's a URL
                let ticketCode = decodedText;
                const match = decodedText.match(/TICKET-[A-Z0-9]+/i);
                if (match) {
                    ticketCode = match[0];
                }
                
                verifyTicket(ticketCode);
            },
            (errorMessage) => {
                // Parse errors can be ignored
            }
        ).then(() => {
            scannerActive = true;
            startScannerBtn.disabled = false;
            startScannerBtn.innerHTML = '<i class="fas fa-play mr-2"></i>Start Scanner';
            console.log('QR Scanner started successfully');
        }).catch((err) => {
            console.error('QR Scanner error:', err);
            showCameraError("Gagal memulai kamera. Pastikan izin kamera telah diberikan.");
            startScannerBtn.disabled = false;
            startScannerBtn.innerHTML = '<i class="fas fa-play mr-2"></i>Start Scanner';
            qrReaderElement.style.display = 'none';
        });
    }

    function stopQRScanner() {
        if (html5QrCode && scannerActive) {
            html5QrCode.stop().then((ignore) => {
                console.log('QR Scanner stopped');
                html5QrCode.clear();
                scannerActive = false;
                qrReaderElement.style.display = 'none';
                qrScannerPlaceholder.classList.remove('hidden');
                qrScannerActive.classList.add('hidden');
            }).catch((err) => {
                console.error("Failed to stop scanner", err);
            });
        }
    }

    function showCameraError(message) {
        // Show error in scanner area
        qrScannerPlaceholder.innerHTML = `
            <div class="text-center p-6">
                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                <p class="text-gray-700 mb-4">${message}</p>
                <button type="button" 
                        onclick="switchTab('manual')"
                        class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700">
                    <i class="fas fa-keyboard mr-2"></i>
                    Gunakan Manual Input
                </button>
            </div>
        `;
        
        // Hide active scanner
        qrScannerActive.classList.add('hidden');
    }

    // Manual input controls
    clearManualBtn.addEventListener('click', function() {
        manualTicketCodeInput.value = '';
        manualTicketCodeInput.focus();
        hideResult();
    });

    manualForm.addEventListener('submit', function(e) {
        e.preventDefault();
        verifyTicketManual();
    });

    manualTicketCodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            verifyTicketManual();
        }
    });

    function verifyTicketManual() {
        const ticketCode = manualTicketCodeInput.value.trim();
        
        if (!ticketCode) {
            showError('Silakan masukkan kode tiket');
            return;
        }

        verifyTicket(ticketCode);
    }

    function verifyTicket(ticketCode) {
        setLoading(true);
        hideResult();

        fetch('{{ route('admin.tickets.verify') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ticket_code: ticketCode
            })
        })
        .then(response => response.json())
        .then(data => {
            setLoading(false);
            
            if (data.success) {
                showSuccess(data);
                loadStats(); // Refresh statistics
                
                // Clear manual input if in manual tab
                if (!manualContent.classList.contains('hidden')) {
                    manualTicketCodeInput.value = '';
                    manualTicketCodeInput.focus();
                }
                
                // Stop scanner if in QR tab
                if (scannerActive) {
                    stopQRScanner();
                }
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            setLoading(false);
            showError('Terjadi kesalahan. Silakan coba lagi.');
            console.error('Error:', error);
        });
    }

    function showSuccess(data) {
        const ticket = data.ticket;
        
        resultContainer.innerHTML = `
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                    <h3 class="text-lg font-semibold text-green-800">${data.message}</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kode Tiket</p>
                            <p class="text-lg font-semibold text-gray-900">${ticket.code}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pendonor</p>
                            <p class="text-lg font-semibold text-gray-900">${ticket.user_name}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-gray-900">${ticket.user_email}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Antrian</p>
                            <p class="text-lg font-semibold text-gray-900">${ticket.queue_number}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Acara</p>
                            <p class="text-lg font-semibold text-gray-900">${ticket.event_title}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lokasi</p>
                            <p class="text-gray-900">${ticket.event_location}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal</p>
                            <p class="text-gray-900">${ticket.event_date}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Waktu</p>
                            <p class="text-gray-900">${ticket.event_time}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-green-200">
                    <p class="text-sm text-green-700">
                        <i class="fas fa-clock mr-1"></i>
                        Terverifikasi pada: ${ticket.scanned_at}
                    </p>
                </div>
            </div>
        `;
        
        resultContainer.classList.remove('hidden');
        resultContainer.scrollIntoView({ behavior: 'smooth' });
    }

    function showError(message) {
        resultContainer.innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800">Verifikasi Gagal</h3>
                        <p class="text-red-700 mt-1">${message}</p>
                    </div>
                </div>
            </div>
        `;
        
        resultContainer.classList.remove('hidden');
        resultContainer.scrollIntoView({ behavior: 'smooth' });
    }

    function hideResult() {
        resultContainer.classList.add('hidden');
    }

    function setLoading(loading) {
        if (loading) {
            manualVerifyBtn.disabled = true;
            manualVerifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...';
        } else {
            manualVerifyBtn.disabled = false;
            manualVerifyBtn.innerHTML = '<i class="fas fa-search mr-2"></i>Verifikasi Tiket';
        }
    }

    function loadStats() {
        fetch('{{ route('admin.tickets.stats') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('stat-today').textContent = data.today;
                document.getElementById('stat-week').textContent = data.this_week;
                document.getElementById('stat-month').textContent = data.this_month;
                document.getElementById('stat-total').textContent = data.total;
            })
            .catch(error => console.error('Error loading stats:', error));
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (html5QrCode && scannerActive) {
            html5QrCode.stop().catch(err => console.error(err));
        }
    });

    // Cleanup on tab change
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && scannerActive) {
            stopQRScanner();
        }
    });
});
</script>
@endsection
