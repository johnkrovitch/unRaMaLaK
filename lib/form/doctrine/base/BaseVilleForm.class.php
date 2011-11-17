<?php

/**
 * Ville form base class.
 *
 * @method Ville getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVilleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'capital'    => new sfWidgetFormInputText(),
      'taille'     => new sfWidgetFormInputText(),
      'id_planete' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Planete'), 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 45)),
      'capital'    => new sfValidatorInteger(),
      'taille'     => new sfValidatorString(array('max_length' => 45)),
      'id_planete' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Planete'))),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ville[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ville';
  }

}
