@extends('layouts.admin')

@section('title', 'Tambah Dokter - Admin Panel')
@section('header_title', 'Tambah Dokter Baru')

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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Contoh: dr. Budi Santoso, Sp.M" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Dokter</label>
                            
                            <div class="d-flex gap-2">
                                <input type="file" id="photo-file" name="photo" class="form-control @error('photo') is-invalid @enderror" 
                                    accept="image/*" placeholder="Upload gambar">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    Browse Media
                                </button>
                            </div>
                            
                            <input type="hidden" id="media_id" name="media_id" value="">
                            
                            <div class="form-text small mt-2">Format: JPG, PNG. Maks: 2MB. Disarankan rasio 1:1 atau portrait.</div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview selected media -->
                            <div id="photo-preview" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon (Opsional)</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="0812...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenjang Pendidikan</label>
                            <input type="text" name="education_level"
                                class="form-control @error('education_level') is-invalid @enderror"
                                value="{{ old('education_level') }}" placeholder="Contoh: S3 Kedokteran">
                            @error('education_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Riwayat Pendidikan</label>
                            <textarea name="education_history" class="form-control" rows="4" placeholder="Masukkan riwayat pendidikan...">{{ old('education_history') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pendidikan/Pelatihan Khusus</label>
                            <textarea name="special_training" class="form-control" rows="4" placeholder="Masukkan pelatihan khusus...">{{ old('special_training') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kompetensi dan Keahlian Bidang</label>
                            <textarea name="competence" class="form-control" rows="4" placeholder="Masukkan kompetensi...">{{ old('competence') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Penelitian dan Publikasi</label>
                            <textarea name="research_publications" class="form-control" rows="4" placeholder="Masukkan penelitian...">{{ old('research_publications') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Biografi Singkat</label>
                            <textarea name="bio" class="form-control" rows="4" placeholder="Deskripsi singkat tentang dokter...">{{ old('bio') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jadwal Praktek</label>

                            <div id="schedule-wrapper">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <select name="schedule[0][day]" class="form-select">
                                            <option value="">Pilih Hari</option>
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                            <option value="Minggu">Minggu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="schedule[0][start]" class="form-control"
                                            step="200" placeholder="Jam buka" onchange="updateScheduleHours(this)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="schedule[0][end]" class="form-control"
                                            step="900" placeholder="Jam tutup" onchange="updateScheduleHours(this)">
                                        <input type="hidden" name="schedule[0][hours]" class="schedule-hours">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSchedule()">
                                + Tambah Jadwal
                            </button>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.doctors.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Dokter</button>
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

        @if($mediaItems->count())
        <div class="row g-3">
            @foreach($mediaItems as $media)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="media-card border rounded p-1"
                     data-id="{{ $media->id }}"
                     data-path="{{ asset('storage/'.$media->filepath) }}">

                    <img src="{{ asset('storage/'.$media->filepath) }}"
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>

        <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>
            Gunakan Gambar Ini
        </button>
    </div>

</div>
</div>
</div>
@endsection

@section('scripts')
    <script>
        let scheduleIndex = 1;

        const dayOptions = `
            <option value="">Pilih Hari</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
            <option value="Minggu">Minggu</option>
        `;

        function updateScheduleHours(el) {
            const row = el.closest('.row');
            if (!row) return;
            const start = row.querySelector('input[name*="[start]"]')?.value || '';
            const end = row.querySelector('input[name*="[end]"]')?.value || '';
            const hoursField = row.querySelector('.schedule-hours');

            if (!hoursField) return;
            hoursField.value = start && end ? `${start} - ${end}` : '';
        }

        function addSchedule() {
            document.getElementById('schedule-wrapper').insertAdjacentHTML('beforeend', `
        <div class="row mb-2">
            <div class="col-md-4">
                <select name="schedule[${scheduleIndex}][day]" class="form-select">
                    ${dayOptions}
                </select>
            </div>
            <div class="col-md-3">
                <input type="time" name="schedule[${scheduleIndex}][start]" class="form-control" step="900" placeholder="Jam buka" onchange="updateScheduleHours(this)">
            </div>
            <div class="col-md-3">
                <input type="time" name="schedule[${scheduleIndex}][end]" class="form-control" step="900" placeholder="Jam tutup" onchange="updateScheduleHours(this)">
                <input type="hidden" name="schedule[${scheduleIndex}][hours]" class="schedule-hours">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">✕</button>
            </div>
        </div>
    `);
            scheduleIndex++;
        }

        document.addEventListener('DOMContentLoaded', function(){

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

            document.getElementById('selectMediaBtn')
            .addEventListener('click', function(){

                document.getElementById('media_id').value = selectedId;

                if(selectedPath){
                    const previewWrapper = document.getElementById('photo-preview');
                    previewWrapper.innerHTML = `<img src="${selectedPath}" class="img-fluid rounded mt-2" style="max-height:200px;">`;
                }

                let modal = bootstrap.Modal.getInstance(
                    document.getElementById('mediaModal')
                );
                modal.hide();
            });

            // Preview upload manual
            document.getElementById('photo-file')
            .addEventListener('change', function(e){

                if(e.target.files[0]){
                    let reader = new FileReader();
                    reader.onload = function(e){
                        const previewWrapper = document.getElementById('photo-preview');
                        previewWrapper.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded mt-2" style="max-height:200px;">`;
                    }
                    reader.readAsDataURL(e.target.files[0]);

                    document.getElementById('media_id').value = '';
                }
            });
        });
    </script>
@endsection
