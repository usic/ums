<?php

/**
 * NightloadTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseNightloadTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'user'     => new sfWidgetFormInput(),
      'begin'    => new sfWidgetFormDateTime(),
      'finish'   => new sfWidgetFormDateTime(),
      'state'    => new sfWidgetFormInput(),
      'url'      => new sfWidgetFormTextarea(),
      'protocol' => new sfWidgetFormInput(),
      'path'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'NightloadTable', 'column' => 'id', 'required' => false)),
      'user'     => new sfValidatorString(array('max_length' => 25)),
      'begin'    => new sfValidatorDateTime(),
      'finish'   => new sfValidatorDateTime(),
      'state'    => new sfValidatorString(array('max_length' => 15)),
      'url'      => new sfValidatorString(),
      'protocol' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'path'     => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('nightload_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NightloadTable';
  }


}
