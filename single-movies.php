<?php get_header();
$movie_overview = get_post_meta( get_the_ID(), 'movie_overview', true );
$movie_vote_average = get_post_meta( get_the_ID(), 'movie_vote_average', true );
$movie_genres = get_post_meta( get_the_ID(), 'movie_genre', true );
$movie_poster_path = get_post_meta( get_the_ID(), 'movie_poster_path', true );
$movie_poster_link = 'https://image.tmdb.org/t/p/w500/'. $movie_poster_path;
?>

<section class="movie_hero">

  <div class="movie_hero__wrapper">
    <img src="<?php echo $movie_poster_link;?>" class="movie_hero__poster">
    <div class="movie_hero__content">
      <h1 class="movie_hero__title"><?php the_title();?></h1>
      <div class="movie_hero__metadata">
        <span class="rating">
          <?php echo $movie_vote_average;?>/10
        </span>
        <span class="genres">
          <?php echo $movie_genres;?>
        </span>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>