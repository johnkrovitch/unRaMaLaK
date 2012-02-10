<?php

/**
 * CellTypeFamily form.
 *
 * @package    unramalak
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CellTypeFamilyForm extends BaseCellTypeFamilyForm
{
  public function configure()
  {
    $this->setWidget('background_image', new sfWidgetFormInputFile());
  }
}
