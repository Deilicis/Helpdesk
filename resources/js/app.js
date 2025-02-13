import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    // Visi DOM elementi.
    const problemRows = document.querySelectorAll('.problemTable-row');
    const detailsContent = document.getElementById('detailsContent');
    const deleteButton = document.getElementById('deleteButton');
    const backButton = document.getElementById('backButton');
    const problemTable = document.getElementById('problemTable');
    const problemDetails = document.getElementById('problemDetails');
    const contentDiv = document.querySelector('.content');
    const footer = document.querySelector('footer'); 

    let selectedProblemId = null; // Mainīgais, lai izsekotu izvēlētās problēmas ID

    // Cikls cauri katrai tabūlas rindai
    problemRows.forEach(row => {
        // Noņemt clickable uz elementiem, kam ir klase .non-clickable
        const nonClickableCells = row.querySelectorAll('.non-clickable');
        nonClickableCells.forEach(cell => {
            cell.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });

        // EventListener katrai tabulas rindai
        row.addEventListener('click', async function () {
            const problemId = this.getAttribute('data-id'); // iegūst problemId no rindas data-id atribūta
            selectedProblemId = problemId; 
            footer.style.display = 'none';
            contentDiv.style.display = 'none';
            problemDetails.style.display = 'block';

            detailsContent.innerHTML = '<p class="loading">Ielādējam detaļas...</p>';
            deleteButton.style.display = 'none';

            try {
                // Fetcho problem details no servera
                const response = await fetch(`/problems/${problemId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const problem = await response.json();

                // Problēmas detaļas
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
                        <div class="details-row">
                            <p><strong>Rediģētājs:</strong> ${problem.editor ? problem.editor.name : 'N/A'}</p>
                            <p><strong>Izveidošanas Laiks:</strong> ${problem.created_at}</p>
                        </div>
                    </div>
                `;

                deleteButton.style.display = 'block'; // Parāda izdzēst pogu, kad lādēšana beidzas
            } catch (error) {
                // Ja lādēšanās neizdodas, parāda ziņojumu un retry pogu.
                detailsContent.innerHTML = `
                    <p class="error">Neizdevās ielādēt detaļas.</p>
                    <button id="retryButton" class="retry-button">Mēģināt vēlreiz</button>
                `;
                deleteButton.style.display = 'none';

                // retry logic
                const retryButton = document.getElementById('retryButton');
                retryButton.addEventListener('click', () => {
                    row.click(); // Velreiz izsauc click event
                });
            }
        });
    });

    // EventListeners atpakaļ pogai.
    backButton.addEventListener('click', function () {
        problemDetails.style.display = 'none';
        contentDiv.style.display = 'block';
        footer.style.display = 'block';
    });

    // EventListeners problēmas dzēšanas pogai.
    deleteButton.addEventListener('click', async function () {
        if (selectedProblemId) { //ja problēma ir izvēlēta, tad turpina
            try {
                //  Aizsūta DELETE request, lai nodzēstu problēmu no servera
                const response = await fetch(`/problems/${selectedProblemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                //Ja problēmas izdzēšana izdevās, tad noņem to no tabulas.
                const rowToDelete = document.querySelector(`.problemTable-row[data-id="${selectedProblemId}"]`);
                if (rowToDelete) {
                    rowToDelete.remove();
                }
                backButton.click(); // Izsauc atpakaļ pogu, lai aizietu atpakaļ uz tabulu.
            } catch (error) {
                alert('Neizdevās dzēst problēmu.');
            }
        }
    });
});