document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const message = form.getAttribute('data-confirm');

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });
});
