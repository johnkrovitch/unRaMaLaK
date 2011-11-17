<?php

/**
 * Cell filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCellFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'position_x'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'position_y'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'background_image' => new sfWidgetFormFilterInput(),
      'id_type'          => new sfWidgetFormFilterInput(),
      'id_map'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Map'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'position_x'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position_y'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'background_image' => new sfValidatorPass(array('required' => false)),
      'id_type'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_map'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Map'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cell_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cell';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'position_x'       => 'Number',
      'position_y'       => 'Number',
      'background_image' => 'Text',
      'id_type'          => 'Number',
      'id_map'           => 'ForeignKey',
    );
  }
}
