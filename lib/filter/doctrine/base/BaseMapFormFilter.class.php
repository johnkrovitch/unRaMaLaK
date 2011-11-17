<?php

/**
 * Map filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMapFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'height'           => new sfWidgetFormFilterInput(),
      'width'            => new sfWidgetFormFilterInput(),
      'starting_cell_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Starting_Cell'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'height'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'width'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'starting_cell_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Starting_Cell'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('map_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Map';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'height'           => 'Number',
      'width'            => 'Number',
      'starting_cell_id' => 'ForeignKey',
    );
  }
}
