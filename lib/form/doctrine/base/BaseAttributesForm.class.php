<?php

/**
 * Attributes form base class.
 *
 * @method Attributes getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAttributesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'life'         => new sfWidgetFormInputText(),
      'life_max'     => new sfWidgetFormInputText(),
      'mana'         => new sfWidgetFormInputText(),
      'mana_max'     => new sfWidgetFormInputText(),
      'limit_lvl'    => new sfWidgetFormInputText(),
      'limit_max'    => new sfWidgetFormInputText(),
      'strength'     => new sfWidgetFormInputText(),
      'agility'      => new sfWidgetFormInputText(),
      'intelligence' => new sfWidgetFormInputText(),
      'id_heros'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Heros'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'life'         => new sfValidatorInteger(),
      'life_max'     => new sfValidatorInteger(),
      'mana'         => new sfValidatorInteger(),
      'mana_max'     => new sfValidatorInteger(),
      'limit_lvl'    => new sfValidatorInteger(),
      'limit_max'    => new sfValidatorInteger(),
      'strength'     => new sfValidatorInteger(),
      'agility'      => new sfValidatorInteger(),
      'intelligence' => new sfValidatorInteger(),
      'id_heros'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Heros'))),
    ));

    $this->widgetSchema->setNameFormat('attributes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attributes';
  }

}
