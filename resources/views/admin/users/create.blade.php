@extends('admin.layouts.master')

@section('title', 'Yeni Kullanıcı Ekle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Yeni Kullanıcı Ekle',
    'subtitle' => 'Sisteme yeni bir yönetici veya yetkili hesabı tanımlayın.',
    'icon' => 'fa-user-plus',
    'backUrl' => route('admin.users.index')
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-body-light">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">
                <i class="fa-solid fa-user-plus me-2 text-primary"></i>Kullanıcı Hesap Bilgileri
            </h6>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="admin-label-light">Ad Soyad *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control admin-input-light @error('name') is-invalid @enderror" placeholder="Örn: Ahmet Yılmaz" required>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="admin-label-light">E-Posta Adresi *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control admin-input-light @error('email') is-invalid @enderror" placeholder="ahmet@ipekmuhendislik.com.tr" required>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="admin-label-light">Şifre *</label>
                    <input type="password" name="password" class="form-control admin-input-light @error('password') is-invalid @enderror" placeholder="En az 8 karakter" required>
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="admin-label-light">Şifre Tekrarı *</label>
                    <input type="password" name="password_confirmation" class="form-control admin-input-light" placeholder="Şifreyi tekrar giriniz" required>
                </div>
            </div>

            <div class="border-top pt-3 d-flex gap-2">
                <button type="submit" class="btn btn-enterprise-admin">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Kullanıcıyı Kaydet
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light border rounded-3">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
