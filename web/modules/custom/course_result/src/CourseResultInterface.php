<?php

namespace Drupal\course_result;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Course result entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup course_result_entity
 */
interface CourseResultInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
