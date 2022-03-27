<?php
add_action( 'after_setup_theme', 'theme_setup' );

function theme_setup() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'responsive-embeds' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'html5', array( 'search-form' ) );
  register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'menu' ) ) );
}



add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
  $style_dir = '/lib/css/styles.min.css';
  $script_dir = '/lib/js/scripts.min.js';
  wp_enqueue_style( 'theme-styles', get_template_directory_uri() . $style_dir, array(), filemtime( get_stylesheet_directory() . $style_dir));
  wp_enqueue_script('theme-scripts', get_template_directory_uri() . $script_dir, array(), filemtime( get_template_directory() . $script_dir));
  wp_enqueue_script( 'jquery' );
}


function handle_movie_feed() {
  $MAX_PAGE = 3;


  for ($i=0; $i < $MAX_PAGE; $i++) {
    $url = 'https://api.themoviedb.org/3/movie/popular?api_key='. AUTH_KEY .'&language=en-US&page='. ($i+1);
    $response = wp_remote_get( $url );
    $body = wp_remote_retrieve_body( $response );
    $body_json = json_decode( $body );
    $movie_feed_arr = $body_json->results;


    foreach ($movie_feed_arr as $movie) {
      $args = array(
        'post_type' => 'movies',
        'meta_query' => array(
          array(
            'key' => 'movie_id',
            'value' => $movie->id,
            'compare' => '='
          )
        )
      );


      $query = new WP_Query( $args );
      if ( $query->have_posts() ) {
        continue;
      }

      $post_id = wp_insert_post( array(
        'post_title' => $movie->title,
        'post_type' => 'movies',
        'post_status' => 'publish',
        'meta_input' => array(
          'movie_id' => $movie->id,
          'movie_poster_path' => $movie->poster_path,
          'movie_overview' => $movie->overview,
          'movie_release_date' => $movie->release_date,
          'movie_vote_average' => $movie->vote_average,
          'movie_genre' => get_movie_details($movie->id, 'genres'),
          'movie_release_date' => get_movie_details($movie->id, 'release_date'),
          'movie_runtime' => get_movie_details($movie->id, 'runtime'),
          'movie_country' => get_movie_details($movie->id, 'production_countries'),
          'movie_director' => get_movie_details($movie->id, 'director'),
          'movie_language' => get_movie_details($movie->id, 'spoken_languages'),
          'movie_seasons' => get_movie_details($movie->id, 'number_of_seasons')
        )
      ));
    }
  }

  return $movie_feed_arr;
}

// TODO: Have it run every n days or months.
add_action( 'wp_enqueue_scripts', 'handle_movie_feed' );

function get_movie_details($movie_id, $type) {
  $url = 'https://api.themoviedb.org/3/movie/'. $movie_id .'?api_key='. AUTH_KEY .'&language=en-US';
  $response = wp_remote_get( $url );
  $body = wp_remote_retrieve_body( $response );
  $body_json = json_decode( $body );
  $movie_data = $body_json->$type;

  if($type === 'genre') {
    $genre_arr = array();

    foreach ($movie_data as $genre) {
      array_push($genre_arr, $genre->name);

      return implode(', ', $genre_arr);
    }
  }

  return $movie_details;

}

function create_movie_post_type() {
  register_post_type( 'movies',
    array(
      'labels' => array(
        'name' => __( 'Movies' ),
        'singular_name' => __( 'Movie' )
      ),
      'public' => true,
      'rewrite' => array('slug' => 'movies'),
      'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
      'menu_icon' => 'dashicons-video-alt3'
    )
  );
}
add_action( 'init', 'create_movie_post_type' );