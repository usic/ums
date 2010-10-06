<?php

class UsicUserForm extends sfForm
{ 

/*	public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
	{
		return parent::__construct($defaults, $options, $CSRFSecret);
	}
*/

	public function configure()
	{
		sfWidget::setCharset('UTF-8');
		date(m)>8?$year=date(Y):$year=date(Y)-1;
		$years = range(1997,$year);

		$this->setWidgets(array('surname' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
					'name' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
					'middle_name' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
					'login' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
					'password' => new sfWidgetFormInputPassword(array(), array('maxlength' => 20)),
					'confirm_password' => new sfWidgetFormInputPassword(array(), array('maxlength' => 20)),
					'entering_year'=>new sfWidgetFormChoice(array('choices' => array_combine($years, $years))),
					'status' => new sfWidgetFormPropelChoice(array('model'=> 'ProfessionsTable', 'method'=>'getName')),
					'faculty' => new sfWidgetFormPropelChoice(array('model'=> 'ClassTable', 'method'=>'getFaculty', 'key_method'=>'getFaculty')),
//					custom for id=>profession foreach faculty
					'profession' => new sfWidgetFormChoice(array('choices' => array())),
// 					'profession' => new sfWidgetFormPropelChoice(array('model'=> 'ClassTable', 'method'=>'getName')),
//					select id=>name
					'reader_card' => new sfWidgetFormInput(array(),array('maxlength' => 5)),
					'student_card' => new sfWidgetFormInput(array(),array('maxlength' => 20)),
					'passport' => new sfWidgetFormInput(array(),array('maxlength' => 20))
				));

		$this->widgetSchema->setNameFormat('user[%s]');
 
		$this->setValidators(array(

			'surname' => new sfValidatorRegex(array('required' => true, 'pattern' => "/^[А-ЯІЄЇҐ]([а-яієїґ']+)$/u"),
							array('invalid'=>'surname must contain only Ukranian letters and start with capital')),

                	'name' =>  new sfValidatorRegex(array('required' => true, 'pattern' => "/^[А-ЯІЄЇҐ]([а-яієїґ']+)$/u"),
						array('invalid'=>'name must contain only Ukranian letters and start with capital')),

			'middle_name' => new sfValidatorRegex(array('required' => true, 'pattern' => "/^[А-ЯІЄЇҐ]([а-яієїґ']+)$/u"),
							array('invalid'=>'middle name must contain only Ukranian letters and start with capital')),

			'login' => new sfValidatorRegex(array('required' => true, 'pattern' => "/^[a-z][0-9a-z_]*$/"),
						array('invalid'=>'login can contain only small latin, numbers, symbol _ and must start with letter')),

			'password' => new sfValidatorRegex(array('required' => true, 'pattern' => "/[a-z0-9\\-=;',.{}\/]/i"),
							array('invalid' => 'password must not be empty or contain cyrillic symbols')),

			'confirm_password' => new sfValidatorRegex(array('required' => true, 'pattern' => "/[a-z0-9\\-=;',.{}\/]/i"),
							array('invalid' => '')),

			'entering_year' => new sfValidatorChoice(array('required'=>true,'choices'=>$years)),

			'status' => new sfValidatorPropelChoice(array('model'=>'ProfessionsTable')),

			'faculty' => new sfValidatorPropelChoice(array('model'=>'ClassTable', 'column'=>'faculty')),

			'profession' => new sfValidatorPropelChoice(array('model'=>'ClassTable')),

			'reader_card' => new sfValidatorRegex(array('required' => false, 'pattern' => "/^[0-9]{5,5}$/"),
							array('invalid'=>'reader card must contain 5 numbers')),

			'student_card' => new sfValidatorRegex(array('required' => false, 'pattern' => "/^[А-ЯІЄЇҐ]{2}([0-9]{8})$/u"),
								array('invalid'=>'student card must contain 2 capital ukranian letters and >=8 numbers')),

			'passport' => new sfValidatorString(array('required' => false, 'trim' => true, 'min_length'=>5),
									array('min_length' => '%value% should be at least %min_length% characters')),
				));

		$this->mergePostValidator( new sfValidatorSchemaCompare('confirm_password', '==', 'password'), array('throw_global_error' => false),
					array('invalid' => 'Your passwords don\'t match') );
		$this->mergePostValidator( new sfValidatorCallback( array('callback' => array($this,'admitAdding')) ) );
	}

	public function admitAdding($validator, $values)
	{
		$fields = ProfessionsTablePeer::getAddingFields($values['status']);
		foreach($fields as $key=>$field)
		{
			if (!empty($values[$field])) 
				return $values;
		}
		$ve = new sfValidatorError($validator,$fields['error']);
		throw new sfValidatorErrorSchema($validator, array('status' => $ve));
// 		throw new sfValidatorError($validator,$fields['error']);
	}
	// not used
	public function validForFind($fields)
	{
		if ($this->isBound())
		{
			foreach ($fields as $field)
			{
				if (!$this->getErrorSchema()->offsetExists($field)) {
					return true;
				}
			}
		} 
		else return false;
	}
	public static $findFields = array('login');

	public static function createPasswordForm()
	{
		$userForm = new UsicUserForm(); 
		$passForm = new sfForm();
		$passForm->setWidgetSchema(new sfWidgetFormSchema(array('password'=>$userForm->getWidget('password'), 
				'confirm_password' => $userForm->getWidget('confirm_password'))) );
//?		$passForm->setValidatorSchema(new sfValidatorSchema(array($userForm->getValidator('password'), $userForm->getValidator('confirm_password'))) );
		$passForm->setValidator('password', new sfValidatorRegex(array('required' => true, 'pattern' => "/[a-z0-9\\-=;',.{}\/]/i"),
							array('invalid' => 'password must not be empty or contain cyrillic symbols')));
		$passForm->setValidator('confirm_password', new sfValidatorRegex(array('required' => true, 'pattern' => "/[a-z0-9\\-=;',.{}\/]/i"),
							array('invalid' => '')));
		$passForm->getWidgetSchema()->setNameFormat('pass[%s]');
		$passForm->mergePostValidator( new sfValidatorSchemaCompare('confirm_password', '==', 'password'), array('throw_global_error' => false),
					array('invalid' => 'Your passwords don\'t match') );		
		return $passForm;
	}
	
	public function isNew() 
	{
	    return $this->isNew;
	}
	public function setNewFalse()
	{
	    $this->isNew = 0;
	    $this->validatorSchema['password']->setOption('required', false);
	    $this->validatorSchema['confirm_password']->setOption('required', false);
	    if (isset($this->defaults['profession']))
	    {
		$this->setProfession($this->defaults['profession']);
	    }
	}
	
	public function setProfession($def)
	{
		$this_prof = ClassTablePeer::retrieveByPk($def);
		$this->setDefault('faculty', $this_prof->getFaculty());
		$c = new Criteria();
		$c->add(ClassTablePeer::FACULTY, $this_prof->getFaculty());
		$pr = ClassTablePeer::doSelect($c);
		$professions = array();
		foreach ($pr as $p)
		{
		    $professions[$p->getId()] = $p->getName();
		}
		$this->widgetSchema['profession']->addOption('choices', $professions);
		$this->setDefault('profession', $this_prof->getId() );
	}
	
	protected $isNew = 1;
}
