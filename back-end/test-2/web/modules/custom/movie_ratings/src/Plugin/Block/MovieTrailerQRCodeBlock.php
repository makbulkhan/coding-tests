<?php

namespace Drupal\movie_ratings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Endroid\QrCode\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Movie Trailer QR Code' Block.
 *
 * @Block(
 *   id = "movie_trailer_qr_code_block",
 *   admin_label = @Translation("Movie Trailer QR Code Block"),
 * )
 */
class MovieTrailerQRCodeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface && $node->bundle() === 'movie') {
      $youtube_link = $node->get('field_video')->value; // Replace with your field name

      // Generate the QR code
      $result = Builder::create()
        ->data($youtube_link)
        ->size(300)
        ->build();

      // Get the QR code as a base64-encoded image
      $image = $result->getDataUri();

      return [
        '#theme' => 'movie_trailer_qr_code',
        '#image' => $image,
        '#caption' => $this->t('Scan the QR code to watch the trailer of this movie.'),
        '#cache' => ['max-age' => 0], // Adjust caching as needed
      ];
    }

    return [];
  }

}

