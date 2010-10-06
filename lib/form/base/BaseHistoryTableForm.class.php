<?php

/**
 * HistoryTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseHistoryTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'daytime'     => new sfWidgetFormDateTime(),
      'user'        => new sfWidgetFormInput(),
      'gid'         => new sfWidgetFormInput(),
      'action_id'   => new sfWidgetFormPropelChoice(array('model' => 'ActionsTable', 'add_empty' => false)),
      'arguments'   => new sfWidgetFormTextarea(),
      'return_code' => new sfWidgetFormInput(),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'daytime'     => new sfValidatorDateTime(),
      'user'        => new sfValidatorString(array('max_length' => 25)),
      'gid'         => new sfValidatorString(array('max_length' => 15)),
      'action_id'   => new sfValidatorPropelChoice(array('model' => 'ActionsTable', 'column' => 'id')),
      'arguments'   => new sfValidatorString(array('required' => false)),
      'return_code' => new sfValidatorInteger(array('required' => false)),
      'id'          => new sfValidatorPropelChoice(array('model' => 'HistoryTable', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('history_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HistoryTable';
  }


}
