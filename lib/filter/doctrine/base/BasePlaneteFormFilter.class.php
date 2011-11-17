<?php

/**
 * Planete filter form base class.
 *
 * @package    unramalak
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlaneteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'principal'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'taille'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'poids'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'atmosphere'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'climat'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'temperature' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_user'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'principal'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'taille'      => new sfValidatorPass(array('required' => false)),
      'poids'       => new sfValidatorPass(array('required' => false)),
      'atmosphere'  => new sfValidatorPass(array('required' => false)),
      'climat'      => new sfValidatorPass(array('required' => false)),
      'temperature' => new sfValidatorPass(array('required' => false)),
      'id_user'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('planete_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Planete';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'principal'   => 'Number',
      'taille'      => 'Text',
      'poids'       => 'Text',
      'atmosphere'  => 'Text',
      'climat'      => 'Text',
      'temperature' => 'Text',
      'id_user'     => 'Number',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
