import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    //problem view details
    const problemRows = document.querySelectorAll('.problemTable-row');
    const detailsContent = document.getElementById('detailsContent');
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
                <div class="details-grid">
                    <div class="details-row">
                        <p><strong>ID:</strong> ${problem.id}</p>
                        <p><strong>Virsraksts:</strong> ${problem.virsraksts}</p>
                        <p><strong>Nozare:</strong> ${problem.nozare}</p>
                    </div>
                    <div class="details-row" id="apraksts-row">
                        <p><strong>Apraksts:</strong></p>
                        <div id="apraksts-container">
                            <div id="apraksts-content">${problem.apraksts}</div>
                        </div>
                    </div>
                    <div class="details-row">
                        <p><strong>Laiks:</strong> ${problem.laiks || '-'}</p>
                        <p><strong>Epasts:</strong> ${problem.epasts}</p>
                    </div>
                </div>
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

    // delete problem
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
    // nozare select
    const nozareSelect = document.getElementById('nozare');
    const citsNozareCont = document.getElementById('citsNozareCont');
    const citsNozareInput = document.getElementById('citsNozare');

    if (nozareSelect && citsNozareCont && citsNozareInput) {
        nozareSelect.addEventListener('change', function () {
            if (this.value === 'Cits') {
                citsNozareCont.style.display = 'block';
                citsNozareInput.setAttribute('required', 'required');
            } else {
                citsNozareCont.style.display = 'none';
                citsNozareInput.removeAttribute('required');
            }
        });
    } else {
        console.error('One or more elements are missing in the DOM.');
    }
});