# Back end Drupal Coding Test

For this assessment we’ll be importing data from JSON into a few related entities, using the sample data here: https://jsonplaceholder.typicode.com/users.

To set up the project please fork this GitHub repository to your personal account.  

We use Docker Desktop and DDEV for Drupal our local development. If you prefer a different local development enviroment, please use what you are comfortable with or already have set up.

To install Docker and DDEV please follow their instructions here: 
* [Docker](https://ddev.readthedocs.io/en/latest/users/install/docker-installation/)
* [DDEV](https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/)

Once DDEV and Docker are set up you can start the project by running the following commands:

```
cd back-end/test-2
ddev start
ddev composer install
ddev drush site:install --account-name=admin --account-pass=admin -y
ddev launch
```

To stop DDEV run:
```
ddev poweroff
```

1. Install a new Drupal instance with standard profile using ddev and composer.
2. Create content type Movies with following fields -
  a. Title
  b. Director  (referencing the Director content type) - Multi-valued
  c. Actor (referencing the Actor content type) - Multi-valued
  d. Category (referencing a "Categories" taxonomy vocabulary) - Multi-valued
  e. Year of release
3. Create content types for Directors and Actors with fields Title and Bio respectively.
4. Add terms such as "Action," "Drama," "Comedy," etc. for Categories vocabulary.
5. Create a custom module to display and store movie ratings using css/js.
6. Create a rating submission form with a select field and submit button. Users can select from values 1 to 5 stars for the movie.
7. Use the block to display average ratings of the movie using the data added in the database and also add the form to the same block.
  Store ratings along with user IP.
8. Create a view page to display the list of all movies with filters - category, actors, directors and star ratings.
9. On the left sidebar, list down top 5 popular movies (with most votes) and also list top 5 highest rated movies.

Bonus points for
  1. Adding flood control to the ratings submission form to ensure there are no bots submissions.
  2. Adding QR code on each movie page which takes the user to its trailer in Youtube. The text should read - Scan the QR code to watch the trailer of this movie. Youtube link can be stored as a separate field.


Once you’re done, double and triple check your code, including code style to make sure it is up to Drupal standards. Add notes to the module's README.md with a high level overview on your approach and any commands that need to be run for the setup. Also, make sure nothing is hard-coded and you should use configurations where ever required. Also, we can add .gitignore file as per Drupal recommendations.

Email a link back to your repository for us to review. We should be able to clone it locally, run the ddev commands above plus any commands in the module's README.md file to see your work.

You have 48 hours from now to return this exercise back to us. Good luck, and feel free to reach out with any questions!


# Movie Ratings Module

## Module Overview
The `movie_ratings` module is a custom Drupal module designed to allow users to rate movies on a scale of 1 to 5 stars. The module captures and stores user ratings along with the user's IP address to ensure a single rating per user per movie. It also displays the average rating for each movie in a block.

## Features
- **Rating Submission Form:**
  - Allows users to rate movies on a scale of 1 to 5 stars.
  - Captures user ratings and stores them in the database.
  - Records the user's IP address to restrict multiple ratings from the same user.

- **Average Rating Display:**
  - Displays the average rating of a movie in a block.
  - Integrates with the Drupal views system to allow custom display options.
  - The block includes the rating submission form, enabling users to rate movies directly from the block.

- **Flood Control:**
  - Implemented flood control to prevent bot submissions and ensure the integrity of ratings.

- **Custom JavaScript/CSS Integration:**
  - Custom styling and JavaScript can be included without causing the block to disappear.

- **Admin Configurations:**
  - Configurations to customize and manage the rating system, such as enabling/disabling flood control, modifying the rating scale, etc.

## File Structure

```plaintext
movie_ratings/
├── movie_ratings.info.yml
├── movie_ratings.module
├── movie_ratings.install
├── src/
│   ├── Form/
│   │   └── MovieRatingForm.php
│   ├── Plugin/
│   │   └── Block/
│   │       └── MovieRatingBlock.php
│   │       └── MovieTrailerQRCodeBlock.php
├── templates/
│   └── movie-ratings-block.html.twig
├── css/
│   └── movie_ratings.css
└── js/
    └── movie_ratings.js
```


## File Descriptions:

- **movie_ratings.info.yml:**
  Defines the module's metadata, including name, description, dependencies, and version.

- **movie_ratings.module:**
  Contains the main logic and hook implementations for the module.
  Registers the custom block,theme and form.

- **movie_ratings.install:**
  Handles the module's installation and uninstallation procedures, such as creating database tables.

- **src/Form/MovieRatingForm.php:**
  Defines the form for submitting movie ratings.
  Implements validation and submission handling along with flood control to ensure there are no bots submissions.

- **src/Plugin/Block/MovieRatingBlock.php:**
  Defines the custom block that displays the average rating and includes the rating submission form.

- **src/Plugin/Block/MovieTrailerQRCodeBlock.php**
  Defines the custom block that displays the QR code for a video field of a movie node.

- **templates/movie-ratings-block.html.twig:**
  The Twig template used for rendering the block that displays the rating form and average rating.

- **css/movie_ratings.css:**
  Contains custom CSS styles for the movie ratings form and display.

- **js/movie_ratings.js:**
  Currently this file is empty but can be used for any jquery code.

**Database Schema**

The module defines a custom table for storing movie ratings:

Table Name: movie_ratings
Fields:
id: Primary key.
nid: Node ID (reference to the movie node).
ip_address: The IP address of the user who submitted the rating.
rating: The rating given by the user (integer from 1 to 5).

## Installation and Configuration

**Installation:**
```
ddev composer install
ddev drush cim -y
ddev drush cr
```

## Content type & Vocabulary

**Content types**

- **Actor:** This content type has information about the Actor along with image and Bio.
- **Director:** Simple content type contain the title and default body field as Bio.
- **Movie:** This the main content typr to hold information about the Movie name, Video field and refrence to Actor, Director & Category.

**Vocabulary** 

- **Category:** - This contians the term for movies categories like Action, Drama, Horror etc.

## Views and Blocks

**Page:**

- **Movie List**
  Added a view to show the list of movies with Movie thumbnail (generated automatically by video_embed_field module) and filters nmely Category, Actor, Director & Rating. Added url as /movie-list and configured in User account menu.

**Blocks:**

- **Top 5 highest rated movies:**
  This block will list the top 5 highest rated movies order by highest rating and configured on /movie-list page sidebar region.
- **Top 5 popular movies (with most votes):**
  This block will list the top 5 popular movies orderby most rating and configured on /movie-list page sidebar region.
- **Movie Trailer QR Code Block:**
  This block will show the video url in the form of QR code and configured on Movie node page.
- **Movie Ratings:**
  This bloxk will show the average rating of movie in the form of Stars and decimal values. This block also contain the form to accept the ratings in the range of 1 to 5.


## Added a live version as well on Pantheon.io

**Demo URL**

* [https://dev-motion-picture.pantheonsite.io/](https://dev-motion-picture.pantheonsite.io/)

## Shield Authentiation

**Username:**  converse

**Password:**  conversedev
