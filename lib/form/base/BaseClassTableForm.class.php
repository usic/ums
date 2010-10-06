<?php

/**
 * ClassTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseClassTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInput(),
      'faculty'       => new sfWidgetFormInput(),
      'profession_id' => new sfWidgetFormPropelChoice(array('model' => 'ProfessionsTable', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'ClassTable', 'column' => 'id', 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 20)),
      'faculty'       => new sfValidatorString(array('max_length' => 4)),
      'profession_id' => new sfValidatorPropelChoice(array('model' => 'ProfessionsTable', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('class_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ClassTable';
  }


}
