<?php

namespace Drupal\movie_ratings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Movie Ratings' block.
 *
 * @Block(
 *   id = "movie_ratings_block",
 *   admin_label = @Translation("Movie Ratings Block"),
 *   category = @Translation("Custom")
 * )
 */
class MovieRatingsBlock extends BlockBase {
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');

    if ($node instanceof \Drupal\node\NodeInterface && $node->bundle() === 'movie') {
      $movie_id = $node->id();
      $ip_address = \Drupal::request()->getClientIp();

      // Average rating calculation
      $query = \Drupal::database()->select('movie_ratings', 'mr')
        ->fields('mr', ['rating'])
        ->condition('movie_id', $movie_id)
        ->execute();
      $ratings = $query->fetchCol();
      $average = !empty($ratings) ? array_sum($ratings) / count($ratings) : 0;

      // Check if the IP address has already submitted a rating for this movie
      
      /* 
      // Uncomment in case need to restrict 1 review per moview node per ip address.
      $ip_check = \Drupal::database()->select('movie_ratings', 'mr')
        ->fields('mr', ['rating'])
        ->condition('movie_id', $movie_id)
        ->condition('ip_address', $ip_address)
        ->execute()
        ->fetchField();
       */

      // Render form
      $form = \Drupal::formBuilder()->getForm('Drupal\movie_ratings\Form\MovieRatingForm');

      // Render stars based on the average rating
      $stars = $this->renderStars($average);
      return [
	'#theme' => 'movie_rating_section',
        '#form' => $form, //$ip_check ? ['#markup' => '<p>You have already rated this movie.</p>'] : $form,
	'#stars' => $stars,
	'#average' => $average,
        '#cache' => [
          'contexts' => ['url.path'],
          'tags' => ['node:' . $movie_id],
          'max-age' => 0,
        ],
      ];
    }

    return [];
  }

  /**
  * Renders the stars based on the average rating with percentage fill.
  */
  private function renderStars($average) {
    // Round the average to the nearest multiple of 10
    $rounded_average = round($average * 10) * 10;
    
    // Calculate full stars and percentage for the remaining star
    $full_stars = floor($rounded_average / 100);
    $percentage = $rounded_average % 100;

    // Convert percentage to the closest multiple of 10 for the last star
    $last_star_fill = round($percentage / 10) * 10;

    $stars = '';

    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
      $stars .= '<span class="star fill-100"></span>';
    }

    // Partial star based on percentage
    if ($last_star_fill > 0) {
      $stars .= '<span class="star fill-' . $last_star_fill . '"></span>';
    }

    // Empty stars
    $empty_stars = 5 - $full_stars - ($last_star_fill > 0 ? 1 : 0);
    for ($i = 0; $i < $empty_stars; $i++) {
      $stars .= '<span class="star fill-0"></span>';
    }

    return $stars;
  }
}
