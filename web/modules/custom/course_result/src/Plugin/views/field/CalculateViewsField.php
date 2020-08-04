<?php

namespace Drupal\course_result\Plugin\views\field;

use Drupal\Component\Utility\Random;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Annotation\ViewsField;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;


/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("calculate_views_field")
 */
class CalculateViewsField extends FieldPluginBase {

  /**
   * {@inheritDoc}
   */
  public function query() {
    $this->ensureMyTable();
    $this->query->addField(null, '(score_a - score_b)', 'difference');
    $this->addAdditionalFields();
  }

  /**
   * {@inheritDoc}
   */
  public function render(ResultRow $values) {
    return $this->options['result_sum'] = $values->difference;
  }
}