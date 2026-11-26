import * as bootstrap from 'bootstrap';

// Offboard modal: fill the form action, name and min leaving date from the clicked button.
const offboardModal = document.getElementById('offboardModal');

if (offboardModal) {
    offboardModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        offboardModal.querySelector('form').action = button.dataset.action;
        offboardModal.querySelector('.employee-name').textContent = button.dataset.name;
        offboardModal.querySelector('input[name="date_of_leaving"]').min = button.dataset.joining;
    });
}

// Show / hide password: <button data-password-toggle="#inputId">
document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const input = document.querySelector(button.dataset.passwordToggle);
    if (!input) return;

    button.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        button.querySelector('.bi')?.classList.toggle('bi-eye', !show);
        button.querySelector('.bi')?.classList.toggle('bi-eye-slash', show);
    });
});

// Enable Bootstrap tooltips: <span data-bs-toggle="tooltip" title="...">
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => new bootstrap.Tooltip(el));
