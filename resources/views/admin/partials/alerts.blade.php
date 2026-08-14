{{--
    Admin Form Validation Alert Partial
    Note: Flash success & error notifications are automatically handled via SweetAlert2 Toast in master layout.
    Usage: @include('admin.partials.alerts')
--}}

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="fa-solid fa-circle-xmark fs-5 text-danger"></i>
            <strong class="text-danger">Form İşleminde Hatalar Tespit Edildi:</strong>
        </div>
        <ul class="mb-0 small ps-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
@endif
