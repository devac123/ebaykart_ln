<?php

namespace Drupal\commerce_rec\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Drupal\user\Entity\User;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_product\Entity\ProductVariationType;

/**
 * Class OrderCompleteSubscriber.
 *
 * @package Drupal\MY_MODULE
 */
class OrderCompleteSubscriber implements EventSubscriberInterface {
  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   */
  public $account;
  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }
  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['commerce_order.place.post_transition'] = ['orderCompleteHandler'];
    return $events;
  }


  // https://www.drupal.org/docs/creating-custom-modules/defining-and-using-your-own-configuration-in-drupal
  public function orderCompleteHandler(WorkflowTransitionEvent $event) {
      $order = $event->getEntity();
      $uid = $order->get('uid')->getValue();
      $var_Type_id = "";

    foreach ($order->getItems() as $key => $order_item) {
        $product_variation = $order_item->getPurchasedEntity();
        $var_Type_id = $product_variation->bundle();
    }
 
      $config = \Drupal::config('commerce_rec.admin-settings');
      $role = $config->get($var_Type_id);
      $user = User::load($uid[0]['target_id']);
      $user->addRole(strtolower($role));
      $user->save();
  }

  
}