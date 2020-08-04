<?php
namespace Drupal\course_result\Plugin\views\sort;

use Drupal\views\Annotation\ViewsSort;
use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Basic sort handler for dates.
 *
 * This handler enables granularity, which is the ability to make dates
 * equivalent based upon nearness.
 *
 * @ViewsSort("calculate_views_sort")
 */
class CalculateViewsSort extends SortPluginBase {


  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->query->addOrderBy(null, null, $this->options['order'], 'difference');
  }


}