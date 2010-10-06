<?php 

class ScriptCaller
{
// um/edit - ??
	static public $directory = '/opt/usic/bin/';
	static public $scripts = array(
	    'auth' => 'usiccheckpasswd', 
	    'um/add' => 'usic_useradd', 
	    'um/find' => 'usic_userinfo', 
	    'um/delete' => 'usic_userdel', 
	    'um/activate' => 'activateAccount', 
	    'um/agreement' => 'usicagreement', 
	    'um/edit' => 'usic_usermod', 
	    'gm/add' => 'usicgroup_add', 
	    'gm/addUser' => 'usicgroup_addUser', 
	    'gm/checkUser' => 'usicgroup_checkUser', 
	    'gm/show' => 'usicgroup_show', 
	    'gm/showUser' => 'usicgroup_show', 
	    'gm/remove' => 'usicgroup_remove', 
	    'gm/removeUser' => 'usicgroup_remove');
	    
	    
	protected $type = null;
/*	public function __construct($type)
	{
		if ( !array_key_exists($type,self::$scripts) )
			throw Exception('You know such a script? i don\'t');
		$this->type = self::$scripts[$type];
	}*/
	public function callScript($type, $arg=null)
	{
		if ( !array_key_exists($type,self::$scripts) )
			throw Exception('You know such a script? i don\'t');
		$this->type = self::$scripts[$type];

		return $this->{$this->type}($arg);
	}
	protected function usiccheckpasswd($arg)
	{
		$command = "echo -e \"".$arg["password"]."\\n\" | ".self::$directory."usiccheckpasswd ".$arg["login"];
		exec($command, $values, $result);
		return $this->processAuthErrors($result);
	}
	protected function processAuthErrors($error)
	{
		switch ($error) 
		{
			case 0:
			case 1:
			case 2:
				sfContext::getInstance()->getLogger()->info($this->type.' called with return code '.$error.' '.$this->authErrors[$error]);
				return $this->authErrors[$error];
			case 15:
			case 31:
			case 42:
				sfContext::getInstance()->getLogger()->alert($this->type.' called with return code '.$error.': '.$this->authErrors[$error]);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return $this->authErrors[$error];
			default:
				sfContext::getInstance()->getLogger()->emerg($this->type.' called with return code '.$error);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return 'wtf';
		}
	}
	protected function usic_useradd($arg)
	{
		$values = array();
		$result = 0;
		$command = "echo -e \"login=".$arg['login']."\\n name=".$arg['surname']." ".$arg['name']." ".$arg['middle_name'].
		"\\n password=".$arg['password']."\\n entry_year=".$arg['entering_year']."\\n profession=".$arg['profession'].
		"\\n class=".$arg['status'].
        	"\\n reader_card_number=".$arg['reader_card'].
		"\\n student_card_number=".$arg['student_card'].
		"\\n passport_number=".$arg['passport'].
        	"\\n\" | ".self::$directory."usic_useradd";
//		print_r($command);
		exec($command, $values, $result);
// 		$this->doHistory('registrate',$command,$result);	// for 'do not display password, idiot!' :)
		$this->doHistory('registrate',"echo -e \"login=".$arg['login']." ... \" | ..usic_useradd",$result);
		$return = $this->processUserErrors($result);
		return $return;
	}

	protected function usic_usermod($arg)
	{
		$values = array();
		$result = 0;
		$command = "echo -e \"login=".$arg['login'];
		if (!is_null($arg['surname'])) $command .= "\\n name=".$arg['surname']." ".$arg['name']." ".$arg['middle_name'];
		if (!is_null($arg['password'])) $command .= "\\n password=".$arg['password'];
		if (!is_null($arg['entering_year'])) $command .= "\\n entry_year=".$arg['entering_year'];
		if (!is_null($arg['profession'])) $command .= "\\n profession=".$arg['profession'];
		if (!is_null($arg['status'])) $command .= "\\n class=".$arg['status'];
		/* XXX: temporary fix : we are not editing cards and passport */
//        	"\\n reader_card_number=".$arg['reader_card'].
//		"\\n student_card_number=".$arg['student_card'].
//		"\\n passport_number=".$arg['passport'].
        	$command .= "\" | ".self::$directory."usic_usermod";
		exec($command, $values, $result);
		$this->doHistory('modify account',"echo -e \"login=".$arg['login']." ... \" | ..usic_usermod",$result);
		$return = $this->processUserErrors($result);
		return $return;
	}
	
