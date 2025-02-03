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

document.addEventListener('DOMContentLoaded', function() {
    const problemRows = document.querySelectorAll('.problemTable-row');
    const detailsContent = document.getElementById('detailsContent');
    const defaultMessage = document.getElementById('defaultMessage');

    problemRows.forEach(row => {
        row.addEventListener('click', async function() {
            const problemId = this.getAttribute('data-id');

            detailsContent.innerHTML = '<p class="loading">Ielādējam detaļas...</p>';
            
            try {
                const response = await fetch(`/problems/${problemId}`);
                const problem = await response.json();

                detailsContent.innerHTML = `
                    <p><strong>ID:</strong> ${problem.id}</p>
                    <p><strong>Nozare:</strong> ${problem.nozare}</p>
                    <p><strong>Virsraksts:</strong> ${problem.virsraksts}</p>
                    <p><strong>Apraksts:</strong> ${problem.apraksts}</p>
                    <p><strong>Laiks:</strong> ${problem.laiks || '-'}</p>
                    <p><strong>Epasts:</strong> ${problem.epasts}</p>
                `;
            } catch (error) {
                detailsContent.innerHTML = '<p class="error">Neizdevās ielādēt detaļas.</p>';
            }
        });
    });
});