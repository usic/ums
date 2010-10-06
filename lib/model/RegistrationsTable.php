<?php

class RegistrationsTable extends BaseRegistrationsTable
{
	public function __construct($reg_login="",$staff_login="")
	{
		parent::__construct();
		if (!is_null($reg_login))
		    $this->setRegisteredLogin($reg_login);
		if (!is_null($staff_login))
    		    $this->setStaffLogin($staff_login);
	}
}
