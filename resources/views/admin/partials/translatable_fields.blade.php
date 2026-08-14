@php
    $cardTitle = $title ?? 'İçerik Bilgileri';
    $modelInstance = $model ?? null;
    $fieldsList = $fields ?? [];
@endphp

<div class="admin-card-glass p-4 mb-4">
    @include('admin.partials.lang_tabs', ['title' => $cardTitle])

    <div class="tab-content pt-2" id="langTabsContent">
        @foreach($activeLocales ?? ['tr' => ['name' => 'Türkçe'], 'en' => ['name' => 'English']] as $code => $loc)
            @php
                $t = $modelInstance ? $modelInstance->translation($code) : null;
            @endphp
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $code }}" role="tabpanel">
                @php
                    $inRow = false;
                @endphp

                @foreach($fieldsList as $field)
                    @php
                        $name = $field['name'];
                        $label = $field['label'] ?? ucfirst($name);
                        $type = $field['type'] ?? 'text';
                        $rows = $field['rows'] ?? 4;
                        $isRequired = (!empty($field['required']) && $code === 'tr');
                        $placeholder = $field['placeholder'] ?? '';
                        $col = $field['col'] ?? null;

                        // Resolve value safely for create or edit
                        $val = old("{$code}.{$name}", $t?->{$name} ?? ($code === 'tr' && $modelInstance ? $modelInstance->getRawOriginal($name) : ''));
                    @endphp

                    @if($col && !$inRow)
                        <div class="row g-3 mb-3">
                        @php $inRow = true; @endphp
                    @elseif(!$col && $inRow)
                        </div>
                        @php $inRow = false; @endphp
                    @endif

                    <div class="{{ $col ?? 'mb-3' }}">
                        <label class="admin-label-light">
                            {{ $label }} ({{ strtoupper($code) }})
                            @if($isRequired) <span class="text-danger">*</span> @endif
                        </label>

                        @if($type === 'text')
                            <input type="text" 
                                   name="{{ $code }}[{{ $name }}]" 
                                   value="{{ $val }}" 
                                   class="form-control admin-input-light @error("{$code}.{$name}") is-invalid @enderror" 
                                   placeholder="{{ $placeholder }}"
                                   {{ $isRequired ? 'required' : '' }}>
                        @elseif($type === 'textarea')
                            <textarea name="{{ $code }}[{{ $name }}]" 
                                      rows="{{ $rows }}" 
                                      class="form-control admin-input-light @error("{$code}.{$name}") is-invalid @enderror" 
                                      placeholder="{{ $placeholder }}"
                                      {{ $isRequired ? 'required' : '' }}>{{ $val }}</textarea>
                        @elseif($type === 'editor')
                            <textarea name="{{ $code }}[{{ $name }}]" 
                                      rows="{{ $rows }}" 
                                      class="form-control admin-input-light tinymce-editor @error("{$code}.{$name}") is-invalid @enderror" 
                                      placeholder="{{ $placeholder }}">{{ $val }}</textarea>
                        @endif

                        @error("{$code}.{$name}")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                @if($inRow)
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
