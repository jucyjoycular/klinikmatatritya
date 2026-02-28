@extends('layouts.admin')

@section('title', 'Pengaturan Umum - Klinik Mata Tritya')

@section('header_title', 'Pengaturan Umum')

<style>
    .media-card{
        cursor:pointer;
        transition:0.2s;
    }
    .media-card:hover{
        transform:scale(1.05);
    }
    .media-card.selected{
        border:3px solid #0d6efd !important;
    }
    .modal-body{
        max-height:70vh;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-primary mb-0">Konfigurasi Website</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update-general') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <h6 class="fw-bold text-primary mb-3">Mode Perbaikan</h6>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Status Mode Perbaikan</label>
                                <div class="form-check form-switch d-flex align-items-center ms-1 gap-3 px-0">
                                    <input class="form-check-input ms-0" type="checkbox" role="switch"
                                        id="maintenance_mode" name="maintenance_mode" style="width: 3em; height: 1.5em;"
                                        {{ $maintenance_mode === 'true' ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="maintenance_mode">
                                        Aktifkan untuk menutup akses publik sementara
                                    </label>
                                </div>
                                <div class="form-text text-muted small mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Jika diaktifkan, pengunjung akan melihat halaman "Sedang Renovasi". Admin tetap dapat
                                    mengakses panel ini.
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">Pengaturan Jenis Font</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih Font Website</label>
                                    <select class="form-select" name="website_font" id="website_font">
                                        <!-- System Fonts -->
                                        <optgroup label="System Fonts">
                                            @foreach ($systemfonts as $font)
                                                <option value="{{ $font }}" {{ $website_font === $font ? 'selected' : '' }}>
                                                    {{ $font }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        <!-- Google Fonts -->
                                        <optgroup label="Google Fonts">
                                            @foreach ($googlefonts as $font)
                                                <option value="{{ $font }}" {{ $website_font === $font ? 'selected' : '' }}>
                                                    {{ $font }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>

                                    <div class="form-text text-muted small mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Font yang anda pilih akan diterapkan ke seluruh website. 
                                        Pastikan untuk memilih font yang mudah dibaca dan sesuai dengan identitas klinik.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-2">Preview Font</label>
                                <div
                                    class="border rounded p-4 bg-light"
                                    id="font-preview-box"
                                    style="min-height: 120px; display: flex; align-items: center; font-family: '{{ $website_font }}', sans-serif;">
                                    <p class="mb-0 fs-5" id="font-preview-text">
                                        Lihat dunia dengan lebih jelas bersama Klinik Mata Tritya. Kami hadir untuk memberikan perawatan mata terbaik dengan sentuhan profesionalisme dan kehangatan.
                                    </p>
                                </div> 
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-bold text-primary mb-3">Informasi Perusahaan</h6>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tentang Kami (About Us)</label>
                            <textarea class="form-control" name="about_us" rows="6">{{ old('about_us', $about_us) }}</textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Visi</label>
                                <textarea class="form-control" name="vision" rows="4">{{ old('vision', $vision) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Misi</label>
                                <textarea class="form-control" name="mission" rows="4">{{ old('mission', $mission) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Motto</label>
                                <textarea class="form-control" name="motto" rows="4">{{ old('motto', $motto) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">Informasi Kantor</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Kantor (Google Maps)</label>
                                    <input type="text" class="form-control" name="office_name" id="office_name"
                                        value="{{ old('office_name', $office_name) }}">
                                    <div class="form-text">Nama ini akan digunakan untuk pencarian di Google Maps Preview.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" name="office_address" rows="3">{{ old('office_address', $office_address) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon Kantor</label>
                                    <input type="text" class="form-control" name="office_phone"
                                        value="{{ old('office_phone', $office_phone) }}" placeholder="Contoh: 021-123456">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" name="office_wa"
                                        value="{{ old('office_wa', $office_wa) }}" placeholder="Contoh: 08123456789">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Kantor</label>
                                    <input type="email" class="form-control" name="office_email"
                                        value="{{ old('office_email', $office_email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-2">Preview Lokasi</label>
                                <div class="ratio ratio-1x1 overflow-hidden rounded border" style="max-height: 400px;">
                                    <iframe id="map-preview" frameborder="0" style="border:0"
                                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB2NIWI3Tv9iDPrlnowr_0ZqZWoAQydKJU&q={{ urlencode($office_name) }}"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">Gambar Anatomi Mata (Front)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Upload Gambar Baru</label>
                                    <input type="file" 
                                           class="form-control" 
                                           name="eye_anatomy_image" 
                                           id="eye_anatomy_image"
                                           accept="image/*">
                                    <div class="mb-2"></div>
                                    <button type="button" 
                                            class="btn btn-outline-primary" 
                                            id="browseAnatomyBtn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#mediaModal">
                                        Browse Media
                                    </button>
                                    <input type="hidden" name="eye_anatomy_media_id" id="eye_anatomy_media_id" value="{{ old('eye_anatomy_media_id') }}">
                                    <div class="form-text">Format: JPG, PNG, GIF. Max: 2MB.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-2">Preview Gambar Saat Ini</label>
                                <div
                                    class="ratio ratio-16x9 bg-light d-flex align-items-center justify-content-center overflow-hidden rounded border">
                                    @if (isset($eye_anatomy_image) && $eye_anatomy_image)
                                        <img src="{{ Storage::url($eye_anatomy_image) }}" 
                                             id="anatomyPreview"
                                             class="img-fluid"
                                             style="object-fit: contain; max-height: 100%;">
                                    @else
                                        <img src="{{ asset('img/anatomi-mata.png') }}" 
                                             id="anatomyPreview"
                                             class="img-fluid"
                                             style="object-fit: contain; max-height: 100%; opacity: 0.5;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Link Booking Online (Navbar)</h6>
                            <div class="mb-3">
                                <label class="form-label">URL Booking</label>
                                <input type="url" class="form-control" name="booking_link"
                                    value="{{ old('booking_link', $booking_link) }}"
                                    placeholder="Contoh: http://tritya.id/DaftarOnline">
                                <div class="form-text">Masukkan URL lengkap (termasuk http:// atau https://). Kosongkan
                                    untuk menggunakan default.</div>
                            </div>
                        </div>

                        <hr>
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Tautan Media Sosial (Footer)</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fab fa-facebook"></i> Facebook
                                        </label>
                                        <input type="url" class="form-control" name="facebook"
                                            value="{{ old('facebook', $facebook) }}"
                                            placeholder="Contoh: https://facebook.com/nama">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fab fa-instagram"></i> Instagram
                                        </label>
                                        <input type="url" class="form-control" name="instagram"
                                            value="{{ old('instagram', $instagram) }}"
                                            placeholder="Contoh: https://instagram.com/nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fab fa-youtube"></i> YouTube
                                        </label>
                                        <input type="url" class="form-control" name="youtube"
                                            value="{{ old('youtube', $youtube) }}"
                                            placeholder="Contoh: https://youtube.com/@nama">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fab fa-tiktok"></i> TikTok
                                        </label>
                                        <input type="url" class="form-control" name="tiktok"
                                            value="{{ old('tiktok', $tiktok) }}"
                                            placeholder="Contoh: https://tiktok.com/@nama">
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Masukkan URL lengkap media sosial yang akan ditampilkan di footer website.
                            </div>
                        </div>

                        <hr>
                        <div class="row align-items-start mb-4">
                            <h6 class="fw-bold text-primary mb-3">Menu "Biarkan Kami Membantu Anda"</h6>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Opsi Peran (Saya seorang...)</label>
                                    <textarea class="form-control" name="help_menu_roles" rows="5" placeholder="Pasien&#10;Keluarga Pasien">{{ old('help_menu_roles', $help_menu_roles) }}</textarea>
                                    <div class="form-text">Masukkan opsi satu per baris.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Opsi Kebutuhan (sedang mencari...)</label>
                                    <textarea class="form-control" name="help_menu_needs" rows="5" placeholder="Dokter&#10;Layanan&#10;Jadwal">{{ old('help_menu_needs', $help_menu_needs) }}</textarea>
                                    <div class="form-text">Masukkan opsi satu per baris.</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-start">
                            <button type="submit" class="btn btn-primary fw-semibold px-4 py-2">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="mediaModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title">Media Library</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        @if($media->count())
        <div class="row g-3">
            @foreach($media as $item)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="media-card border rounded p-1"
                     data-id="{{ $item->id }}"
                     data-path="{{ asset('storage/'.$item->filepath) }}">

                    <img src="{{ asset('storage/'.$item->filepath) }}"
                         class="img-fluid rounded"
                         style="height:120px; width:100%; object-fit:cover;">
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="text-center text-muted">
                Belum ada media tersedia.
            </div>
        @endif

    </div>

    <div class="modal-footer">
        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">
            Cancel
        </button>

        <button type="button"
                class="btn btn-primary"
                id="selectMediaBtn"
                disabled>
            Gunakan Gambar Ini
        </button>
    </div>

</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // === Google Maps Preview ===
    const officeNameInput = document.getElementById('office_name');
    const mapPreview = document.getElementById('map-preview');
    const apiKey = 'AIzaSyB2NIWI3Tv9iDPrlnowr_0ZqZWoAQydKJU';

    let timeout = null;

    if (officeNameInput) {
        officeNameInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                const query = encodeURIComponent(officeNameInput.value);
                mapPreview.src =
                    `https://www.google.com/maps/embed/v1/place?key=${apiKey}&q=${query}`;
            }, 1000);
        });
    }

    // === Font Preview ===
    const fontSelect = document.getElementById('website_font');
    const previewBox = document.getElementById('font-preview-box');

    fontSelect.addEventListener('change', function() {
        previewBox.style.fontFamily = `'${this.value}', sans-serif`;
    });

    // === Media Browser for Eye Anatomy ===
    let selectedId = null;
    let selectedPath = null;

    document.querySelectorAll('.media-card').forEach(card => {
        card.addEventListener('click', function(){
            document.querySelectorAll('.media-card')
                .forEach(c => c.classList.remove('selected'));

            this.classList.add('selected');

            selectedId = this.dataset.id;
            selectedPath = this.dataset.path;

            document.getElementById('selectMediaBtn').disabled = false;
        });
    });

    document.getElementById('selectMediaBtn').addEventListener('click', function(){
        document.getElementById('eye_anatomy_media_id').value = selectedId;

        if(selectedPath){
            const previewImg = document.getElementById('anatomyPreview');
            if(previewImg) {
                previewImg.src = selectedPath;
                previewImg.style.opacity = '1';
            }
        }

        // Reset file upload karena pakai media library
        document.getElementById('eye_anatomy_image').value = '';

        let modal = bootstrap.Modal.getInstance(
            document.getElementById('mediaModal')
        );
        modal.hide();
    });

    const browseBtn = document.getElementById('browseAnatomyBtn');
    if(browseBtn) {
        browseBtn.addEventListener('click', function(){
            // Reset file input saat buka modal
            document.getElementById('eye_anatomy_image').value = '';
        });
    }

    // Preview upload manual
    const anatomyInput = document.getElementById('eye_anatomy_image');
    if(anatomyInput) {
        anatomyInput.addEventListener('change', function(e){
            if(e.target.files[0]){
                let reader = new FileReader();
                reader.onload = function(evt){
                    const previewImg = document.getElementById('anatomyPreview');
                    if(previewImg) {
                        previewImg.src = evt.target.result;
                        previewImg.style.opacity = '1';
                    }
                }
                reader.readAsDataURL(e.target.files[0]);

                // Reset media_id karena pakai upload manual
                document.getElementById('eye_anatomy_media_id').value = '';
            }
        });
    }

});
</script>
@endsection