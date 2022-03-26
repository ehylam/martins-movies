<?php get_header();
?>

<section class="hero">
  <div class="container">
    <h1 class="hero__title">Movie Grid 3</h1>
    <div class="hero__breadcrumbs">
      <a href="<?php echo get_home_url();?>" class="hero__link home">Home</a>
      <a href="#" class="hero__link">Movie Grid 3</a>
    </div>
  </div>
</section>

<section class="movie_feed">
  <div class="movie_feed__grid">
    <!-- fetch the custom post type movies with numbered paginations-->
    <?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
      'post_type' => 'movies',
      'posts_per_page' => 12,
      'paged' => $paged
    );
    $query = new WP_Query( $args );?>
    <?php if ( $query->have_posts() ) : ?>
      <?php while ( $query->have_posts() ) : $query->the_post();
        $movie_overview = get_post_meta( get_the_ID(), 'movie_overview', true );
        $movie_vote_average = get_post_meta( get_the_ID(), 'movie_vote_average', true );
        $movie_genres = get_post_meta( get_the_ID(), 'movie_genre', true );
        $movie_poster_path = get_post_meta( get_the_ID(), 'movie_poster_path', true );
        $movie_poster_link = 'https://image.tmdb.org/t/p/w500/'. $movie_poster_path;



        ?>
        <div class="movie_feed__grid-item">
          <a href="<?php the_permalink();?>" class="movie_feed__grid-thumbnail">
            <img src="<?php echo $movie_poster_link;?>">
          </a>
          <div class="movie_feed__grid-content">
            <h2 class="movie_feed__grid-title">
              <?php the_title();?>
            </h2>
            <div class="movie_feed__grid-metadata">
              <span class="rating">
                <?php echo $movie_vote_average;?>/10
              </span>
              <span class="genres">
                <?php echo $movie_genres;?>
              </span>
            </div>

            <div class="movie_feed__grid-description">

            </div>
            <a href="<?php get_permalink();?>" class="movie_feed__grid-btn btn">DETAILS</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif;?>
  </div>
</section>
<?php get_footer(); ?>