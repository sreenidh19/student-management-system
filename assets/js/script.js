document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    }

    // Small client-side check; PHP also validates all submitted data.
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            const button = form.querySelector('button[type="submit"], button:not([type])');
            if (button && !button.dataset.noLoading) {
                button.dataset.originalText = button.textContent;
                button.textContent = 'Please wait...';
            }
        });
    });
});
