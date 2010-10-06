<?php

class UsicGroupForm extends sfForm
{ 

	public function configure()
	{
		$this->setWidgets(array('name' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
				));

		$this->widgetSchema->setNameFormat('group[%s]');
 
		$this->setValidators(array(
                	'name' =>  new sfValidatorRegex(array('required' => true, 'pattern' => "/^[a-z]*[0-9a-z_]*$/"),
						array('invalid'=>'name must contain only small latin, numbers, symbol _ and must start with letter')),
				));
	}

}
?>
