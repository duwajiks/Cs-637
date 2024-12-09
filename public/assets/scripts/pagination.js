import { currentPage, setCurrentPage } from './state.js';
import { displayMovies } from './display.js';

console.log('displayMovies:', displayMovies); 

const moviesPerPage = 12; // Number of movies per page

export function updatePagination(movieList) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const totalPages = Math.ceil(movieList.length / moviesPerPage);

    // Helper function to create a button
    function createButton(text, isActive = false, onClick = null) {
        const button = document.createElement('button');
        button.textContent = text;
        if (isActive) button.classList.add('active');
        if (onClick) button.addEventListener('click', onClick);
        return button;
    }

    // "Previous" button
    const prevButton = createButton('Previous', false, () => {
        if (currentPage > 1) {
            setCurrentPage(currentPage - 1);
            displayMovies(movieList);
        }
    });
    prevButton.disabled = currentPage === 1;
    paginationContainer.appendChild(prevButton);

    // Page buttons with ellipses
    const visiblePages = [];
    const maxVisible = 3; // Show 3 pages at a time
    const startPage = Math.max(2, currentPage - 1);
    const endPage = Math.min(totalPages - 1, currentPage + 1);

    visiblePages.push(1); // Always show the first page
    if (startPage > 2) visiblePages.push('...'); // Left ellipsis

    for (let i = startPage; i <= endPage; i++) {
        visiblePages.push(i);
    }

    if (endPage < totalPages - 1) visiblePages.push('...'); // Right ellipsis
    visiblePages.push(totalPages); // Always show the last page

    // Render visible pages
    visiblePages.forEach(page => {
        if (page === '...') {
            // Create a styled span for ellipsis
            const ellipsis = document.createElement('span');
            ellipsis.textContent = '...';
            ellipsis.classList.add('ellipsis'); // Apply ellipsis styles
            paginationContainer.appendChild(ellipsis);
        } else {
            // Create a button for pages
            const pageButton = createButton(
                page,
                page === currentPage,
                () => {
                    setCurrentPage(page);
                    displayMovies(movieList);
                }
            );
            paginationContainer.appendChild(pageButton);
        }
    });

    // "Next" button
    const nextButton = createButton('Next', false, () => {
        if (currentPage < totalPages) {
            setCurrentPage(currentPage + 1);
            displayMovies(movieList);
        }
    });
    nextButton.disabled = currentPage === totalPages;
    paginationContainer.appendChild(nextButton);
}
