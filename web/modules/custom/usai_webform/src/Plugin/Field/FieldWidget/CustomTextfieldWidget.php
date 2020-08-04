<?php

namespace Drupal\usai_webform\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextfieldWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\text\Plugin\Field\FieldWidget\TextfieldWidget;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Plugin implementation of the 'text_textfield' widget.
 *
 * @FieldWidget(
 *   id = "custom_text_textfield",
 *   label = @Translation("Custom Text field"),
 *   field_types = {
 *     "text",
 *     "string",
 *   },
 * )
 */
class CustomTextfieldWidget extends StringTextfieldWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element += parent::formElement($items, $delta, $element, $form, $form_state);
    $element['example_select'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Select element'),
      '#options' => [
        'Default 1' => $this
          ->t('Default 1'),

        'Default 2' => $this
          ->t('Default 2'),
      ],
    ];
    $element['needs_accommodation'] = [
      '#type' => 'checkbox',
      '#title' => $this
        ->t('Need Special Accommodations?'),
    ];
    $element['accommodation'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'accommodation',
        ],
      ],
      '#states' => [
        'invisible' => [
          'input[name="needs_accommodation"]' => [
            'checked' => FALSE,
          ],
        ],
      ],
    ];
    $element['accommodation']['diet'] = [
      '#type' => 'textfield',
      '#title' => $this
        ->t('Dietary Restrictions'),
    ];
    return $element;
  }

  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $a = 1;

    if (empty($form_state->getUserInput()['field_widget_text'][0]['value']) && 1 == 2){
      $user_input = $form_state->getUserInput();
      $user_input['field_widget_text'][0]['value'] = 'test';
     // $form_state->setValue('field_widget_text','asdasd');
      $form_state->setUserInput($user_input);
    }
    return parent::form($items, $form, $form_state, $get_delta);
  }


  public static function submit($form, FormStateInterface $form_state) {

  }

  public static function setWidgetState(array $parents, $field_name, FormStateInterface $form_state, array $field_state) {

    if (empty($form_state->getValue('field_widget_text')[0]['value'])){

      $select_value = $form_state->getUserInput()['field_widget_text'][0]['example_select'];
      $form_state->setValue('field_widget_text',[['value' => $select_value]]);
    }
    parent::setWidgetState($parents, $field_name, $form_state, $field_state);
  }

}
