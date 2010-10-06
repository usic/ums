<?php

class UsicUserActivationForm extends sfForm
{
	public function configure()
	{
		$this->setWidgets(array('code' => new sfWidgetFormInput(array(),array('maxlength' => 50)),
					'login' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
				));

		$this->widgetSchema->setNameFormat('activation[%s]');
 
		$this->setValidators(array(
			'code' => new sfValidatorString(array('required' => true, 'trim' => true)),

			'login' => new sfValidatorRegex(array('required' => true, 'pattern' => "/^[a-z][0-9a-z_]*$/"),
						array('invalid'=>'login can contain only small latin, numbers, symbol _ and must start with letter')),
				));
	}

}

?>