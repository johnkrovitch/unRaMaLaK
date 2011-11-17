<?php

/**
 * Cell_Type filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCell_TypeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'background_image' => new sfWidgetFormFilterInput(),
      'id_type_family'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cell_Type_Family'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'background_image' => new sfValidatorPass(array('required' => false)),
      'id_type_family'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cell_Type_Family'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cell_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cell_Type';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'background_image' => 'Text',
      'id_type_family'   => 'ForeignKey',
    );
  }
}
