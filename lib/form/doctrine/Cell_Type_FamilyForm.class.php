<?php

/**
 * Cell_Type_Family form.
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Cell_Type_FamilyForm extends BaseCell_Type_FamilyForm
{
  public function configure()
  {
    $this->setWidget('background_image', new sfWidgetFormInputFile());
  }
}
