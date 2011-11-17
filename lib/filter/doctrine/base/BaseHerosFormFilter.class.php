<?php

/**
 * Heros filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHerosFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'level'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'xp'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'xp_next_level' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_user'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'position_x'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'position_y'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_map'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Map'), 'add_empty' => true)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'level'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'xp'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'xp_next_level' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_user'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position_x'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position_y'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_map'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Map'), 'column' => 'id')),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('heros_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Heros';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'level'         => 'Number',
      'xp'            => 'Number',
      'xp_next_level' => 'Number',
      'id_user'       => 'Number',
      'position_x'    => 'Number',
      'position_y'    => 'Number',
      'id_map'        => 'ForeignKey',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
