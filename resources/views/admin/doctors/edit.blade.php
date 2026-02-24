@extends('layouts.admin')

@section('title', 'Edit Dokter - Admin Panel')
@section('header_title', 'Edit Data Dokter')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $doctor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Spesialisasi</label>
                            <input type="text" name="specialty"
                                class="form-control @error('specialty') is-invalid @enderror"
                                value="{{ old('specialty', $doctor->specialty) }}">
                            @error('specialty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Dokter</label>
                            @if ($doctor->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Current Photo" class="rounded"
                                        width="100">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                                accept="image/*">
                            <div class="form-text small">Biarkan kosong jika tidak ingin mengubah foto.</div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon (Opsional)</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $doctor->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenjang Pendidikan</label>
                            <input type="text" name="education_level"
                                class="form-control @error('education_level') is-invalid @enderror"
                                value="{{ old('education_level', $doctor->education_level) }}">
                            @error('education_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Riwayat Pendidikan</label>
                            <textarea name="education_history" class="form-control" rows="4">{{ old('education_history', $doctor->education_history) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pendidikan/Pelatihan Khusus</label>
                            <textarea name="special_training" class="form-control" rows="4">{{ old('special_training', $doctor->special_training) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kompetensi dan Keahlian Bidang</label>
                            <textarea name="competence" class="form-control" rows="4">{{ old('competence', $doctor->competence) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Penelitian dan Publikasi</label>
                            <textarea name="research_publications" class="form-control" rows="4">{{ old('research_publications', $doctor->research_publications) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Biografi Singkat</label>
                            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Jadwal Praktek</label>

                            <div id="schedule-wrapper">
                                @foreach ($doctor->schedules as $i => $schedule)
                                    @php
                                        $hoursRaw = $schedule->hours ?? '';
                                        $normalized = trim(str_ireplace('wib', '', $hoursRaw));
                                        $parts = array_map('trim', preg_split('/-/', $normalized));
                                        $startTime = str_replace('.', ':', $parts[0] ?? '');
                                        $endTime = str_replace('.', ':', $parts[1] ?? '');
                                    @endphp
                                    <div class="row align-items-center mb-2">
                                        <input type="hidden" name="schedule[{{ $i }}][id]"
                                            value="{{ $schedule->id }}">

                                        <div class="col-md-4">
                                            <select name="schedule[{{ $i }}][day]" class="form-select">
                                                <option value="">Pilih Hari</option>
                                                <option value="Senin" @selected($schedule->day === 'Senin')>Senin</option>
                                                <option value="Selasa" @selected($schedule->day === 'Selasa')>Selasa</option>
                                                <option value="Rabu" @selected($schedule->day === 'Rabu')>Rabu</option>
                                                <option value="Kamis" @selected($schedule->day === 'Kamis')>Kamis</option>
                                                <option value="Jumat" @selected($schedule->day === 'Jumat')>Jumat</option>
                                                <option value="Sabtu" @selected($schedule->day === 'Sabtu')>Sabtu</option>
                                                <option value="Minggu" @selected($schedule->day === 'Minggu')>Minggu</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="time" name="schedule[{{ $i }}][start]" class="form-control"
                                                step="900" value="{{ $startTime }}" onchange="updateScheduleHours(this)">
                                        </div>

                                        <div class="col-md-3">
                                            <input type="time" name="schedule[{{ $i }}][end]" class="form-control"
                                                step="900" value="{{ $endTime }}" onchange="updateScheduleHours(this)">
                                            <input type="hidden" name="schedule[{{ $i }}][hours]" class="schedule-hours"
                                                value="{{ $schedule->hours }}">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="this.parentElement.parentElement.remove()">
                                                ✕
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSchedule()">
                                + Tambah Jadwal
                            </button>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.doctors.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let scheduleIndex = {{ $doctor->schedules->count() }};
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
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <select name="schedule[${scheduleIndex}][day]" class="form-select">
                    ${dayOptions}
                </select>
            </div>
            <div class="col-md-3">
                <input type="time" name="schedule[${scheduleIndex}][start]" class="form-control" step="900" onchange="updateScheduleHours(this)">
            </div>
            <div class="col-md-3">
                <input type="time" name="schedule[${scheduleIndex}][end]" class="form-control" step="900" onchange="updateScheduleHours(this)">
                <input type="hidden" name="schedule[${scheduleIndex}][hours]" class="schedule-hours">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">✕</button>
            </div>
        </div>
    `);
                scheduleIndex++;
            }
        </script>
    @endpush

@endsection
