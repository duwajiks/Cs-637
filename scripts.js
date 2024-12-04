document.addEventListener('DOMContentLoaded', function () {
    let movies = []; // Store movie data globally
    let reviews = {}; // Mock movie reviews
    let currentPage = 1; // Start with the first page
    const moviesPerPage = 10; // Movies to display per page

    // Fetch the CSV file for movies
    fetch('imdb_top_1000.csv')
        .then(response => response.text())
        .then(data => {
            const parsedData = Papa.parse(data, {
                header: true,
                skipEmptyLines: true,
                complete: function (results) {
                    movies = results.data;
                    populateGenreFilter(movies); // Populate genre filter options
                    displayMovies(movies); // Display all movies initially
                }
            });
        });

    // Display the movies based on the current page
    function displayMovies(movieList) {
        const movieListContainer = document.getElementById('movie-list');
        const paginationContainer = document.getElementById('pagination');
        movieListContainer.innerHTML = '';

        // Calculate start and end indices for the current page
        const startIndex = (currentPage - 1) * moviesPerPage;
        const endIndex = currentPage * moviesPerPage;
        const moviesToShow = movieList.slice(startIndex, endIndex);

        // Create movie cards
        moviesToShow.forEach(movie => {
            const movieCard = document.createElement('div');
            movieCard.className = 'movie-card';
            movieCard.innerHTML = `
                <h3>${movie.Series_Title}</h3>
                <p>Year: ${movie.Released_Year}</p>
                <p>Rating: ${movie.IMDB_Rating}</p>
                <p>Genre: ${movie.Genre}</p>
                <button class="details-btn">View Details</button>
            `;
            movieCard.querySelector('.details-btn').addEventListener('click', () => openModal(movie));
            movieListContainer.appendChild(movieCard);
        });

        // Update pagination
        updatePagination(movieList);
    }

    // Update pagination controls
    function updatePagination(movieList) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(movieList.length / moviesPerPage);

        // Previous button
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            currentPage = currentPage > 1 ? currentPage - 1 : 1;
            displayMovies(movieList);
        });
        paginationContainer.appendChild(prevButton);

        // Next button
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            currentPage = currentPage < totalPages ? currentPage + 1 : totalPages;
            displayMovies(movieList);
        });
        paginationContainer.appendChild(nextButton);
    }

    // Open modal with movie details
    function openModal(movie) {
        const modal = document.getElementById('movie-modal');
        const modalDetails = document.getElementById('modal-details');
        const youtubeSearchUrl = `https://www.youtube.com/results?search_query=${encodeURIComponent(movie.Series_Title)}+trailer`;

        modal.style.display = 'block';
        modalDetails.innerHTML = `
            <h2>${movie.Series_Title}</h2>
            <p><strong>Year:</strong> ${movie.Released_Year}</p>
            <p><strong>Rating:</strong> ${movie.IMDB_Rating}</p>
            <p><strong>Overview:</strong> ${movie.Overview}</p>
            <p><strong>Director:</strong> ${movie.Director}</p>
            <p><strong>Stars:</strong> ${movie.Star1}, ${movie.Star2}, ${movie.Star3}, ${movie.Star4}</p>
            <p><strong>Genre:</strong> ${movie.Genre}</p>
            <p><a href="${youtubeSearchUrl}" target="_blank">Search for Trailer on YouTube</a></p>
        `;
    }

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

    // Populate genre filter
    function populateGenreFilter(movies) {
        const genreFilter = document.getElementById('genre-filter');
        const genres = [...new Set(movies.map(movie => movie.Genre).flat())];
        genres.forEach(genre => {
            const option = document.createElement('option');
            option.value = genre;
            option.textContent = genre;
            genreFilter.appendChild(option);
        });
    }

    // Genre filter functionality
    document.getElementById('genre-filter').addEventListener('change', function (event) {
        const selectedGenre = event.target.value;
        const filteredMovies = selectedGenre ? movies.filter(movie => movie.Genre.includes(selectedGenre)) : movies;
        currentPage = 1; // Reset to first page
        displayMovies(filteredMovies);
    });

    // Search functionality
    document.getElementById('search-bar').addEventListener('input', function (event) {
        const query = event.target.value.toLowerCase();
        const filteredMovies = movies.filter(movie => movie.Series_Title.toLowerCase().includes(query));
        currentPage = 1; // Reset to first page
        displayMovies(filteredMovies);
    });

    // Navigation links functionality
    document.getElementById('home-link').addEventListener('click', function () {
        currentPage = 1; // Reset to first page
        displayMovies(movies); // Display all movies
    });

    document.getElementById('reviews-link').addEventListener('click', function () {
        const movieListContainer = document.getElementById('movie-list');
        const paginationContainer = document.getElementById('pagination');
        movieListContainer.innerHTML = '';
        paginationContainer.innerHTML = ''; // No pagination for reviews

        Object.keys(reviews).forEach(movieTitle => {
            const reviewCard = document.createElement('div');
            reviewCard.className = 'movie-card';
            reviewCard.innerHTML = `
                <h3>${movieTitle}</h3>
                <p>${reviews[movieTitle]}</p>
            `;
            movieListContainer.appendChild(reviewCard);
        });
    });

    document.getElementById('top-rated-link').addEventListener('click', function () {
        const topRatedMovies = movies.filter(movie => parseFloat(movie.IMDB_Rating) >= 8.5);
        currentPage = 1; // Reset to first page
        displayMovies(topRatedMovies); // Display only top-rated movies
    });
});
