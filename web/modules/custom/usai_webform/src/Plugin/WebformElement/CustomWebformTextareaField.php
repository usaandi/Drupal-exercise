<?php

namespace Drupal\usai_webform\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Annotation\WebformElement;
use Drupal\webform\Plugin\WebformElement\Textarea;

/**
 * Provides a 'textarea' element.
 *
 * @WebformElement(
 *   id = "textarea",
 *   api = "https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Render!Element!Textarea.php/class/Textarea",
 *   label = @Translation("Textarea custom"),
 *   description = @Translation("Custom."),
 *   category = @Translation("Basic elements"),
 *   multiline = TRUE,
 * )
 */
class CustomWebformTextareaField extends Textarea {

  /**
   * {@inheritdoc}
   */
  protected function defineDefaultProperties() {
    return [
      'custom_checkbox' => '',
      ] + parent::defineDefaultProperties()
      + $this->defineDefaultMultipleProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['validation']['custom_checkbox']= [
      '#type' => 'checkbox',
      '#name' => 'Custom Checkbox',
      '#title' => $this->t('Mina olen checkbox'),
    ];


    return $form;
  }

}
