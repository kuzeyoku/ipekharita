<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 border-bottom pb-2 mb-3">
    <h5 class="fw-bold text-dark m-0 font-outfit">{{ $title ?? 'İçerik Bilgileri' }}</h5>
    <ul class="nav nav-pills lang-pill-tabs gap-1" id="langTabs" role="tablist" style="background: rgba(0,0,0,0.04); padding: 3px; border-radius: 8px;">
        @foreach($activeLocales ?? ['tr' => ['flag' => '🇹🇷', 'name' => 'Türkçe'], 'en' => ['flag' => '🇬🇧', 'name' => 'English']] as $code => $loc)
            <li class="nav-item" role="presentation">
                <button class="nav-item-btn {{ $loop->first ? 'active text-dark' : 'text-secondary' }} btn btn-sm py-1 px-3 fw-semibold border-0 rounded-2" 
                        id="{{ $code }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#lang-{{ $code }}" 
                        type="button" 
                        role="tab">
                    <span class="me-1">{{ $loc['flag'] ?? '🌐' }}</span> {{ $loc['name'] ?? strtoupper($code) }} ({{ strtoupper($code) }})
                </button>
            </li>
        @endforeach
    </ul>
</div>
