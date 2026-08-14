@extends('admin.layouts.master')

@section('title', 'Kullanıcı Düzenle — ' . $user->name)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Kullanıcı Düzenle: ' . $user->name,
    'subtitle' => 'Mevcut yönetici hesabının bilgilerini ve şifresini güncelleyin.',
    'icon' => 'fa-user-pen',
    'backUrl' => route('admin.users.index')
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-body-light">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">
                <i class="fa-solid fa-user-pen me-2 text-primary"></i>Kullanıcı Hesap Bilgileri
            </h6>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="admin-label-light">Ad Soyad *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control admin-input-light @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="admin-label-light">E-Posta Adresi *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control admin-input-light @error('email') is-invalid @enderror" required>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 border mb-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="fa-solid fa-key text-warning"></i>
                    <span class="fw-bold text-dark small">Şifre Değiştirme (İsteğe Bağlı)</span>
                </div>
                <p class="small text-muted mb-0">Mevcut şifreyi korumak istiyorsanız aşağıdaki alanları boş bırakınız.</p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="admin-label-light">Yeni Şifre</label>
                    <input type="password" name="password" class="form-control admin-input-light @error('password') is-invalid @enderror" placeholder="Değiştirmek istemiyorsanız boş bırakın">
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="admin-label-light">Yeni Şifre Tekrarı</label>
                    <input type="password" name="password_confirmation" class="form-control admin-input-light" placeholder="Yeni şifreyi tekrar giriniz">
                </div>
            </div>

            <div class="border-top pt-3 d-flex gap-2">
                <button type="submit" class="btn btn-enterprise-admin">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light border rounded-3">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
