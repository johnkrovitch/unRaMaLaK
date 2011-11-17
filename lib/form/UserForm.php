<?php

class PlayerForm extends sfForm
{
  public function configure()
  {    
    $max_size = sfConfig::get('app_global_config_input_max_length');
    $this->widgetSchema->setNameFormat('Player[%s]');
    
    // custom widgets
    $this->setWidget('login', new sfWidgetFormInput(array(), array('maxlength' => $max_size)));
    $this->setWidget('password', new sfWidgetFormInputPassword());
    $this->setWidget('confirm_password', new sfWidgetFormInputPassword());
    $this->setWidget('email', new sfWidgetFormInput(array(), array('maxlength' => $max_size)));
    $this->setWidget('first_name', new sfWidgetFormInput(array(), array('maxlength' => $max_size)));
    $this->setWidget('last_name', new sfWidgetFormInput(array(), array('maxlength' => $max_size)));
    $this->setWidget('birthday', new sfWidgetFormDateText($this->getConfigForI18NDate()));    

    // validators
    $this->setValidator('login', new sfValidatorString(array('required' => true, 'max_length' => $max_size)));
    $this->setValidator('password', new sfValidatorString(array('required' => true, 'max_length' => $max_size)));
    $this->setValidator('confirm_password', new sfValidatorString(array('required' => true, 'max_length' => $max_size)));
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'confirm_password', array('required' => true)));    
    $this->setValidator('email', new sfValidatorEmail(array('required' => true)));
    $this->setValidator('first_name', new sfValidatorString(array('required' => true, 'max_length' => true)));
    $this->setValidator('last_name', new sfValidatorString(array('required' => true, 'max_length' => true)));
    $this->setValidator('birthday', new sfValidatorDate());    
  }
  
  private function getConfigForI18NDate()
  {
    for($i = 1900; $i<2010; $i++)
    {
      $years[$i] = $i;
    }
    return array('config' => '{ yearRange: \'1900:2009\',changeYear: true, changeMonth: true }',
                 'culture' => 'fr',
                 'date_format' => 'dd/mm/yy');
  }
  
  public function save($con = null)
  {
    $datas = $this->getValues();
    // user
    $user = new sfGuardUser();
    $user-> setUserName($datas['login']);
    $user->setPassword($datas['password']);
    $user->setEmailAddress($datas['email']);
    $user->setFirstName($datas['first_name']);
    $user->setLastName($datas['last_name']);
    $user->setIsActive(true);
    // profile
    $profile = new sfGuardUserProfile();
    $profile->setBirthday($datas['birthday']);
    $user->setProfile($profile);
    
    $user->save();
  }
}