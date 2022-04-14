<?php

namespace Drupal\orderplace\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Drupal\user\Entity\User;

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

  public function orderCompleteHandler(WorkflowTransitionEvent $event) {
      \Drupal::logger('order complete hendeler')->notice( "order completed" ); 
      $order = $event->getEntity();
      $uid = $order->get('uid')->getValue();
      $user = User::load($uid[0]['target_id']);
      $user->addRole('administrator');
      $user->save();
  }

  
}