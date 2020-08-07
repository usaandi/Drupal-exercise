<?php

namespace Drupal\course_result\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Requires a field to have a value when the entity is published.
 *
 * @Constraint(
 *   id = "HasPermission",
 *   label = @Translation("Just work"),
 *   type = {"entity"}
 * )
 */
class HasPermission extends Constraint {

  // The message that will be shown if the value does not have permission.
  public $hasNoPermission = 'User  does not have required permission %permission';

  public $needsValue = '%field-name field cannot be empty at the time of publication.';

}