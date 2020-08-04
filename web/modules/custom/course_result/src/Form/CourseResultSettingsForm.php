<?php

namespace Drupal\course_result\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContentEntityExampleSettingsForm.
 *
 * @ingroup course_result
 */
class CourseResultSettingsForm extends FormBase {

  const COURSE_ID = 'course_result';
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return self::COURSE_ID;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['course_result']['#markup'] = 'Settings form for course result. Manage field settings here.';
    return $form;
  }

}
