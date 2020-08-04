<?php

namespace Drupal\usai_webform\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Annotation\WebformHandler;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "submit_handler",
 *   label = @Translation("Handle submit"),
 *   category = @Translation("Custom"),
 *   description = @Translation("After user submits webform add role webform submitter"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
class customSubmissionHandler extends WebformHandlerBase {


  public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    if(!$user->hasRole('webform_submissioner')){
      $user->addRole('webform_submissioner');
      $user->save();
    }


  }
}