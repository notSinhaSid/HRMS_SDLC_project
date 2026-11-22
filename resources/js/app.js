import * as bootstrap from 'bootstrap'

const offboardModal = document.getElementById('offboardModal');

if (offboardModal) {
    offboardModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        offboardModal.querySelector('form').action = button.dataset.action;
        offboardModal.querySelector('.employee-name').textContent = button.dataset.name;
        offboardModal.querySelector('input[name="date_of_leaving"]').min = button.dataset.joining;
    });
}