<?php

/**
 * LinksTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseLinksTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'module_name' => new sfWidgetFormTextarea(),
      'action_name' => new sfWidgetFormTextarea(),
      'name'        => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'LinksTable', 'column' => 'id', 'required' => false)),
      'module_name' => new sfValidatorString(),
      'action_name' => new sfValidatorString(),
      'name'        => new sfValidatorString(),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('links_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LinksTable';
  }


}
