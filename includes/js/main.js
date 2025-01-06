'use strict';



// View More //
document.addEventListener('DOMContentLoaded', function () {
    const itemsList = document.querySelector('.country-cards');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const itemsPerPage = 4; // Number of items to load per click after the initial 8
    let visibleItems = 8; // Number of items on first load

    // Function to toggle visibility of items
    function toggleItems() {
        const items = Array.from(itemsList.querySelectorAll('.country-card'));
        items.forEach((item, index) => {
            if (index < visibleItems) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Initially show the first 8 items
    toggleItems();

    // Function to load more items
    loadMoreBtn.addEventListener('click', function () {
        const totalItems = itemsList.querySelectorAll('.country-card').length;
        visibleItems += itemsPerPage;
        toggleItems();

        // Hide the "Load More" button if there are fewer than 8 items remaining
        if (visibleItems >= totalItems) {
            loadMoreBtn.style.display = 'none';
        }
    });

    // Hide the "Load More" button if there are initially fewer than 8 items
    const totalItems = itemsList.querySelectorAll('.country-card').length;
    if (totalItems <= visibleItems) {
        loadMoreBtn.style.display = 'none';
    }
});




const searchBarContainerEl = document.querySelector(".search-bar-container");
const magnifierEl = document.querySelector(".magnifier");
const isMobile = window.matchMedia("(max-width: 768px)").matches;
if (!isMobile) {
    searchBarContainerEl.classList.remove("active");
}

function toggleActiveClass() {

    if (isMobile) {
        searchBarContainerEl.classList.toggle("active");
    }
}

magnifierEl.addEventListener("click", toggleActiveClass);
