CREATE DATABASE movie;
USE movie;

CREATE TABLE movies (
    id INT NOT NULL PRIMARY KEY,
    poster_link VARCHAR(255),
    series_title VARCHAR(255),
    released_year INT,
    certificate VARCHAR(20),
    runtime VARCHAR(50),
    imdb_rating FLOAT,
    overview TEXT,
    meta_score INT,
    no_of_votes INT,
    gross BIGINT
);

LOAD DATA INFILE 'F:/Tools/xampp/htdocs/movie/datasets/movies.csv'
INTO TABLE movies
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(id, poster_link, series_title, released_year, certificate, runtime, imdb_rating, overview, meta_score, no_of_votes, gross);

CREATE TABLE genres(
    id INT NOT NULL PRIMARY KEY,
    genre VARCHAR(255)
);

LOAD DATA INFILE 'F:/Tools/xampp/htdocs/movie/datasets/genres.csv'
INTO TABLE genres
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(id, genre);

CREATE TABLE movies_genres (
    movie_id INT NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE ON UPDATE CASCADE
);

LOAD DATA INFILE 'F:/Tools/xampp/htdocs/movie/datasets/movies_genres.csv'
INTO TABLE movies_genres
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(movie_id, genre_id);

SELECT * FROM movies_genres;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    rating FLOAT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
