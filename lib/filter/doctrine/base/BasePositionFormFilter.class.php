<?php

/**
 * Position filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePositionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'position_x' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'position_y' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'position_x' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position_y' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('position_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Position';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'position_x' => 'Number',
      'position_y' => 'Number',
      'id_map'     => 'Number',
    );
  }
}
