<?php 

	function usic_usermod($arg)
	{
		$values = array();
		$result = 0;
		$command = "echo -e \"login=".$arg['login'];
		if (!is_null($arg['surname'])) $command .= "\\n name=".$arg['surname']." ".$arg['name']." ".$arg['middle_name'];
		if (!is_null($arg['password'])) $command .= "\\n password=".$arg['password'];
		if (!is_null($arg['entering_year'])) $command .= "\\n entry_year=".$arg['entering_year'];
		if (!is_null($arg['profession'])) $command .= "\\n profession=".$arg['profession'];
		if (!is_null($arg['status'])) $command .= "\\n class=".$arg['status'];
        	if (!is_null($arg['reader_card'])) $command .= "\\n reader_card_number=".$arg['reader_card'];
		if (!is_null($arg['student_card'])) $command .= "\\n student_card_number=".$arg['student_card'];
		if (!is_null($arg['passport'])) $command .= "\\n passport_number=".$arg['passport'];
        	$command .= "\\n\" | /opt/usic/bin/usic_usermod"; 
		echo $command;
		//return $command;
		exec($command, $values, $result);
		$return = processUserErrors($result);
		return $return;
	}
	
	function processUserErrors($error)
	{
		switch ($error) 
		{
			case 0:
			case 32:
			case 33:
			case 34:
			case 35:
			case 36:
			case 11:
			case 15:
			case 21:
			case 22:
			case 23:
			case 31:
				return $userErrors[$error];
			default:
				return 'wtf';
		}
	}

	$userErrors = array ( 11 => 'bind with database failed',
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
			0 => 'everything is ok' );
$args = array(
	'login' => 'naskrina', 'student_card' => 'КВ06968382' );


echo usic_usermod($args);
