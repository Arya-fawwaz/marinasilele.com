@extends('admin.layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Produk</h2>
            <p class="text-muted mb-0">Perbarui informasi produk: <strong>{{ $product->name }}</strong></p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Batal
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control form-control-lg rounded-3" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="5" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-secondary">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number" name="price" value="{{ $product->price }}" class="form-control form-control-lg border-start-0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-secondary">Update Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control form-control-lg" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-image me-2"></i> Foto Produk</h5>
                        
                        <div class="text-center mb-3">
                            <img id="imagePreview" src="{{ $product->image_url }}" class="img-fluid rounded-3 object-fit-cover shadow-sm" style="height: 250px; width: 100%;" alt="Preview">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Upload File Gambar Baru</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <small class="text-warning mt-1 d-block"><i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah gambar.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Atau URL Gambar Baru (Hosting Vercel)</label>
                            <input type="text" name="image_url" id="imageUrlInput" class="form-control" placeholder="https://example.com/gambar.jpg" value="{{ (isset($product->image) && (str_starts_with($product->image, 'http://') || str_starts_with($product->image, 'https://'))) ? $product->image : '' }}" oninput="previewImageUrl(this.value)">
                            <small class="text-muted mt-1 d-block">Gunakan link eksternal jika mengunggah ke Vercel.</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-cog me-2"></i> Pengaturan</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-select-lg rounded-3" required>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ $product->category_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Status Visibilitas <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-lg rounded-3">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif (Tampil di Toko)</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-warning btn-lg w-100 rounded-pill fw-bold shadow-sm text-dark">
                            <i class="fas fa-sync-alt me-2"></i> Update Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
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
            document.getElementById('imageInput').value = '';
        } else {
            output.src = '{{ $product->image_url }}';
        }
    }
</script>
@endpush
@endsection