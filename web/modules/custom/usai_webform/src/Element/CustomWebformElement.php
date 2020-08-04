<?php

namespace Drupal\usai_webform\Element;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a 'webform_example_element'.
 *
 * Webform elements are just wrappers around form elements, therefore every
 * webform element must have correspond FormElement.
 *
 * Below is the definition for a custom 'webform_example_element' which just
 * renders a simple text field.
 *
 * @FormElement("webform_usai_text_element")
 *
 */
class CustomWebformElement extends FormElement
{

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);

    return [
      '#pre_render' => [
        [$class, 'preRenderWebformTextfield'],
      ],
      '#input' => TRUE,
      '#size' => 61,
      '#theme' => 'usai_webform__textfield',
      '#theme_wrappers' => ['form_element'],
    ];
  }

  public static function preRenderWebformTextfield(array $element) {

        Element::setAttributes($element, ['id', 'name', 'value', 'size', 'maxlength', 'placeholder']);
        static::setAttributes($element, ['form-text', 'webform-example-element']);
    return $element;
  }

}
