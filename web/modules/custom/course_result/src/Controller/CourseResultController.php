<?php

namespace Drupal\course_result\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\user\Entity\User;
use Drupal\views\Views;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CourseResultController extends ControllerBase {

  /**
   * @return array
   */
  public function content() : array {
    $form = \Drupal::formBuilder()->getForm('Drupal\course_result\Form\CourseResultForm');

    $build = [
      'form' => $form,
      'view' => Views::getView('course_result')->render('result'),
    ];

    return $build;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function handleAutoComplete(Request $request) : JsonResponse {
    $results = [];
    $input = $request->query->get('q');

    if (!$input) {
      return new JsonResponse($results);
    }
    $input = Xss::filter($input);

    $ids = \Drupal::entityQuery('user')
      ->condition('status', 1)
      ->condition('mail', "%". $input . "%", 'LIKE')
      ->execute();

    $users = $ids ? User::loadMultiple($ids) : [];

    foreach ($users as $user){
      $label = [
        $user->getDisplayName(),
        '<small>('. $user->get('mail')->value . ')</small>',
      ];

      $results[] = [
        'value' => EntityAutocomplete::getEntityLabels([$user]),
        'label' => implode(' ', $label),
      ];
    }
    return new JsonResponse($results);
  }
}