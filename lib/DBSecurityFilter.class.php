<?php

class DBSecurityFilter extends sfBasicSecurityFilter
{
	protected function getUserCredentials()
	{
		$c = new Criteria();
		$c->add(LinksTablePeer::ACTION_NAME,$this->context->getActionName());
		$c->add(LinksTablePeer::MODULE_NAME,$this->context->getModuleName());
		$link = LinksTablePeer::doSelectOne($c);
//		if (! @($link->getId()) ) 
//			$this->forwardToSecureAction();
		$gids = PermissionsTablePeer::getGidsForLink($link->getId());
		return $gids;
	}
	public function execute($filterChain)
	{
		// disable security on login and secure actions
		if (
		  (sfConfig::get('sf_login_module') == $this->context->getModuleName()) && (sfConfig::get('sf_login_action') == $this->context->getActionName())
		  ||
		  (sfConfig::get('sf_secure_module') == $this->context->getModuleName()) && (sfConfig::get('sf_secure_action') == $this->context->getActionName())
		  )
		{
		    $filterChain->execute();
		    return;
		}
		
		// NOTE: the nice thing about the Action class is that getCredential()
		//       is vague enough to describe any level of security and can be
		//       used to retrieve such data and should never have to be altered
		if (!$this->context->getUser()->isAuthenticated())
		{
		  // the user is not authenticated
		  $this->forwardToLoginAction();
		}
		
		// the user is authenticated
		$credentials = $this->getUserCredentials();
		//var_dump($credentials);var_dump($this->context->getUser()->listCredentials());
		foreach($credentials as $credential)
		{
		    // checking for administrators
		    if ($credential == 'www')
			if ( $this->context->getUser()->getAttribute('www') ) {
			    // o, it's the admin!
			    $filterChain->execute();
			    return;
			} else break;	// you can't argue with 'www' :(

		    if (!is_null($credential) && $this->context->getUser()->hasCredential($credential))
		    {
    			// the user has access, continue
			$filterChain->execute(); return;
		    }
		}
		    // the user doesn't have access
		    $this->forwardToSecureAction(); return;

	}
	
}
