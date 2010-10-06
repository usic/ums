<?php

class myUser extends sfBasicSecurityUser
{
	/* default is null */
	static $groupPrecedence = array('www','staff','users');

	/* chooses from credentials and sets attribute */
	public function setGroup()
	{
		$value = 'all';
		$credentials = $this->listCredentials();
		foreach (self::$groupPrecedence as $group)
		{
			if (in_array($group, $credentials)) $value = $group;
		}
		$this->setAttribute('group', $value);
	}
}
