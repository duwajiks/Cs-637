const modal = document.getElementById('create-review-modal');
const openModalBtn = document.getElementById('create-review-btn');
const closeModalBtn = modal.querySelector('.close');

openModalBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

document.getElementById('create-review-form').addEventListener('submit', (e) => {
    e.preventDefault();
    
    const title = document.getElementById('review-title').value.trim();
    const content = document.getElementById('review-content').value.trim();
    const rating = parseFloat(document.getElementById('review-rating').value);
    const movieId = parseInt(document.getElementById('review-movie-id').value);
    console.log(movieId)

    if (!title || !content || isNaN(rating) || isNaN(movieId)) {
        alert('Please fill out all fields correctly.');
        return;
    }

    // Create the review object
    const reviewData = {
        title,
        content,
        rating,
        movie_id: movieId
    };
    // Send the review data to the backend
    fetch('/movie/public/api/add_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(reviewData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Review submitted successfully!');
                location.reload(); // Reload the page to reflect the new review
            } else {
                alert('Failed to submit the review. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error submitting review:', error);
            alert('An error occurred. Please try again.');
        });
});