<?php

/**
 * Heros form base class.
 *
 * @method Heros getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHerosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'level'         => new sfWidgetFormInputText(),
      'xp'            => new sfWidgetFormInputText(),
      'xp_next_level' => new sfWidgetFormInputText(),
      'id_user'       => new sfWidgetFormInputText(),
      'position_x'    => new sfWidgetFormInputText(),
      'position_y'    => new sfWidgetFormInputText(),
      'id_map'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Map'), 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 100)),
      'level'         => new sfValidatorInteger(array('required' => false)),
      'xp'            => new sfValidatorInteger(array('required' => false)),
      'xp_next_level' => new sfValidatorInteger(),
      'id_user'       => new sfValidatorInteger(),
      'position_x'    => new sfValidatorInteger(array('required' => false)),
      'position_y'    => new sfValidatorInteger(array('required' => false)),
      'id_map'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Map'))),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('heros[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Heros';
  }

}
