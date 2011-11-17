<?php

/**
 * Map form base class.
 *
 * @method Map getObject() Returns the current form's model object
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMapForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'height'           => new sfWidgetFormInputText(),
      'width'            => new sfWidgetFormInputText(),
      'starting_cell_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Starting_Cell'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'height'           => new sfValidatorInteger(array('required' => false)),
      'width'            => new sfValidatorInteger(array('required' => false)),
      'starting_cell_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Starting_Cell'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Map', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('map[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Map';
  }

}