	protected function usic_userinfo ($args) 
	{
		$values = array();
		$result = 0;
		$command = "echo -e \"login=".$args['login']."\\n values=".
		(is_null($args['values']) ? implode(",", array_keys(self::$ldapFields)) : implode(',', $args['values']))
		."\" | ".self::$directory."usic_userinfo";
		exec($command, $values, $result);
//		print_r($values);
		sfContext::getInstance()->getLogger()->info($this->type.' called as '.$command);
		$return = $this->processUserErrors($result);
		if (is_null($return))
			return $this->constructUserArray($values);
		return $return;
	}

	protected function usic_userdel($args)
	{
		$values = array();
		$result = 0;
		$command = "echo ".$args['login']." | ".self::$directory."usic_userdel";
		exec($command, $values, $result);
		$this->doHistory('delete account',$command,$result);
		$return = $this->processUserErrors($result);
		return $return;
	}

	protected function processUserErrors($error)
	{
		switch ($error) 
		{
			case 0:
			case 32:
			case 33:
			case 34:
			case 35:
			case 36:
				sfContext::getInstance()->getLogger()->info($this->type.' called with return code '.$error.' '.$this->userErrors[$error]);
				return $this->userErrors[$error];
			case 11:
			case 15:
			case 21:
			case 22:
			case 23:
			case 31:
				sfContext::getInstance()->getLogger()->alert($this->type.' called with return code '.$error.': '.$this->userErrors[$error]);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return $this->userErrors[$error];
			default:
				sfContext::getInstance()->getLogger()->emerg($this->type.' called with return code '.$error);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return 'wtf';
		}
	}

	protected function activateAccount($args)
	{
		if ( $this->usickey($args)!=0 )
			return 'wrong code number';
		if ($this->usic_useractivate($args)==0)
			return null;
		return 'unsuccessful activation';
	}

	protected function usickey($args)
	{
		exec(self::$directory."usickey ".$args['login']." ".$args['code'], $values, $result);
		return $result;
	}

	protected function usic_useractivate($args)
	{
		$command = self::$directory."usic_useractivate ".$args['login'];
		exec($command, $values, $result);
		$this->doHistory('activate account',$command,$result);
		return $result;
	}

	protected function usic_userdeactivate($args)
	{
		$command = self::$directory."usic_userdeactivate ".$args['login'];
		exec($command, $values, $result);
		$this->doHistory('deactivate account',$command,$result);
		return $result;
	}

	protected function usicagreement($args)
	{
		$command = self::$directory."usicagreement ".$args['uid']." ".$args['login']." ".$args['surname']." ".$args['name']." ".$args['middle_name'];
		exec($command, $values, $result);
		$this->doHistory('print agreement',$command,$result);

		if ($result==0) return null;
		return 'unsuccessful printing';
	}

