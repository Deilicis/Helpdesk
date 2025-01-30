import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const action = this.getAttribute('data-action');
            showConfirmPopup(action);
        });
    });
});

window.showConfirmPopup = function(action) {
    document.getElementById('deleteUserForm').action = action;
    document.getElementById('confirmDeletePopup').style.display = 'flex';
}

window.hideConfirmPopup = function() {
    document.getElementById('confirmDeletePopup').style.display = 'none';
}