document.addEventListener('DOMContentLoaded', function () {
    /*
    |--------------------------------------------------------------------------
    | SweetAlert Confirm Forms
    |--------------------------------------------------------------------------
    | يستخدم لأي فورم يحتاج تأكيد قبل الإرسال
    */
    document.querySelectorAll('.swal-confirm-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: form.dataset.title || 'هل أنت متأكد؟',
                text: form.dataset.text || '',
                icon: form.dataset.icon || 'question',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirmButton || 'تأكيد',
                cancelButtonText: form.dataset.cancelButton || 'إلغاء',
                reverseButtons: true,
                confirmButtonColor: form.dataset.confirmColor || '#28a745',
                cancelButtonColor: form.dataset.cancelColor || '#6c757d',
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | SweetAlert Delete Forms
    |--------------------------------------------------------------------------
    | يستخدم لحذف أي عنصر
    */
    document.querySelectorAll('.swal-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: form.dataset.title || 'تأكيد الحذف',
                text: form.dataset.text || 'هل أنت متأكد من الحذف؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirmButton || 'نعم، حذف',
                cancelButtonText: form.dataset.cancelButton || 'إلغاء',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});