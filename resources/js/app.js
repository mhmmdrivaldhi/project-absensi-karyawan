import Swal from 'sweetalert2';
import './bootstrap';

function showAlert(type, title, text) {
    Swal.fire({
        icon: type,
        title: title,
        text: text
    })
}
