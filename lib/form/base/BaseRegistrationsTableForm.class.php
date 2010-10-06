<?php

/**
 * RegistrationsTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseRegistrationsTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'daytime'          => new sfWidgetFormDateTime(),
      'staff_login'      => new sfWidgetFormInput(),
      'registered_login' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'daytime'          => new sfValidatorDateTime(),
      'staff_login'      => new sfValidatorString(array('max_length' => 25)),
      'registered_login' => new sfValidatorPropelChoice(array('model' => 'RegistrationsTable', 'column' => 'registered_login', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registrations_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrationsTable';
  }


}
