<?php

namespace Drupal\course_result;

use Drupal\views\EntityViewsData;

/**
 * Provides the views data for the entity.
 */
class CourseResultViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['course_result']['course_result_difference'] = [
      'title' => t('Course result difference'),
      'help' => t('Calculates course result difference'),
      'real field' => 'id',
      'field' => [
        'id' => 'calculate_views_field',
      ],
      'sort' => [
        'id' => 'calculate_views_sort',
      ],
    ];
    return $data;
  }
}