<?php

/**
 * PermissionsTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BasePermissionsTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'link_id'      => new sfWidgetFormPropelChoice(array('model' => 'LinksTable', 'add_empty' => false)),
      'gid'          => new sfWidgetFormInput(),
      'mode'         => new sfWidgetFormInput(),
      'change_at'    => new sfWidgetFormDateTime(),
      'change_login' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'PermissionsTable', 'column' => 'id', 'required' => false)),
      'link_id'      => new sfValidatorPropelChoice(array('model' => 'LinksTable', 'column' => 'id')),
      'gid'          => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'mode'         => new sfValidatorString(),
      'change_at'    => new sfValidatorDateTime(),
      'change_login' => new sfValidatorString(array('max_length' => 25)),
    ));

    $this->widgetSchema->setNameFormat('permissions_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PermissionsTable';
  }


}
