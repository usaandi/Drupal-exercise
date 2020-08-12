<?php

namespace Drupal\course_result\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityConstraintViolationListInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the content_entity_example entity edit forms.
 *
 * @ingroup content_entity
 */
class CourseResultForm extends ContentEntityForm {

  /**
   * @return string
   */
  public function getFormId() {
    return 'course_result_add_form';
  }

  /**
   * @return string
   */
  public function getBaseFormId() {
    return 'course_result';
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    if (!$form_state->has('entity_form_initialized')) {
      $this->init($form_state);
    }
    $form = parent::buildForm($form, $form_state);

    $form['course_participant_uid'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('User'),
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

    preg_match("/(\d+)/", $values['course_participant_uid'], $match);
    $id = $match[1];

   $fields = [
     'course_participant_uid' => (int)$id,
     'score_a' => (int)$values['score_a'],
     'score_b' => (int)$values['score_b'],
   ];

    try {
      \Drupal::entityTypeManager()->getStorage('course_result')->create($fields)->save();
    } catch (\Exception $e) {
      dd($e);
    }
  }

}
