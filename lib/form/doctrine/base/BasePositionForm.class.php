<?php

/**
 * Position form base class.
 *
 * @method Position getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePositionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'position_x' => new sfWidgetFormInputText(),
      'position_y' => new sfWidgetFormInputText(),
      'id_map'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'position_x' => new sfValidatorInteger(),
      'position_y' => new sfValidatorInteger(),
      'id_map'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_map')), 'empty_value' => $this->getObject()->get('id_map'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('position[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Position';
  }

}
