import { displayMovies } from './display.js';

let currentPage = 1;

// Close modal
const modal = document.getElementById('movie-modal');
const closeModal = document.querySelector('.close');

closeModal.onclick = function () {
    modal.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

let currentMovies = [...movies];
// Filter movies search 
document.getElementById('search-bar').addEventListener('input', function (event) {
    const query = event.target.value.toLowerCase();
    currentMovies = movies.filter(movie =>
        movie.series_title.toLowerCase().includes(query)
    );
    currentPage = 1; // Reset to the first page
    displayMovies(currentMovies);
});


// Filter movies genre
document.getElementById('genre-filter').addEventListener('change', function () {
    const selectedGenre = this.value;
    currentMovies = movies.filter(movie =>
        selectedGenre === '' || movie.genres.includes(parseInt(selectedGenre))
    );
    currentPage = 1; // Reset to the first page
    displayMovies(currentMovies);
});

// Initial display
document.addEventListener('DOMContentLoaded', () => {
    displayMovies(movies);
});
