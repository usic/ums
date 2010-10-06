<?php

/**
 * PrintingsTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BasePrintingsTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'user'    => new sfWidgetFormInput(),
      'daytime' => new sfWidgetFormDateTime(),
      'cost'    => new sfWidgetFormInput(),
      'pages'   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'PrintingsTable', 'column' => 'id', 'required' => false)),
      'user'    => new sfValidatorString(array('max_length' => 25)),
      'daytime' => new sfValidatorDateTime(),
      'cost'    => new sfValidatorInteger(array('required' => false)),
      'pages'   => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('printings_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrintingsTable';
  }


}
