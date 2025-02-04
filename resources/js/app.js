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

window.showConfirmPopup = function (action) {
    document.getElementById('deleteUserForm').action = action;
    document.getElementById('confirmDeletePopup').style.display = 'flex';
}

window.hideConfirmPopup = function () {
    document.getElementById('confirmDeletePopup').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const problemRows = document.querySelectorAll('.problemTable-row');
    const detailsContent = document.getElementById('detailsContent');
    const defaultMessage = document.getElementById('defaultMessage');
    const deleteButton = document.getElementById('deleteButton');

    let selectedProblemId = null;

    problemRows.forEach(row => {
        row.addEventListener('click', async function () {
            const problemId = this.getAttribute('data-id');
            selectedProblemId = problemId;

            detailsContent.innerHTML = '<p class="loading">Ielādējam detaļas...</p>';
            deleteButton.style.display = 'none';

            try {
                const response = await fetch(`/problems/${problemId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const problem = await response.json();

                detailsContent.innerHTML = `
                    <p><strong>ID:</strong><br> ${problem.id}</p>
                    <p><strong>Nozare:</strong><br> ${problem.nozare}</p>
                    <p><strong>Virsraksts:</strong><br> ${problem.virsraksts}</p>
                    <p><strong>Apraksts:</strong><br> ${problem.apraksts}</p>
                    <p><strong>Laiks:</strong><br> ${problem.laiks || '-'}</p>
                    <p><strong>Epasts:</strong><br> ${problem.epasts}</p>
                `;


                deleteButton.style.display = 'block';
            } catch (error) {
                detailsContent.innerHTML = `
                    <p class="error">Neizdevās ielādēt detaļas.</p>
                    <button id="retryButton" class="retry-button">Mēģināt vēlreiz</button>
                `;
                deleteButton.style.display = 'none';

                const retryButton = document.getElementById('retryButton');
                retryButton.addEventListener('click', () => {
                    row.click();
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const nozareSelect = document.getElementById('nozare');
        const citsNozareCont = document.getElementById('citsNozareCont');
        const citsNozareInput = document.getElementById('citsNozare');

        nozareSelect.addEventListener('change', function() {
            if (this.value === 'Cits') {
                citsNozareCont.style.display = 'block';
                citsNozareInput.setAttribute('required', 'required');
            } else {
                citsNozareCont.style.display = 'none'; 
                citsNozareInput.removeAttribute('required');
            }
        });
    });

    deleteButton.addEventListener('click', async function () {
        if (!selectedProblemId) return;

        if (confirm('Vai tiešām vēlaties dzēst šo problēmu?')) {
            try {
                const response = await fetch(`/problems/${selectedProblemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });

                console.log('response:', response);

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                console.log('rezultāts:', result);

                const deletedRow = document.querySelector(`.problemTable-row[data-id="${selectedProblemId}"]`);
                if (deletedRow) {
                    deletedRow.remove();
                }

                detailsContent.innerHTML = '<p id="defaultMessage">Izvēlieties problēmu, lai redzētu tās detaļas</p>';
                deleteButton.style.display = 'none';

                alert('Problēma veiksmīgi izdzēsta!');
            } catch (error) {
                console.error('Error:', error);
                alert('Neizdevās dzēst problēmu. Mēģiniet vēlreiz.');
            }
        }
    });
});