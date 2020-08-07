<?php

namespace Drupal\course_result\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\entity_browser\Plugin\EntityBrowser\WidgetValidation\EntityType;
use Drupal\user\Entity\User;
use Drupal\views\Views;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CourseResultController extends ControllerBase {


  protected $entityFormBuilder;
  protected $entityTypeManager;

  public function __construct(EntityFormBuilder $entityFormBuilder, EntityTypeManager $entityTypeManager) {
    $this->entityFormBuilder = $entityFormBuilder;
    $this->entityTypeManager = $entityTypeManager;

  }

  public static function create(ContainerInterface $container) {
   return new static (
     $container->get('entity.form_builder'),
     $container->get('entity_type.manager')
   );
  }

  /**
   * @return array
   */
  public function content() : array {
    $entity = $this->entityTypeManager->getStorage('course_result')->create();
    $form = $this->entityFormBuilder->getForm($entity, "default");
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