/* ============================================================
   İPEK HARİTA MÜHENDİSLİK — ADMIN.JS
   Executive Management Console Core Operations & AJAX
   Developed by Kuzeyoku Software
   ============================================================ */

$(document).ready(function () {
    if ($.fn.dropify) {
        var drEvents = $('.dropify').dropify({
            imgFileExtensions: ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp'],
            messages: {
                'default': 'Görseli buraya sürükleyin veya seçmek için tıklayın',
                'replace': 'Değiştirmek için görseli sürükleyin veya tıklayın',
                'remove': 'Kaldır',
                'error': 'Görsel yüklenirken hata oluştu'
            }
        });

        drEvents.on('dropify.afterClear', function (event, element) {
            var form = $(this).closest('form');
            if (form.find('input[name="remove_image"]').length === 0) {
                form.append('<input type="hidden" name="remove_image" value="1">');
            } else {
                form.find('input[name="remove_image"]').val('1');
            }
        });
    }

    if (typeof tinymce !== 'undefined' && document.querySelector('.tinymce-editor')) {
        var csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        var csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        tinymce.init({
            selector: '.tinymce-editor',
            height: 360,
            menubar: false,
            branding: false,
            promotion: false,
            statusbar: true,
            automatic_uploads: true,
            image_title: true,
            file_picker_types: 'image',
            plugins: 'lists link image table code wordcount fullscreen',
            toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright | bullist numlist | link image table | code fullscreen',
            content_style: "body { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #0F172A; } img { max-width: 100%; height: auto; border-radius: 8px; }",
            skin: 'oxide',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    var formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    var uploadUrl = document.body.getAttribute('data-editor-upload-url') || '/admin/editor-upload';

                    fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Yükleme hatası: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(function (json) {
                        if (!json || typeof json.location !== 'string') {
                            reject('Geçersiz sunucu yanıtı');
                            return;
                        }
                        resolve(json.location);
                    })
                    .catch(function (err) {
                        reject(err.message || 'Görsel yüklenirken bir hata oluştu');
                    });
                });
            },
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            style_formats: [
                { title: 'Başlık 2', block: 'h2' },
                { title: 'Başlık 3', block: 'h3' },
                { title: 'Başlık 4', block: 'h4' },
                { title: 'Paragraf', block: 'p' },
                { title: 'Alıntı', block: 'blockquote' }
            ]
        });
    }

    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            var modalEl = document.getElementById('commandPaletteModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                var commandModal = new bootstrap.Modal(modalEl);
                commandModal.show();
            }
        }
    });

    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        var successMsg = document.body.getAttribute('data-toast-success');
        var errorMsg = document.body.getAttribute('data-toast-error');

        if (successMsg) {
            Toast.fire({
                icon: 'success',
                title: successMsg
            });
        }

        if (errorMsg) {
            Toast.fire({
                icon: 'error',
                title: errorMsg
            });
        }

        document.addEventListener('submit', function (e) {
            var form = e.target;
            var confirmMsg = form.getAttribute('data-confirm');
            if (confirmMsg && !form.getAttribute('data-confirmed')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: confirmMsg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: 'Evet, Devam Et',
                    cancelButtonText: 'İptal'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.setAttribute('data-confirmed', 'true');
                        form.submit();
                    }
                });
            }
        });
    }

    var chartEl = document.getElementById('analyticsChart');
    if (chartEl && typeof Chart !== 'undefined') {
        var ctx = chartEl.getContext('2d');

        var gradientBlue = ctx.createLinearGradient(0, 0, 0, 240);
        gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.3)');
        gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        var gradientGold = ctx.createLinearGradient(0, 0, 0, 240);
        gradientGold.addColorStop(0, 'rgba(245, 158, 11, 0.2)');
        gradientGold.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

        var chartLabels = (window.visitorChartConfig && window.visitorChartConfig.labels) ? window.visitorChartConfig.labels : ['1 Ağu', '2 Ağu', '3 Ağu', '4 Ağu', '5 Ağu', '6 Ağu', '7 Ağu'];
        var chartViews = (window.visitorChartConfig && window.visitorChartConfig.views) ? window.visitorChartConfig.views : [10, 15, 22, 18, 30, 25, 40];
        var chartUnique = (window.visitorChartConfig && window.visitorChartConfig.unique) ? window.visitorChartConfig.unique : [4, 6, 8, 7, 12, 9, 15];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Sayfa Görüntüleme (Çoğul)',
                        data: chartViews,
                        borderColor: '#2563EB',
                        borderWidth: 2,
                        backgroundColor: gradientBlue,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Tekil Ziyaretçi',
                        data: chartUnique,
                        borderColor: '#10B981',
                        borderWidth: 2,
                        backgroundColor: gradientGold,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                            usePointStyle: true,
                            padding: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    },
                    y: {
                        grid: { color: '#E2E8F0', strokeDash: [3, 3] },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    }
                }
            }
        });
    }

    var togglePassBtn = document.getElementById('togglePasswordBtn');
    if (togglePassBtn) {
        togglePassBtn.addEventListener('click', function () {
            var passInput = document.getElementById('passwordInput');
            var icon = this.querySelector('i');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }

    var loginForm = document.getElementById('adminLoginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            var siteKey = loginForm.getAttribute('data-recaptcha-sitekey');
            if (siteKey && typeof grecaptcha !== 'undefined' && !loginForm.getAttribute('data-recaptcha-done')) {
                e.preventDefault();
                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'admin_login' }).then(function (token) {
                        var recaptchaInput = document.getElementById('g-recaptcha-response');
                        if (recaptchaInput) {
                            recaptchaInput.value = token;
                        }
                        loginForm.setAttribute('data-recaptcha-done', 'true');
                        loginForm.submit();
                    });
                });
            }
        });
    }
    $(document).on('keyup', '.table-search-input', function () {
        var query = $(this).val().toLowerCase();
        var table = $(this).closest('.admin-card-light, .admin-card-glass, .card').find('table tbody tr');
        table.each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(query) > -1);
        });
    });
});
