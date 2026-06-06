@extends('admin.layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Tambah Produk Baru</h2>
            <p class="text-muted mb-0">Lengkapi form di bawah ini untuk menambahkan produk.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg rounded-3" placeholder="Contoh: Lele Bumbu Kuning" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="5" placeholder="Jelaskan detail produk, bahan, dan cara penyajian..." required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-secondary">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number" name="price" class="form-control form-control-lg border-start-0" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-secondary">Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control form-control-lg" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-image me-2 text-danger"></i> Foto Produk</h5>
                        
                        <div class="image-preview-container mb-3 text-center position-relative">
                            <div class="preview-placeholder" id="previewPlaceholder">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted" style="transition: var(--transition);"></i>
                                <span class="fw-semibold small">Pilih gambar atau isi URL</span>
                            </div>
                            <img id="imagePreview" src="" class="img-fluid" alt="Preview">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Upload File Gambar</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted mt-1 d-block">Format: JPG, PNG, JPEG. Maks: 2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Atau URL Gambar (Hosting Vercel)</label>
                            <input type="text" name="image_url" id="imageUrlInput" class="form-control" placeholder="https://example.com/gambar.jpg" oninput="previewImageUrl(this.value)">
                            <small class="text-muted mt-1 d-block">Gunakan link eksternal jika mengunggah ke Vercel.</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-cog me-2 text-danger"></i> Pengaturan</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-select-lg rounded-3" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Status Visibilitas <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-lg rounded-3">
                                <option value="active">Aktif (Tampil di Toko)</option>
                                <option value="inactive">Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm py-3">
                            <i class="fas fa-save me-2"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .image-preview-container {
        position: relative;
        border: 2.5px dashed var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: #f8fafc;
        transition: var(--transition);
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-preview-container:hover {
        border-color: var(--primary);
        background: #fff;
    }
    .image-preview-container:hover .preview-placeholder i {
        color: var(--primary) !important;
        transform: translateY(-5px);
    }
    .preview-placeholder {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        pointer-events: none;
        transition: var(--transition);
        z-index: 1;
    }
    #imagePreview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 2;
        position: relative;
        opacity: 0;
        transition: var(--transition);
        border-radius: var(--radius-lg);
    }
    #imagePreview.has-image {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.classList.add('has-image');
            document.getElementById('previewPlaceholder').style.opacity = '0';
            document.getElementById('imageUrlInput').value = '';
        }
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function previewImageUrl(url) {
        var output = document.getElementById('imagePreview');
        if (url) {
            output.src = url;
            output.classList.add('has-image');
            document.getElementById('previewPlaceholder').style.opacity = '0';
            document.getElementById('imageInput').value = '';
        } else {
            output.src = '';
            output.classList.remove('has-image');
            document.getElementById('previewPlaceholder').style.opacity = '1';
        }
    }
</script>
@endpush