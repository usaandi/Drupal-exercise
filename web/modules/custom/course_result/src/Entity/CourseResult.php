<?php

namespace Drupal\course_result\Entity;

use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\course_result\CourseResultInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Course result entity.
 *
 * @ingroup course result
 *
 * @ContentEntityType(
 *   id = "course_result",
 *   label = @Translation("Course result"),
 *   handlers = {
 *    "list_builder" = "Drupal\course_result\Entity\Controller\CourseResultListBuilder",
 *    "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *    "views_data" = "Drupal\course_result\CourseResultViewsData",
 *   },
 *
 *   form = {
 *       "default" = "Drupal\course_result\Form\CourseResultForm",
 *   },
 *   base_table = "course_result",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 * )
 */
class CourseResult extends ContentEntityBase implements CourseResultInterface {

  use EntityChangedTrait;

  const CREATOR_UID = 'creator_uid';

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage, array &$values) {
    parent::preCreate($storage, $values);
    $values += [
      self::CREATOR_UID => \Drupal::currentUser()->id(),
    ];

  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get(self::CREATOR_UID)->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
   $this->set(self::CREATOR_UID,$account->id());
   return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get(self::CREATOR_UID)->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set(self::CREATOR_UID,$uid);
    return $this;
  }

  /**
   * @param EntityTypeInterface $entity_type
   * @return array|FieldDefinitionInterface[]|mixed
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Course result entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Course result entity.'))
      ->setReadOnly(TRUE);

    $fields[self::CREATOR_UID] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Creator ID'))
      ->setDescription(t('Entity creator ID'))
      ->setSetting('target_type', 'user');

    $fields['course_participant_uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('course participant user Id'))
      ->setDescription(t('The course participant user ID reference'))
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'match_limit' => 10,
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->addConstraint('HasPermission');

    $fields['score_a'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Score a'))
      ->setDescription(t('Current score'))->addConstraint('HasPermission')->setPropertyConstraints('value', ['Length' => ['max' => 1]]);;

    $fields['score_b'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Score b'))
      ->setDescription(t('Current score'))->addConstraint('HasPermission')->setPropertyConstraints('value', ['Length' => ['max' => 1]]);;

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the node was last edited.'));

    return $fields;
  }


}