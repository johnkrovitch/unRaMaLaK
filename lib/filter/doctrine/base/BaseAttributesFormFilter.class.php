<?php

/**
 * Attributes filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAttributesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'life'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'life_max'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mana'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mana_max'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'limit_lvl'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'limit_max'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'strength'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'agility'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'intelligence' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_heros'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Heros'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'life'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'life_max'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mana'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mana_max'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'limit_lvl'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'limit_max'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'strength'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'agility'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'intelligence' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_heros'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Heros'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('attributes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attributes';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'life'         => 'Number',
      'life_max'     => 'Number',
      'mana'         => 'Number',
      'mana_max'     => 'Number',
      'limit_lvl'    => 'Number',
      'limit_max'    => 'Number',
      'strength'     => 'Number',
      'agility'      => 'Number',
      'intelligence' => 'Number',
      'id_heros'     => 'ForeignKey',
    );
  }
}
