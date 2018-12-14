<?php

namespace Drupal\demo_bigpipe\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;

/**
 * Provides a 'DemoBigPipeBlock' block.
 *
 * @Block(
 *  id = "demo_big_pipe_block",
 *  admin_label = @Translation("Demo big pipe block"),
 * )
 */
class DemoBigPipeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  protected $currentUser;
  
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $currentUser)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
  }
  
  /**
   * {@inheritdoc}
   */
   public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
   {
     return new static(
       $configuration,
       $plugin_id,
       $plugin_definition,
       $container->get('current_user')
     );
   }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    
     //Regular block
    
    //$build['demo_big_pipe_block'] = [
    //  '#markup' =>
    //    '<p>' . \Drupal::translation()->translate('Your name is: @name', ['@name' => $this->currentUser->getDisplayName()]) . '</p>' .
    //    '<p>' . \Drupal::translation()->translate('The current time is @time', ['@time' => \Drupal::service('date.formatter')->format(\Drupal::time()->getRequestTime(), 'custom', 'Y-M-D-h:i:s')]) . '</p>',
    //];
    //\Drupal::service('page_cache_kill_switch')->trigger();
    
    
    //// Lazy builder with placeholder
    //$build['demo_big_pipe_block'] = [
    //  '#lazy_builder' => [static::class . '::lazyBuilder', [$this->currentUser->id(), 'Y-M-D-h:i:s']],
    //   '#create_placeholder' => TRUE,
    //  ];
  
    // Lazy builder with auto-placeholding.
    $build['demo_big_pipe_block'] = [
      '#lazy_builder' => [static::class . '::lazyBuilder', [$this->currentUser->id(), 'Y-M-D-h:i:s']],
    ];
    $build['demo_big_pipe_block']['#cache']['contexts'] = ['user'];
    $build['demo_big_pipe_block']['#cache']['max-age'] = 0;

    return $build;
  }
  
  public static function lazyBuilder($userId, $dateFormat) {
    $account = User::load($userId);
    
    $build = [
      'demo_big_pipe_block' => [
        '#markup' =>
          '<p>' . \Drupal::translation()->translate('Your name is: @name', ['@name' => $account->getDisplayName()]) . '</p>' .
          '<p>' . \Drupal::translation()->translate('The current time is @time', ['@time' => \Drupal::service('date.formatter')->format(\Drupal::time()->getRequestTime(), 'custom', $dateFormat)]) . '</p>'
      ]
    ];
    sleep(3);
    return $build;
  }
}
