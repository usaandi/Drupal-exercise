<?php

namespace Drupal\course_result\Form;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the content_entity_example entity edit forms.
 *
 * @ingroup content_entity
 */
class CourseResultForm extends FormBase {

  public function getFormId() {
    return 'course_result_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('User'),
    ];


    $form['unique_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Unique number'),
    ];

    $form['score_a'] = [
      '#type' => 'number',
      '#title' => $this->t('Score A'),
    ];

       $form['score_b'] = [
      '#type' => 'number',
      '#title' => $this->t('Score B'),
    ];

    $form['actions'] = ['#type' => 'actions'];
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $values = $form_state->getValues();

    $messenger = \Drupal::messenger();
    $messenger->addMessage('Score a: '.$values['score_a']);
    $messenger->addMessage('Score b: '.$values['score_b']);

    preg_match("/(\d+)/", $values['user'], $match);
    $id = $match[1];

   $fields = [
     'course_participant_uid' => (int)$id,
     'score_a' => (int)$values['score_a'],
     'score_b' => (int)$values['score_b'],
   ];

    try {
      \Drupal::entityTypeManager()->getStorage('course_result')->create($fields)->save();
    } catch (InvalidPluginDefinitionException $e) {
    } catch (PluginNotFoundException $e) {
    } catch (EntityStorageException $e) {
    }
  }

}
