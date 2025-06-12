import './bootstrap';
import Alpine from 'alpinejs';
import initTicketForm from './ticketForm';
import initFilePreview from './filePreview';

window.Alpine = Alpine;
Alpine.start();

initTicketForm();
initFilePreview();