	protected function usicgroup_add($args)
	{
		$values = array();
		$result = 0;
		$command = self::$directory."usicgroup add ".$args['name'];
		exec($command, $values, $result);
		$this->doHistory('add group',$command,$result);
		return $this->processGroupErrors($result);
	}
	protected function usicgroup_addUser($args)
	{
		$values = array();
		$result = 0;
		$command = self::$directory."usicgroup add ".$args['name']." ".$args['login'];
		exec($command, $values, $result);
		$this->doHistory('add user to group',$command,$result);
		return $this->processGroupErrors($result);
	}
	protected function usicgroup_checkUser($args)
	{
		$values = array();
		$result = 0;
		$command = self::$directory."usicgroup check ".$args['name']." ".$args['login'];
		exec($command, $values, $result);
		return $this->processGroupErrors($result);
	}
	protected function usicgroup_show($args)
	{
		$values = array();
		$result = 0;
		$command = self::$directory."usicgroup show ".$args['name'];
		exec($command, $values, $result);
		$return = $this->processGroupErrors($result);
		if (is_null($return))
			return $values;
		return $return;
	}
	protected function usicgroup_remove($args)
	{
		$values = array();
		$result = 0;
		$command = self::$directory."usicgroup remove ".$args['name']." ".$args['login'];
		exec($command, $values, $result);
		$this->doHistory(is_null($args['login']) ? 'delete group' : 'delete user from group', $command, $result);		
		return $this->processGroupErrors($result);
	}
	protected function processGroupErrors($error)
	{
		switch ($error) 
		{
			case 0:
			case 1:
			case 2:
			case 32:
			case 33:
				sfContext::getInstance()->getLogger()->info($this->type.' called with return code '.$error.': '.$this->groupErrors[$error]);
				return $this->groupErrors[$error];
			case 15:
			case 22:
			case 31:
				sfContext::getInstance()->getLogger()->alert($this->type.' called with return code '.$error.': '.$this->groupErrors[$error]);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return $this->groupErrors[$error];
			default:
				sfContext::getInstance()->getLogger()->emerg($this->type.' called with return code '.$error);
				throw new Exception('system isn\'t working properly, talk with administrator');
				return 'wtf';
		}
	}
	private $authErrors = array ( 1 => 'you have entered not valid password',
				2 => 'you have entered not valid login',
				15 => 'they dumped us',
				31 => 'Calling Elvis, anybody home?',
				42 => 'Goddamit, universal question solved!',
				0 => null );
	private $userErrors = array ( 11 => 'bind with database failed',
			15 => 'LDAP doesn\'t like you',	
			21 => 'your folder can\'t be created',
			22 => 'your present haven\'t been received in a proper way',
			23 => 'your folder can\'t be deleted',
			31 => 'an internal error of the script',
			32 => 'search can\'t find anything for you',
			33 => 'you can\'t be duplicated, even if you want',
			34 => 'your reader card already exists!',
			35 => 'your student card already exists!',
			36 => 'your passport already exists!',
			0 => null );
	private $groupErrors = array ( 1 => 'there is no such user in this group',
			2 => 'nothing to show',
			15 => 'LDAP doesn\'t like you',
			22 => 'script doesn\'t know such parameters',
			31 => 'script has its own problems',
			32 => 'there is no such group',
			33 => 'such group already exists',
			0 => null );

	static private $ldapFields = array('login' => 'login',
    	    'name' => 'name',
	    'uid' => 'uid',
	    'gid' => 'gid',
	    'profession' => 'profession',
	    'class' => 'status',
	    'loginShell' => 'loginShell',
	    'entry_year' => 'entering_year',
	    'reader_card_number' => 'reader_card',
	    'student_card_number' => 'student_card',
	    'passport_number' => 'passport');
	
	private function constructUserArray($values)
	{
		$arr = array();
		foreach($values as $value) 
		{
			$str = explode("=", $value);
			$arr[self::$ldapFields[$str[0]]] = $str[1];
		}
		if (key_exists('name', $arr))
		{
			$snm = explode(" ", $arr['name']);
			$arr['surname'] = $snm[0];
			$arr['name'] = $snm[1];
			$arr['middle_name'] = $snm[2];
		}
		/* for student card numbers like XX0XXXXXXX script returns the number without zero */
		/* returning to browser the numbers of 10 symbols */
		/* note: only if there is one leading zero (i.e. not less 9 symbols) */
		if (key_exists('student_card', $arr) && preg_match('/^..[0-9]{7}$/u', $arr['student_card']))
		{
			$arr['student_card'] = substr($arr['student_card'], 0, 4) . '0' . substr($arr['student_card'], 4);
		}
		//print_r($arr);
		return $arr;
	}
	private function doHistory($action, $command, $result)
	{
		$entry = new HistoryTable( sfContext::getInstance()->getUser()->getAttribute('login'),
				 sfContext::getInstance()->getUser()->getAttribute('group'), $action, $command, $result);
		$entry->save();
	}
}
