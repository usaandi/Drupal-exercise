<?php

namespace Drupal\usai_webform\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Annotation\WebformElement;
use Drupal\webform\Plugin\WebformElementBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides WebformCompositeExample webform composite element.
 *
 * @WebformElement(
 *   id = "webform_usai_text_element",
 *   label = @Translation("Text field"),
 *   description = @Translation("Provides a custom webform element."),
 *   category = @Translation("Custom"),
 * )
 */
class CustomWebformElement extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  protected function defineDefaultProperties() {

    // @see \Drupal\webform\Plugin\WebformElementBase::defaultProperties
    // @see \Drupal\webform\Plugin\WebformElementBase::defaultBaseProperties
    return [
        'multiple' => '',
        'size' => '',
        'minlength' => '',
        'maxlength' => '',
        'placeholder' => '',
      ] + parent::defineDefaultProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function prepare(array &$element, WebformSubmissionInterface $webform_submission = NULL) {
    parent::prepare($element, $webform_submission);

  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    return $form;
  }
}