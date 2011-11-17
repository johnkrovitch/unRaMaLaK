<?php

/**
 * Cell_Type form base class.
 *
 * @method Cell_Type getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCell_TypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'background_image' => new sfWidgetFormInputText(),
      'id_type_family'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cell_Type_Family'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorPass(),
      'background_image' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'id_type_family'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cell_Type_Family'))),
    ));

    $this->widgetSchema->setNameFormat('cell_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cell_Type';
  }

}
