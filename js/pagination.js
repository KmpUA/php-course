const toursPerPage = 4;
const totalTours = document.querySelectorAll('.card').length;
const cards = document.querySelectorAll('.card');
function showPage(pageNumber) {
    const startIndex = (pageNumber - 1) * toursPerPage;
    const endIndex = startIndex + toursPerPage;

    const cardContainer = document.getElementById("prod1");
    cardContainer.innerHTML = "";

    for (let i = startIndex; i < Math.min(endIndex, totalTours); i++) {
        const tourValue = cards[i];
        cardContainer.appendChild(tourValue)
    }
}

function generatePaginationButtons(currentPage) {
    const pageButtonsContainer = document.getElementById("page-buttons");
    const totalPages = Math.ceil(totalTours / toursPerPage);

    const maxButtons = 3;
    let startPage, endPage;
    if (totalPages <= maxButtons) {
        startPage = 1;
        endPage = totalPages;
    } else {
        if (currentPage <= Math.floor(maxButtons / 2) + 1) {
            startPage = 1;
            endPage = maxButtons;
        } else if (currentPage >= totalPages - Math.floor(maxButtons / 2)) {
            startPage = totalPages - maxButtons + 1;
            endPage = totalPages;
        } else {
            startPage = currentPage - Math.floor(maxButtons / 2);
            endPage = currentPage + Math.floor(maxButtons / 2);
        }
    }

    pageButtonsContainer.innerHTML = "";

    const firstButton = document.createElement("button");
    firstButton.className = "page-button";
    firstButton.textContent = "First";
    firstButton.addEventListener("click", () => showPage(1));
    pageButtonsContainer.appendChild(firstButton);
    for (let i = startPage; i <= endPage; i++) {
        const button = document.createElement("button");
        button.className = "page-button";
        button.textContent = i;
        if(currentPage == startPage){
            button.setAttribute('disabled', 'disabled');
        }
        button.addEventListener("click", () => {
            showPage(i);
            generatePaginationButtons(i);
        });
        pageButtonsContainer.appendChild(button);
    }

    const lastButton = document.createElement("button");
    lastButton.className = "page-button";
    lastButton.textContent = "Last";
    lastButton.addEventListener("click", () => showPage(totalPages));
    pageButtonsContainer.appendChild(lastButton);
}



showPage(1);
generatePaginationButtons(1);
