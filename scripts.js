document.addEventListener('DOMContentLoaded', function () {
    let movies = []; // Store movie data globally
    let reviews = {}; // Mock movie reviews

    // Fetch the CSV file and parse it
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

    // Update genre filter text with a cute emoji
    const genreFilter = document.getElementById('genre-filter');
    genreFilter.innerHTML = `<option value="">Pick a genre u like 😊</option>`;

    // Mock reviews data (this would come from a server or file in a real app)
    reviews = {
        "Inception": "Amazing movie with a complex storyline and stunning visuals.",
        "The Dark Knight": "Heath Ledger's performance was phenomenal. A must-watch.",
        "Pulp Fiction": "A classic Quentin Tarantino movie with great dialogues."
    };

    // Event listeners for the navigation
    document.getElementById('home-link').addEventListener('click', function () {
        displayMovies(movies); // Display all movies
    });

    document.getElementById('reviews-link').addEventListener('click', function () {
        displayReviews();
    });

    document.getElementById('top-rated-link').addEventListener('click', function () {
        const topRatedMovies = movies.filter(movie => parseFloat(movie.IMDB_Rating) >= 8.5);
        displayMovies(topRatedMovies); // Display only top-rated movies
    });

    // Search functionality (real-time filtering)
    document.getElementById('search-bar').addEventListener('input', function (event) {
        const query = event.target.value.toLowerCase();
        const filteredMovies = movies.filter(movie => movie.Series_Title.toLowerCase().includes(query));
        displayMovies(filteredMovies); // Display filtered movies
    });

    // Genre filter functionality
    genreFilter.addEventListener('change', function (event) {
        const selectedGenre = event.target.value;
        const filteredMovies = selectedGenre ? movies.filter(movie => movie.Genre.includes(selectedGenre)) : movies;
        displayMovies(filteredMovies); // Display filtered movies by genre
    });

    // Modal functionality
    const modal = document.getElementById('movie-modal');
    const modalDetails = document.getElementById('modal-details');
    const closeModal = document.querySelector('.close');

    function openModal(movie) {
        modal.style.display = 'block';
        modalDetails.innerHTML = `
            <h2>${movie.Series_Title}</h2>
            <p><strong>Year:</strong> ${movie.Released_Year}</p>
            <p><strong>Rating:</strong> ${movie.IMDB_Rating}</p>
            <p><strong>Overview:</strong> ${movie.Overview}</p>
            <p><strong>Director:</strong> ${movie.Director}</p>
            <p><strong>Stars:</strong> ${movie.Star1}, ${movie.Star2}, ${movie.Star3}, ${movie.Star4}</p>
            <p><strong>Genre:</strong> ${movie.Genre}</p>
            <img src="movie_modal_background.jpg" alt="${movie.Series_Title}" class="modal-background-image">
        `;
    }

    closeModal.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    // Function to display movies
    function displayMovies(movies) {
        const movieList = document.getElementById('movie-list');
        movieList.innerHTML = '';
        movies.forEach(movie => {
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
            movieList.appendChild(movieCard);
        });
    }

    // Function to display reviews
    function displayReviews() {
        const movieList = document.getElementById('movie-list');
        movieList.innerHTML = ''; // Clear current movie list
        Object.keys(reviews).forEach(movieTitle => {
            const reviewCard = document.createElement('div');
            reviewCard.className = 'movie-card';
            reviewCard.innerHTML = `
                <h3>${movieTitle}</h3>
                <p>${reviews[movieTitle]}</p>
            `;
            movieList.appendChild(reviewCard);
        });
    }

    // Function to populate genre filter options
    function populateGenreFilter(movies) {
        const genres = [...new Set(movies.map(movie => movie.Genre).flat())];
        genres.forEach(genre => {
            const option = document.createElement('option');
            option.value = genre;
            option.textContent = genre;
            genreFilter.appendChild(option);
        });
    }

    // Fun animation for emoji pop-up
    document.body.addEventListener('click', function (event) {
        const emoji = document.createElement('div');
        emoji.className = 'emoji';
        emoji.style.left = `${event.clientX}px`;
        emoji.style.top = `${event.clientY}px`;
        emoji.textContent = '⭐'; // we can change this to any emoji or symbol
        document.body.appendChild(emoji);

        setTimeout(() => {
            emoji.remove();
        }, 1000);
    });

    // Stickman animation (optional trigger)
    const stickmanAnimation = document.getElementById('stickman-animation');
    setTimeout(() => {
        stickmanAnimation.style.display = 'block';
    }, 2000); // Display the stickman animation after 2 seconds
});
