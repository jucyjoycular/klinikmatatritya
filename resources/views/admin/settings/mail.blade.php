@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-envelope me-2"></i> Mail Configuration</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.settings.update-mail') }}" method="POST">
                    @csrf
                    
                    <h6 class="text-muted mb-3 text-uppercase small fw-bold">SMTP Server Settings</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Mail Driver</label>
                            <input type="text" class="form-control bg-light" name="mail_driver" value="{{ $mail['mail_driver'] ?? 'smtp' }}" readonly>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Mail Host</label>
                            <input type="text" class="form-control" name="mail_host" value="{{ $mail['mail_host'] ?? 'smtp.gmail.com' }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Mail Port</label>
                            <input type="text" class="form-control" name="mail_port" value="{{ $mail['mail_port'] ?? '587' }}" placeholder="587">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Mail Username (Email)</label>
                            <input type="email" class="form-control" name="mail_username" value="{{ $mail['mail_username'] ?? '' }}" placeholder="email@gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mail Password (App Password)</label>
                            <input type="password" class="form-control" name="mail_password" value="{{ $mail['mail_password'] ?? '' }}" placeholder="App Password">
                            <div class="form-text">Use 16-digit App Password for Gmail.</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Encryption</label>
                            <select class="form-select" name="mail_encryption">
                                <option value="tls" {{ ($mail['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($mail['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ ($mail['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-muted mb-3 text-uppercase small fw-bold">Sender Identity</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">From Address</label>
                            <input type="email" class="form-control" name="mail_from_address" value="{{ $mail['mail_from_address'] ?? '' }}" placeholder="no-reply@kmt.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Name</label>
                            <input type="text" class="form-control" name="mail_from_name" value="{{ $mail['mail_from_name'] ?? 'Klinik Mata Tritya' }}" placeholder="Klinik Mata Tritya">
                        </div>
                    </div>
                    @can('update.mail')
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i> Save Settings</button>
                    </div>    
                    @endcan
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm">
             <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark"><i class="fas fa-info-circle me-2"></i> Instructions</h5>
            </div>
             <div class="card-body p-4">
                <h6 class="fw-bold text-primary">How to get Gmail App Password</h6>
                <ol class="ps-3 mb-0 small text-secondary">
                    <li class="mb-2">Go directly to the <a href="https://myaccount.google.com/apppasswords" target="_blank">App passwords page</a>.</li>
                    <li class="mb-2">If prompted, sign in to your Google Account.</li>
                    <li class="mb-2">Enter a name based on where you'll use it (e.g., "KMT Website").</li>
                    <li>Copy the generated 16-character code and paste it into the "Mail Password" field on the left.</li>
                </ol>
             </div>
        </div>
    </div>
</div>
@endsection
