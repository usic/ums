<?php

/**
 * UploadTable form base class.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseUploadTableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user'        => new sfWidgetFormInput(),
      'daytime'     => new sfWidgetFormDateTime(),
      'url'         => new sfWidgetFormTextarea(),
      'filename'    => new sfWidgetFormTextarea(),
      'filesize'    => new sfWidgetFormInput(),
      'state'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'category_id' => new sfWidgetFormPropelChoice(array('model' => 'CategoryTable', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'UploadTable', 'column' => 'id', 'required' => false)),
      'user'        => new sfValidatorString(array('max_length' => 25)),
      'daytime'     => new sfValidatorDateTime(),
      'url'         => new sfValidatorString(),
      'filename'    => new sfValidatorString(),
      'filesize'    => new sfValidatorInteger(),
      'state'       => new sfValidatorString(),
      'description' => new sfValidatorString(array('required' => false)),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'CategoryTable', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('upload_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UploadTable';
  }


}
