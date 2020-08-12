<?php

namespace Drupal\course_result\Plugin\Validation\Constraint;

use Drupal\user\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class HasPermissionValidator extends ConstraintValidator {


  /**
   * @param mixed $value
   * @param Constraint $constraint
   */
  public function validate($value, Constraint $constraint) {
    if (!empty($value->getEntity()->course_participant_uid->target_id)) {
      $userId = $value->getEntity()->course_participant_uid->target_id;
      $user = User::load($userId);
      if ($user && !$user->hasPermission('participate in course')) {
        $this->context->addViolation($constraint->hasNoPermission);
      }
    }
  }
}