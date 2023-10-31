const imagesPerPage = 2;
let currentPage = 1;
let currentImages = [];

const imagesList = document.getElementById("prod1");
const startCards = imagesList.querySelectorAll('.card');
const loadNextButton = document.getElementById("nextBtn");
const loadPreviousButton = document.getElementById("prevBtn");
const pageNumP = document.getElementById("page-num");
const pageButtonsContainer = document.getElementById("page-buttons");
const selector = document.querySelector('#sort-select');
const searchCon = document.querySelector('.search-container');
const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".ranger-slider .progress");
let priceGap = 0;
let minVal = parseInt(rangeInput[0].value),
    maxVal = parseInt(rangeInput[1].value);

range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

fetch("https://api.jsonbin.io/v3/b/645146669d312622a3562425")
    .then(response => response.json())
    .then(data => {
        imagesData = data.record;
        imagesData = imagesData.filter((element) => {
            return element != null;
        });
        function convert(x) {
            var floatValue = +(x);
            return floatValue;
        }

        
        searchCon.addEventListener('click', () => {
            selector.addEventListener('change', (e) => {
                const cardsSort = Array.from(startCards);
                switch (parseInt(e.originalTarget.value)) {
                    case 1:
                        cardsSort.sort((a, b) => {
                            return parseInt(a.querySelector('.product-price').innerText.replace('$', '')) -
                                parseInt(b.querySelector('.product-price').innerText.replace('$', ''));
                        });
                        break;
                    case 2:
                        cardsSort.sort((a, b) => {
                            return parseInt(b.querySelector('.product-price').innerText.replace('$', '')) -
                                parseInt(a.querySelector('.product-price').innerText.replace('$', ''));
                        });
                        break;
                    case 3:
                        cardsSort.sort((a, b) => {
                            return a.lastElementChild.children[0].innerText.localeCompare(b.lastElementChild.children[0].innerText);
                        });
                        break;
                    default:
                        break;
                }
                let crdCnt = document.querySelector('.card-container');
                crdCnt.innerHTML = '';
                cardsSort.forEach((card) => {
                    crdCnt.appendChild(card);
                });
            });
        });
        
        priceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);
                let cards = Array.from(startCards);
                cards = cards.filter((element) => {
                    return parseInt(element.querySelector('.product-price').innerText.replace('$', '')) >= minPrice && parseInt(element.querySelector('.product-price').innerText.replace('$', '')) <= maxPrice;
                });
                let crdCnt = document.querySelector('.card-container');
                crdCnt.innerHTML = '';
                cards.forEach((card) => {
                    crdCnt.appendChild(card);
                });
                if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    } else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });
        
        rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(rangeInput[0].value),
                    maxPrice = parseInt(rangeInput[1].value);
                let cards = Array.from(startCards);
                cards = cards.filter((element) => {
                    return parseInt(element.querySelector('.product-price').innerText.replace('$', '')) >= minPrice && parseInt(element.querySelector('.product-price').innerText.replace('$', '')) <= maxPrice;
                });
                let crdCnt = document.querySelector('.card-container');
                crdCnt.innerHTML = '';
                cards.forEach((card) => {
                    crdCnt.appendChild(card);
                });
                if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    } else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });
    })
    .catch(error => console.error(error));
const searchInput = document.querySelector(".search-input");
const filterBtns = document.querySelectorAll(".filter-btn");
const searchContainer = document.querySelector('.main-filter-container');
const sortSelect = document.querySelector('#sort-select');

searchContainer.addEventListener('click', (event) => {
    searchInput.addEventListener("keyup", function () {
        const searchTerm = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        cards.forEach(function (card) {
            const title = card.querySelector(".card-title").innerText.toLowerCase();
            if (title.indexOf(searchTerm) != -1) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });

    filterBtns.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            const region = e.currentTarget.dataset.region;
            const cards = document.querySelectorAll('.card');
            cards.forEach(function (card) {
                if (region === "all") {
                    card.style.display = "block";
                } else {
                    const title = card.querySelector('.region').innerText;
                    if (title.indexOf(region) != -1) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                }
            });
        });
    });
});





