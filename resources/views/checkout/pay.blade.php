@extends('layouts.app')

@section('title', 'Metode Pembayaran - Marinasi Lele')

@section('content')
<div class="container py-5 animate-fade-in">
    <div class="row g-4 justify-content-center">
        <!-- Rincian Pesanan -->
        <div class="col-lg-5 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                    <i class="fas fa-shopping-bag text-danger me-2"></i> Ringkasan Pesanan
                </h5>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Nomor Pesanan:</span>
                    <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Alamat Kirim:</span>
                    <span class="text-dark text-end small" style="max-width: 200px;">{{ $order->shipping_address }}</span>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-dark">Total Pembayaran:</span>
                    <span class="fw-black text-danger fs-4" style="font-weight: 900;">
                        Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Pilihan Metode Pembayaran -->
        <div class="col-lg-5 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="fas fa-credit-card text-danger me-2"></i> Pilih Metode Pembayaran
                </h5>

                <!-- Pilihan 1: QRIS -->
                <div class="payment-method-card p-3 mb-3 rounded-3 border active" onclick="selectMethod('qris')">
                    <div class="d-flex align-items-center">
                        <div class="payment-icon bg-danger-subtle text-danger rounded-circle p-3 me-3">
                            <i class="fas fa-qrcode fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">QRIS & E-Wallet</h6>
                            <p class="text-muted small mb-0">Bayar instan via GoPay, OVO, ShopeePay, Dana, dll.</p>
                        </div>
                        <div class="check-indicator text-success">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Pilihan 2: Transfer Bank -->
                <div class="payment-method-card p-3 mb-3 rounded-3 border" onclick="selectMethod('bank_transfer')">
                    <div class="d-flex align-items-center">
                        <div class="payment-icon bg-primary-subtle text-primary rounded-circle p-3 me-3">
                            <i class="fas fa-university fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">Transfer Bank / Virtual Account</h6>
                            <p class="text-muted small mb-0">Transfer via BCA, Mandiri, BNI, BRI, dll.</p>
                        </div>
                        <div class="check-indicator text-muted opacity-25">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Pilihan 3: COD -->
                <div class="payment-method-card p-3 mb-4 rounded-3 border" onclick="selectMethod('cod')">
                    <div class="d-flex align-items-center">
                        <div class="payment-icon bg-success-subtle text-success rounded-circle p-3 me-3">
                            <i class="fas fa-money-bill-wave fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">Bayar di Tempat (COD)</h6>
                            <p class="text-muted small mb-0">Bayar tunai saat kurir mengantarkan pesanan Anda.</p>
                        </div>
                        <div class="check-indicator text-muted opacity-25">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Formulir COD tersembunyi -->
                <form id="cod-form" action="{{ route('orders.mark_paid_cod', $order->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="d-grid gap-3">
                    <!-- Tombol Utama -->
                    <button type="button" id="pay-btn" class="btn btn-danger rounded-pill py-3 fw-bold shadow-sm" style="background-color: #A81C1C; border: none;" onclick="processPayment()">
                        <i class="fas fa-qrcode me-2"></i> Bayar Sekarang via QRIS
                    </button>

                    <!-- Tombol Demo Pembayaran Instan -->
                    <a href="/checkout/success-local/{{ $order->order_number }}" id="demo-btn" class="btn btn-outline-dark rounded-pill py-2.5 fw-semibold border-secondary-subtle">
                        <i class="fas fa-magic text-warning me-2 animate-pulse"></i> Simulasi Bayar Instan (Demo)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    let selectedMethod = 'qris';

    function selectMethod(method) {
        selectedMethod = method;
        
        // Perbarui class active
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('active');
        });
        
        const cards = document.querySelectorAll('.payment-method-card');
        let activeCard;
        if (method === 'qris') {
            activeCard = cards[0];
            document.getElementById('pay-btn').innerHTML = '<i class="fas fa-qrcode me-2"></i> Bayar Sekarang via QRIS';
            document.getElementById('pay-btn').style.backgroundColor = '#A81C1C';
            document.getElementById('demo-btn').style.display = 'block';
        } else if (method === 'bank_transfer') {
            activeCard = cards[1];
            document.getElementById('pay-btn').innerHTML = '<i class="fas fa-university me-2"></i> Bayar via Transfer Bank';
            document.getElementById('pay-btn').style.backgroundColor = '#007bff';
            document.getElementById('demo-btn').style.display = 'block';
        } else {
            activeCard = cards[2];
            document.getElementById('pay-btn').innerHTML = '<i class="fas fa-money-bill-wave me-2"></i> Gunakan COD (Bayar di Tempat)';
            document.getElementById('pay-btn').style.backgroundColor = '#198754';
            document.getElementById('demo-btn').style.display = 'none';
        }
        
        activeCard.classList.add('active');

        // Perbarui indikator centang
        document.querySelectorAll('.check-indicator').forEach(ind => {
            ind.classList.remove('text-success');
            ind.classList.add('text-muted', 'opacity-25');
        });
        const activeInd = activeCard.querySelector('.check-indicator');
        activeInd.classList.remove('text-muted', 'opacity-25');
        activeInd.classList.add('text-success');
    }

    function processPayment() {
        if (selectedMethod === 'cod') {
            if (confirm('Konfirmasi pemesanan dengan metode COD? Pembayaran dilakukan tunai kepada kurir.')) {
                document.getElementById('cod-form').submit();
            }
            return;
        }

        const payBtn = document.getElementById('pay-btn');
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menghubungi Midtrans...';
        payBtn.disabled = true;

        // Ambil snap token terfilter sesuai metode bayar yang dipilih
        fetch(`/orders/{{ $order->order_number }}/snap-token?method=${selectedMethod}`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.paid) {
                window.location.href = "/checkout/success-local/{{ $order->order_number }}";
                return;
            }
            
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses Lunas...';
                    window.location.href = "/checkout/success-local/{{ $order->order_number }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('orders.index') }}";
                },
                onError: function(result) {
                    alert("Pembayaran gagal.");
                    selectMethod(selectedMethod); // Reset tombol
                },
                onClose: function() {
                    alert("Jendela pembayaran ditutup.");
                    selectMethod(selectedMethod); // Reset tombol
                }
            });
        })
        .catch(err => {
            alert(err.error || 'Terjadi kesalahan saat memproses pembayaran.');
            selectMethod(selectedMethod); // Reset tombol
        });
    }
</script>
<style>
    .fw-black { font-weight: 900; }
    .payment-method-card {
        cursor: pointer;
        transition: all 0.25s ease;
        background-color: #ffffff;
        border-color: #e9ecef !important;
    }
    .payment-method-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border-color: #dee2e6 !important;
    }
    .payment-method-card.active {
        border-color: #A81C1C !important;
        background-color: rgba(168, 28, 28, 0.01);
    }
    .bg-danger-subtle { background-color: #fce8e6 !important; }
    .bg-primary-subtle { background-color: #e8f0fe !important; }
    .bg-success-subtle { background-color: #e6f4ea !important; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
    @keyframes pulse { 0% { opacity: 0.7; } 50% { opacity: 1; } 100% { opacity: 0.7; } }
    .animate-pulse { animation: pulse 2s infinite ease-in-out; }
</style>
@endpush
@endsection