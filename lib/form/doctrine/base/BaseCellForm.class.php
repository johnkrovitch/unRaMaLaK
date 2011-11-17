<?php

/**
 * Cell form base class.
 *
 * @method Cell getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCellForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'position_x'       => new sfWidgetFormInputText(),
      'position_y'       => new sfWidgetFormInputText(),
      'background_image' => new sfWidgetFormInputText(),
      'id_type'          => new sfWidgetFormInputText(),
      'id_map'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Map'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'position_x'       => new sfValidatorInteger(),
      'position_y'       => new sfValidatorInteger(),
      'background_image' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'id_type'          => new sfValidatorInteger(array('required' => false)),
      'id_map'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Map'))),
    ));

    $this->widgetSchema->setNameFormat('cell[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cell';
  }

}
