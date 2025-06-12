export default function initTicketForm() {
    const form = document.getElementById('ticketForm');
    if (form) {
        form.addEventListener('submit', () => {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            document.getElementById('submitSpinner').classList.remove('d-none');
        });
    }
}
