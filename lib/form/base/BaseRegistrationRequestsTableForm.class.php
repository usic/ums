<?php

/**
 * RegistrationRequestsTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseRegistrationRequestsTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormTextarea(),
      'daytime'      => new sfWidgetFormDateTime(),
      'datalocation' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'RegistrationRequestsTable', 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(),
      'daytime'      => new sfValidatorDateTime(),
      'datalocation' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('registration_requests_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegistrationRequestsTable';
  }


}
