import { currentPage } from './state.js';
import { updatePagination } from './pagination.js';

function openModal(movie) {
    const modal = document.getElementById('movie-modal');
    const modalDetails = document.getElementById('modal-details');
    const youtubeSearchUrl = `https://www.youtube.com/results?search_query=${encodeURIComponent(movie.series_title)}+trailer`;
    const commentsList = document.getElementById('comments-list');
    const movieGenres = movie.genres
        .map(genreId => genres.find(genre => genre.id === genreId)?.genre || 'Unknown')
        .join(', ');

    modal.style.display = 'block';
    modalDetails.innerHTML = `
        <img src="${movie.poster_link}" alt="${movie.series_title} Poster">
        <h2>${movie.series_title}</h2>
        <p><strong>Year:</strong> ${movie.released_year}</p>
        <p><strong>Rating:</strong> ${movie.imdb_rating}</p>
        <p><strong>Overview:</strong> ${movie.overview}</p>
        <p><strong>Genre:</strong> ${movieGenres}</p>
        <p><a href="${youtubeSearchUrl}" target="_blank">Search for Trailer on YouTube</a></p>
    `;
    // Fetch comments via API
    fetch(`/movie/public/api/get_comments.php?movie_id=${movie.movie_id}`)
        .then(response => response.json())
        .then(comments => {
            commentsList.innerHTML = ''; // Clear existing comments
            comments.forEach(comment => {
                const commentItem = document.createElement('div');
                commentItem.classList.add('comment-item');
                commentItem.innerHTML = `
                    <p><strong>${comment.username}</strong>: ${comment.comment}</p>
                    <p class="comment-date">${new Date(comment.created_at).toLocaleString()}</p>
                `;
                commentsList.appendChild(commentItem);
            });
        });
    // Attach event listener to the submit button
    document.getElementById('submit-comment').addEventListener('click', function () {
        const newComment = document.getElementById('new-comment').value.trim();

        if (newComment) {
            fetch('/movie/public/api/add_comments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    movie_id: movie.movie_id, // Use the movie ID from the modal
                    user_id: 1,               // Replace with the logged-in user ID
                    comment: newComment
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        openModal(movie); // Reload modal to refresh comments
                    } else {
                        alert('Error submitting comment');
                    }
                });
        }
    });

    modal.style.display = 'block';
}

export function displayMovies(movieList) {
    const movieGrid = document.getElementById('movie-list');
    movieGrid.innerHTML = ''; // Clear the grid

    console.log(`Page button clicked: ${currentPage}`); // Debugging


    const moviesPerPage = 12;
    const startIndex = (currentPage - 1) * moviesPerPage;
    const endIndex = Math.min(startIndex + moviesPerPage, movieList.length);

    for (let i = startIndex; i < endIndex; i++) {
        const movie = movieList[i];
        const movieCard = document.createElement('div');
        movieCard.classList.add('movie-card');

        movieCard.innerHTML = `
            <img src="${movie.poster_link}" alt="${movie.series_title} Poster">
            <h3>${movie.series_title}</h3>
            <p>Year: ${movie.released_year}</p>
            <p>Rating: ${movie.imdb_rating}</p>
            <button class="details-btn">View Details</button>
        `;

        // Attach event listener to the button
        const detailsButton = movieCard.querySelector('.details-btn');
        detailsButton.addEventListener('click', () => openModal(movie));

        movieGrid.appendChild(movieCard); // Add movie card to the grid
    }

    updatePagination(movieList); // Update pagination controls
}
