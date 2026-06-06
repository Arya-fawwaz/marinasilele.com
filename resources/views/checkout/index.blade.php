@extends('layouts.app')

@section('title', 'Checkout Pesanan - Marinasi Lele')

@section('content')
<div class="container py-5 mt-2 mb-5">
    
    <div class="d-flex align-items-center mb-4 animate-fade-in">
        <i class="fas fa-lock fa-2x text-success me-3"></i>
        <h2 class="fw-black text-dark mb-0" style="font-weight: 900;">Checkout <span style="color: #A81C1C;">Aman</span></h2>
    </div>

    <form action="{{ route('checkout.process') ?? '#' }}" method="POST" class="animate-fade-in" style="animation-delay: 0.1s;">
        @csrf
        
        <div class="row g-4">
            
            <div class="col-lg-7">
                
                <!-- Tipe Pengiriman -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 border">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-motorcycle text-danger me-2"></i> Tipe Pengiriman</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="shipping_type" id="ship_delivery" value="delivery" checked autocomplete="off">
                                <label class="btn btn-outline-danger w-100 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2" for="ship_delivery">
                                    <i class="fas fa-truck-moving fs-5"></i> Kirim ke Alamat
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="shipping_type" id="ship_takeaway" value="takeaway" autocomplete="off">
                                <label class="btn btn-outline-danger w-100 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2" for="ship_takeaway">
                                    <i class="fas fa-store fs-5"></i> Makan di Tempat / Ambil
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengiriman -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 border">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark" id="address_card_title"><i class="fas fa-truck text-primary me-2"></i> Informasi Pengiriman</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase" id="address_label" style="letter-spacing: 0.5px;">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" id="address_textarea" class="form-control bg-light border-light rounded-3 p-3 shadow-none focus-ring focus-ring-danger" rows="4" placeholder="Masukkan alamat lengkap pengiriman..." required></textarea>
                            <small class="text-danger mt-2 d-block fw-medium" id="address_warning">*Wajib diisi agar pesanan dapat dikirim.</small>
                        </div>

                        <!-- Map Section -->
                        <div id="delivery_map_section" class="mt-4">
                            <label class="form-label text-muted fw-bold small text-uppercase" style="letter-spacing: 0.5px;">Tentukan Titik Koordinat Pengiriman</label>
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold" onclick="locateUser()">
                                    <i class="fas fa-location-crosshairs me-1 text-danger"></i> Gunakan Lokasi Saya
                                </button>
                                <span id="map-status-text" class="small text-muted align-self-center"></span>
                            </div>
                            <div id="map" style="height: 320px; z-index: 1;" class="rounded-4 border shadow-sm mb-3"></div>
                            <div class="alert alert-info border-0 rounded-3 small p-3 mb-0 d-flex align-items-center">
                                <i class="fas fa-info-circle fs-5 me-3 text-info"></i>
                                <div>
                                    Klik pada peta atau geser marker untuk menentukan lokasi pengantaran Anda secara presisi.
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs for delivery coordinates and fees -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="distance" id="distance" value="0">
                        <input type="hidden" name="shipping_fee" id="shipping_fee" value="0">
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark text-uppercase" style="font-size: 0.9rem; letter-spacing: 1px;">Metode Pembayaran</h5>
                        
                        <div class="bg-warning bg-opacity-10 p-4 rounded-4 d-flex align-items-center border border-warning border-opacity-25 transition-all">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4 flex-shrink-0" style="width: 55px; height: 55px;">
                                <i class="fas fa-qrcode text-dark fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1 fs-5">QRIS / Bayar di Tempat (Cash)</h6>
                                <p class="text-muted small mb-0 lh-lg">Anda akan diarahkan ke halaman Barcode QRIS Midtrans setelah menekan tombol Buat Pesanan di samping.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-receipt text-danger me-2"></i> Ringkasan Belanja</h5>

                        <div class="mb-4">
                            @if(isset($carts) && $carts->count() > 0)
                                @foreach($carts as $cart)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                            <i class="fas fa-fish text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $cart->product->name ?? 'Produk Marinasi' }}</h6>
                                            <span class="text-muted" style="font-size: 0.8rem;">{{ $cart->quantity }} Porsi x Rp {{ number_format($cart->product->price ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-dark">
                                        Rp {{ number_format(($cart->product->price ?? 0) * $cart->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-basket fa-2x text-muted opacity-25 mb-2"></i>
                                    <p class="text-muted mb-0 small">Keranjang Anda masih kosong.</p>
                                </div>
                            @endif
                        </div>

                        <hr class="border-secondary opacity-10 my-4">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Total Harga Barang</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="shipping_fee_row">
                            <span class="text-muted fw-medium">Ongkos Kirim (<span id="display_distance">0</span> km)</span>
                            <span class="fw-bold text-dark" id="display_shipping_fee">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted fw-medium">Biaya Layanan</span>
                            <span class="fw-bold text-success">Gratis</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 mb-4 border border-light">
                            <span class="fw-bold text-dark text-uppercase" style="letter-spacing: 1px; font-size: 0.9rem;">Total Tagihan</span>
                            <span class="fw-black text-danger fs-3" id="display_total_amount" data-base-price="{{ $totalPrice ?? 0 }}">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn w-100 rounded-pill py-3 fw-bold shadow-sm text-white" style="background: linear-gradient(135deg, #A81C1C, #8B1515); font-size: 1.05rem;" {{ (!isset($carts) || $carts->count() == 0) ? 'disabled' : '' }}>
                            Buat Pesanan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="text-center mt-4">
                            <small class="text-success fw-bold"><i class="fas fa-shield-alt me-1"></i> Data Anda dilindungi dengan aman.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    textarea:focus {
        border-color: #A81C1C !important;
        box-shadow: 0 0 0 0.25rem rgba(168, 28, 28, 0.15) !important;
    }
    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(168, 28, 28, 0.2) !important;
        background: linear-gradient(135deg, #8B1515, #A81C1C) !important;
    }
    button[type="submit"]:disabled {
        background: #ccc !important;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }
    .btn-check:checked + label {
        background-color: #A81C1C !important;
        border-color: #A81C1C !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(168, 28, 28, 0.2);
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Koordinat Toko Marinasi Lele (Mega Kuningan, Jakarta)
    const STORE_LAT = -6.229728;
    const STORE_LNG = 106.829898;
    
    let map, marker, routeLine = null;
    let currentLat = null;
    let currentLng = null;
    let geocodeTimeout = null;

    document.addEventListener("DOMContentLoaded", function() {
        // Init Map
        map = L.map('map').setView([STORE_LAT, STORE_LNG], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Custom Icon untuk Toko (Merah) dan Driver (Kuning)
        const storeIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const customerIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Marker Toko
        L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon })
            .addTo(map)
            .bindPopup('<b>Warung Marinasi Lele (Pusat)</b>')
            .openPopup();

        // Marker Customer (Draggable)
        marker = L.marker([STORE_LAT - 0.005, STORE_LNG + 0.005], {
            draggable: true,
            icon: customerIcon
        }).addTo(map);

        // Update coordinates and calculate distance on drag/click
        updateLocation(marker.getLatLng().lat, marker.getLatLng().lng);

        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updateLocation(position.lat, position.lng, true);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateLocation(e.latlng.lat, e.latlng.lng, true);
        });

        // Listen for address textarea changes to automatically search on map (Forward Geocoding)
        const addressTextarea = document.getElementById('address_textarea');
        addressTextarea.addEventListener('input', function() {
            if (document.querySelector('input[name="shipping_type"]:checked').value !== 'delivery') return;
            clearTimeout(geocodeTimeout);
            const address = this.value.trim();
            if (address.length < 5) return;
            
            geocodeTimeout = setTimeout(() => {
                geocodeAddress(address);
            }, 1500); // 1.5s debounce to let user type
        });

        addressTextarea.addEventListener('change', function() {
            if (document.querySelector('input[name="shipping_type"]:checked').value !== 'delivery') return;
            clearTimeout(geocodeTimeout);
            const address = this.value.trim();
            if (address.length >= 5) {
                geocodeAddress(address);
            }
        });

        // Handle shipping type change
        document.querySelectorAll('input[name="shipping_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                toggleShippingType(this.value);
            });
        });
        
        // Initial call
        toggleShippingType('delivery');
    });

    function toggleShippingType(type) {
        const mapSection = document.getElementById('delivery_map_section');
        const addressLabel = document.getElementById('address_label');
        const addressTextarea = document.getElementById('address_textarea');
        const addressWarning = document.getElementById('address_warning');
        const addressCardTitle = document.getElementById('address_card_title');
        
        if (type === 'delivery') {
            mapSection.style.display = 'block';
            addressLabel.innerText = 'Alamat Lengkap Pengiriman';
            addressTextarea.placeholder = 'Masukkan alamat lengkap pengiriman...';
            addressWarning.innerText = '*Wajib diisi agar pesanan dapat dikirim.';
            addressCardTitle.innerHTML = '<i class="fas fa-truck text-primary me-2"></i> Informasi Pengiriman';
            
            // Recalculate distance
            if (currentLat && currentLng) {
                calculateShipping(currentLat, currentLng);
            }
        } else {
            mapSection.style.display = 'none';
            addressLabel.innerText = 'Nomor Meja / Keterangan Ambil';
            addressTextarea.placeholder = 'Contoh: Meja Nomor 5 / Ambil pukul 12:00 WIB';
            addressWarning.innerText = '*Wajib diisi untuk mempermudah penyajian/pengambilan.';
            addressCardTitle.innerHTML = '<i class="fas fa-store text-danger me-2"></i> Makan di Tempat / Ambil';
            
            if (routeLine) {
                map.removeLayer(routeLine);
                routeLine = null;
            }

            // Set shipping fee to 0
            updateShippingUI(0, 0);
        }
    }

    function locateUser() {
        const statusText = document.getElementById('map-status-text');
        if (!navigator.geolocation) {
            statusText.innerText = 'Geolocation tidak didukung browser Anda.';
            return;
        }

        statusText.innerText = 'Mencari lokasi Anda...';
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                statusText.innerText = 'Lokasi ditemukan!';
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                updateLocation(lat, lng, true);
            },
            function(error) {
                statusText.innerText = 'Gagal mendeteksi lokasi: ' + error.message;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function geocodeAddress(address) {
        const statusText = document.getElementById('map-status-text');
        statusText.innerHTML = '<span class="text-primary"><i class="fas fa-spinner fa-spin me-1"></i> Mencari lokasi alamat...</span>';
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(address)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    statusText.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i> Lokasi ditemukan dan diperbarui!</span>';
                    
                    // Move customer marker to the new coordinates
                    marker.setLatLng([lat, lng]);
                    
                    // Update coordinates and calculate distance & shipping (do NOT fetch address again to avoid loop)
                    updateLocation(lat, lng, false);
                } else {
                    statusText.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i> Lokasi alamat kurang spesifik/tidak ditemukan pada peta. Silakan geser pin manual.</span>';
                }
            })
            .catch(err => {
                statusText.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i> Gagal mencari lokasi alamat.</span>';
            });
    }

    function updateLocation(lat, lng, fetchAddress = false) {
        currentLat = lat;
        currentLng = lng;
        
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        calculateShipping(lat, lng);

        if (fetchAddress) {
            // Reverse Geocoding via Nominatim OpenStreetMap (Free, no API Key)
            const statusText = document.getElementById('map-status-text');
            const originalText = statusText.innerText;
            statusText.innerText = 'Mendapatkan alamat...';

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    statusText.innerText = originalText;
                    if (data && data.display_name) {
                        // Autofill address textarea
                        document.getElementById('address_textarea').value = data.display_name;
                    }
                })
                .catch(err => {
                    statusText.innerText = 'Gagal mengambil alamat.';
                });
        }
    }

    function calculateShipping(lat, lng) {
        const distance = getDistanceFromLatLonInKm(STORE_LAT, STORE_LNG, lat, lng);
        
        // Shipping rules:
        // Distance <= 2 km: Rp 5.000
        // Distance > 2 km: Rp 5.000 + Rp 3.000 per km berikutnya
        let shippingFee = 5000;
        if (distance > 2) {
            shippingFee += Math.ceil(distance - 2) * 3000;
        }

        updateShippingUI(distance, shippingFee);

        // Draw line & update map bounds if delivery
        if (document.querySelector('input[name="shipping_type"]:checked').value === 'delivery') {
            if (routeLine) {
                map.removeLayer(routeLine);
            }

            // Draw line connecting Store and Customer Marker
            routeLine = L.polyline([
                [STORE_LAT, STORE_LNG],
                [lat, lng]
            ], {
                color: '#A81C1C',
                weight: 3,
                opacity: 0.8,
                dashArray: '5, 10'
            }).addTo(map);

            // Fit map bounds to show both store and delivery location nicely
            const group = new L.featureGroup([
                L.marker([STORE_LAT, STORE_LNG]),
                L.marker([lat, lng])
            ]);
            map.fitBounds(group.getBounds().pad(0.25));
        }
    }

    function updateShippingUI(distance, shippingFee) {
        // Set inputs
        document.getElementById('distance').value = distance.toFixed(2);
        document.getElementById('shipping_fee').value = shippingFee;

        // Update display text
        document.getElementById('display_distance').innerText = distance.toFixed(1);
        document.getElementById('display_shipping_fee').innerText = shippingFee === 0 ? 'Rp 0' : 'Rp ' + formatRupiah(shippingFee);
        
        // Update total amount
        const basePrice = parseInt(document.getElementById('display_total_amount').getAttribute('data-base-price'));
        const totalAmount = basePrice + shippingFee;
        document.getElementById('display_total_amount').innerText = 'Rp ' + formatRupiah(totalAmount);
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth radius in km
        const dLat = deg2rad(lat2-lat1);
        const dLon = deg2rad(lon2-lon1); 
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        return R * c;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }
</script>
@endpush
@endsection