// Simple QR Scanner Implementation
class QRScanner {
    constructor(video, canvas, resultCallback) {
        this.video = video;
        this.canvas = canvas;
        this.context = canvas.getContext('2d');
        this.resultCallback = resultCallback;
        this.scanning = false;
        this.stream = null;
        this.scanInterval = null;
    }

    async start() {
        try {
            console.log('Starting QR Scanner...');
            
            // Request camera access with fallback options
            const constraints = {
                video: {
                    facingMode: 'environment',
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                }
            };

            // Try back camera first, then front camera
            try {
                this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            } catch (error) {
                console.log('Back camera failed, trying front camera...');
                constraints.video.facingMode = 'user';
                this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            }

            // Set up video stream
            this.video.srcObject = this.stream;
            this.video.style.display = 'block';
            
            // Wait for video to load
            await this.video.play();
            
            // Set canvas dimensions
            this.canvas.width = this.video.videoWidth;
            this.canvas.height = this.video.videoHeight;
            
            this.scanning = true;
            this.startScanning();
            
            console.log('QR Scanner started successfully');
            return true;
            
        } catch (error) {
            console.error('QR Scanner failed:', error);
            this.resultCallback({
                success: false,
                error: this.getErrorMessage(error)
            });
            return false;
        }
    }

    stop() {
        console.log('Stopping QR Scanner...');
        
        this.scanning = false;
        
        // Stop scanning interval
        if (this.scanInterval) {
            clearInterval(this.scanInterval);
            this.scanInterval = null;
        }
        
        // Stop camera stream
        if (this.stream) {
            this.stream.getTracks().forEach(track => {
                track.stop();
            });
            this.stream = null;
        }
        
        // Hide video
        this.video.style.display = 'none';
        
        console.log('QR Scanner stopped');
    }

    startScanning() {
        this.scanInterval = setInterval(() => {
            if (this.scanning && this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
                this.scanFrame();
            }
        }, 300); // Scan every 300ms
    }

    scanFrame() {
        try {
            // Draw video frame to canvas
            this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
            
            // Get image data
            const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
            
            // Simple QR code detection simulation
            // In production, use a proper QR library
            const result = this.simulateQRDetection(imageData);
            
            if (result) {
                console.log('QR Code detected:', result);
                this.resultCallback({
                    success: true,
                    data: result
                });
                this.stop();
            }
            
        } catch (error) {
            console.error('Frame scan error:', error);
        }
    }

    simulateQRDetection(imageData) {
        // This is a simulation for demo purposes
        // In production, integrate with jsQR or similar library
        
        // For demo, we'll return a random ticket code after some scans
        const testCodes = ['TZQKKAIE', 'BJMQYCW6', 'NXD5RGQO', 'J519D2DE'];
        
        // Simulate detection after 3-5 seconds
        if (Math.random() < 0.05) { // 5% chance per scan
            return testCodes[Math.floor(Math.random() * testCodes.length)];
        }
        
        return null;
    }

    getErrorMessage(error) {
        if (error.name === 'NotAllowedError') {
            return 'Izin kamera ditolak. Silakan berikan izin kamera di browser Anda.';
        } else if (error.name === 'NotFoundError') {
            return 'Tidak ada kamera ditemukan. Pastikan perangkat memiliki kamera.';
        } else if (error.name === 'NotReadableError') {
            return 'Kamera sedang digunakan oleh aplikasi lain.';
        } else if (error.name === 'OverconstrainedError') {
            return 'Kamera tidak mendukung setting yang diminta.';
        } else {
            return 'Tidak dapat mengakses kamera: ' + error.message;
        }
    }

    isSupported() {
        // Check for various browser APIs
        return !!(navigator.mediaDevices && 
                 (navigator.mediaDevices.getUserMedia || 
                  navigator.mediaDevices.webkitGetUserMedia || 
                  navigator.mediaDevices.mozGetUserMedia ||
                  navigator.getUserMedia));
    }

    async checkCameraAvailability() {
        try {
            // Try to enumerate devices
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            return videoDevices.length > 0;
        } catch (error) {
            console.log('Cannot enumerate devices:', error);
            return false;
        }
    }
}

// Export for use in other scripts
if (typeof window !== 'undefined') {
    window.QRScanner = QRScanner;
    console.log('QR Scanner library loaded and exported');
} else {
    console.log('QR Scanner library loaded (no window object)');
}
