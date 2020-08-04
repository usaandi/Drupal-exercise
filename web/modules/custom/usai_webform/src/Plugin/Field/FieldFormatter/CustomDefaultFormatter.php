<?php

namespace Drupal\usai_webform\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "Random_default",
 *   label = @Translation("Random text"),
 *   field_types = {
 *     "Random",
 *     "string",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class CustomDefaultFormatter extends FormatterBase {


  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the random string.');
    return $summary;
  }


  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $el = join('-', str_split($item->value));

      $element[$delta] = ['#markup' => $el];
    }

    return $element;
  }
}