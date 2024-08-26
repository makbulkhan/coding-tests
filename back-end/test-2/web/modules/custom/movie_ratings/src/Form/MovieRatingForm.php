<?php

namespace Drupal\movie_ratings\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Provides a movie rating form.
 */
class MovieRatingForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The flood service.
   *
   * @var \Drupal\Core\Flood\FloodInterface
   */
  protected $flood;

  /**
   * Constructs a new MovieRatingForm.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood service.
   */
  public function __construct(Connection $database, FloodInterface $flood) {
    $this->database = $database;
    $this->flood = $flood;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('flood')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'movie_rating_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $ip_address = \Drupal::request()->getClientIp();

    // Check if the IP is allowed to submit based on flood control.
    // This setup ensures that the form is protected against bots and limits the 
    // number of submissions from the same IP address within a specified time frame.
    if ($this->flood->isAllowed('movie_rating_form', 5, 3600, $ip_address)) {
      $node = \Drupal::routeMatch()->getParameter('node');
      if ($node instanceof \Drupal\node\NodeInterface) {
        $movie_id = $node->id();
      }

      $form['rating'] = [
        '#type' => 'select',
        '#title' => $this->t('Rate this movie'),
        '#options' => [1 => '1 star', 2 => '2 stars', 3 => '3 stars', 4 => '4 stars', 5 => '5 stars'],
        '#ajax' => [
          'callback' => '::submitAjax',
          'event' => 'change',
          'progress' => ['type' => 'throbber'],
        ],
      ];

      $form['#attached']['library'][] = 'movie_ratings/movie_ratings';
    }
    else {
      // If flood limit is reached, show a message.
      $form['message'] = [
        '#markup' => $this->t('You have reached the submission limit. Please try again later.'),
      ];
    }

    return $form;
  }

  /**
   * AJAX callback to handle form submission.
   */
  public function submitAjax(array &$form, FormStateInterface $form_state) {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      $movie_id = $node->id();
      $rating = $form_state->getValue('rating');
      $ip_address = \Drupal::request()->getClientIp();

      // Insert the rating into the database.
      $this->database->insert('movie_ratings')
        ->fields([
          'movie_id' => $movie_id,
          'rating' => $rating,
          'ip_address' => $ip_address,
        ])
        ->execute();

      // Register the event in flood control.
      $this->flood->register('movie_rating_form', 3600, $ip_address);

      // Calculate the new average rating.
      $average = $this->calculateAverageRating($movie_id);

      // Return an AJAX response to update the average rating display.
      $response = new AjaxResponse();
      $response->addCommand(new HtmlCommand('#average-rating', 'Average Rating: ' . number_format($average, 1) . ' Stars'));

      return $response;
    }

    return [];
  }

  /**
   * Calculate the average rating for a given movie.
   */
  protected function calculateAverageRating($movie_id) {
    $query = $this->database->select('movie_ratings', 'mr')
      ->fields('mr', ['rating'])
      ->condition('movie_id', $movie_id)
      ->execute();
    $ratings = $query->fetchCol();
    return !empty($ratings) ? array_sum($ratings) / count($ratings) : 0;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Not used since we're submitting via AJAX.
  }
}

