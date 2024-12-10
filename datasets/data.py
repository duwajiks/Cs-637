import pandas as pd
import csv 

def extract_actors(data):
    movies = data[[
        "Series_Title", "Released_Year", "Genre", "IMDB_Rating",
        "Overview", "Meta_score", "Director", "Poster_Link", "Runtime", "Certificate"
    ]].drop_duplicates()

    movies["id"] = movies.index + 1  
    movies.to_csv("movies.csv", index=False)

    # Extract unique actors
    actors = pd.DataFrame(
        pd.concat([data["Star1"], data["Star2"], data["Star3"], data["Star4"]]).drop_duplicates(), 
        columns=["name"]
    ).dropna()

    actors["id"] = actors.index + 1  
    actors.to_csv("actors.csv", index=False)

    movie_actor = []

    for i, row in data.iterrows():
        movie_id = movies[movies["Series_Title"] == row["Series_Title"]].iloc[0]["id"]
        for star in ["Star1", "Star2", "Star3", "Star4"]:
            actor_name = row[star]
            if pd.notna(actor_name):
                actor_id = actors[actors["name"] == actor_name].iloc[0]["id"]
                movie_actor.append({"movie_id": movie_id, "actor_id": actor_id})

    movie_actor_df = pd.DataFrame(movie_actor)
    movie_actor_df.to_csv("movie_actor.csv", index=False)

def extract_gerne(data):
    movies = data[[
    "Series_Title", "Released_Year", "Genre", "IMDB_Rating",
    "Overview", "Meta_score", "Director", "Poster_Link", "Runtime", "Certificate"
    ]].drop_duplicates()

    movies["id"] = movies.index + 1  # Add a unique ID for each movie
    movies.to_csv("movies.csv", index=False)

    # Extract unique genres
    genre_list = set()
    for genres in data["Genre"].dropna():
        genre_list.update([g.strip() for g in genres.split(",")])  # Split and strip genres

    genres_df = pd.DataFrame({"name": list(genre_list)})
    genres_df["id"] = genres_df.index + 1  # Add a unique ID for each genre
    genres_df.to_csv("genres.csv", index=False)

    # Create the movie_genres relationship table
    movie_genres = []

    for i, row in data.iterrows():
        movie_id = movies[movies["Series_Title"] == row["Series_Title"]].iloc[0]["id"]
        if pd.notna(row["Genre"]):
            for genre in [g.strip() for g in row["Genre"].split(",")]:
                genre_id = genres_df[genres_df["name"] == genre].iloc[0]["id"]
                movie_genres.append({"movie_id": movie_id, "genre_id": genre_id})

    movie_genres_df = pd.DataFrame(movie_genres)
    movie_genres_df.to_csv("movie_genres.csv", index=False)

def extract_directors(data):
    movies = data[[
    "Series_Title", "Released_Year", "Genre", "IMDB_Rating",
    "Overview", "Meta_score", "Director", "Poster_Link", "Runtime", "Certificate"
    ]].drop_duplicates()

    movies["id"] = movies.index + 1  # Add a unique ID for each movie
    movies.to_csv("movies.csv", index=False)

    # Extract unique directors
    directors_df = data[["Director"]].drop_duplicates().dropna()
    directors_df["id"] = directors_df.index + 1  # Add a unique ID for each director
    directors_df.rename(columns={"Director": "name"}, inplace=True)  # Rename column to 'name'
    directors_df.to_csv("directors.csv", index=False)

    # Create the movie-directors relationship table
    movie_directors = []

    for i, row in data.iterrows():
        movie_id = movies[movies["Series_Title"] == row["Series_Title"]].iloc[0]["id"]
        if pd.notna(row["Director"]):
            director_id = directors_df[directors_df["name"] == row["Director"]].iloc[0]["id"]
            movie_directors.append({"movie_id": movie_id, "director_id": director_id})

    movie_directors_df = pd.DataFrame(movie_directors)
    movie_directors_df.to_csv("movie_directors.csv", index=False)


if __name__=="__main__":

    movies_df = pd.read_csv('movies.csv')  
    new_dataset_df = pd.read_csv('movie_dataset_v11.csv')  

    # Standardize the column names to ensure consistent comparisons
    # Assuming your existing dataset also has a 'series_title' column for movie titles
    movies_df['Series_Title'] = movies_df['Series_Title'].str.strip().str.lower()
    new_dataset_df['original_title'] = new_dataset_df['original_title'].str.strip().str.lower()

    common_movies = pd.merge(
        movies_df, 
        new_dataset_df, 
        left_on='Series_Title', 
        right_on='original_title', 
        how='inner'
    )

    # Output results
    print(f"Number of common movies: {len(common_movies)}")
    print(common_movies[['Series_Title', 'original_title']])

    # Save the results to a CSV file for further inspection if needed
    common_movies.to_csv('common_movies.csv', index=False)

    # input_file = 'movie_genres.csv'  # Your input file
    # output_file = 'movies_genres_cleaned.csv'  # File to save cleaned data

    # # Use a set to track unique movie-genre pairs
    # unique_rows = set()

    # try:
    #     with open(input_file, 'r') as infile, open(output_file, 'w', newline='') as outfile:
    #         reader = csv.reader(infile)
    #         writer = csv.writer(outfile)

    #         # Read the header row
    #         header = next(reader)
    #         writer.writerow(header)  # Write the header to the output file

    #         # Process each row
    #         for row in reader:
    #             # Convert row to a tuple to use in a set (immutable and hashable)
    #             row_tuple = tuple(row)

    #             if row_tuple not in unique_rows:
    #                 unique_rows.add(row_tuple)
    #                 writer.writerow(row)  # Write unique rows to the output file

    #     print(f"Duplicates removed. Cleaned file saved as '{output_file}'")

    # except FileNotFoundError:
    #     print(f"Error: File '{input_file}' not found.")
    # except Exception as e:
    #     print(f"An error occurred: {e}")