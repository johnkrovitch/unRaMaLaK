<?php

/**
 * Planete form base class.
 *
 * @method Planete getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlaneteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'principal'   => new sfWidgetFormInputText(),
      'taille'      => new sfWidgetFormInputText(),
      'poids'       => new sfWidgetFormInputText(),
      'atmosphere'  => new sfWidgetFormInputText(),
      'climat'      => new sfWidgetFormInputText(),
      'temperature' => new sfWidgetFormInputText(),
      'id_user'     => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 45)),
      'principal'   => new sfValidatorInteger(),
      'taille'      => new sfValidatorString(array('max_length' => 45)),
      'poids'       => new sfValidatorString(array('max_length' => 45)),
      'atmosphere'  => new sfValidatorString(array('max_length' => 45)),
      'climat'      => new sfValidatorString(array('max_length' => 45)),
      'temperature' => new sfValidatorString(array('max_length' => 45)),
      'id_user'     => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('planete[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Planete';
  }

}
