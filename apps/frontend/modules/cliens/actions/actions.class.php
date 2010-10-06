<?php

/**
 * cliens actions.
 *
 * @package    usic
 * @subpackage cliens
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class cliensActions extends BasesfPHPOpenIDAuthActions	//which extends sfActions
{
	private $caller = null;
	public function __construct($context, $moduleName, $actionName)
	{
		parent::__construct($context, $moduleName, $actionName);
		$this->caller = new ScriptCaller();
	}
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if (!$this->getUser()->hasCredential('all'))
	$this->getUser()->addCredential('all');
    return sfView::SUCCESS;
  }

	/* should be called after successful login of user */
	private function authenticate($login)
	{
		$this->getUser()->setAuthenticated(true);
		$this->getUser()->setAttribute('login',$login);

		$gids = PermissionsTablePeer::getGids();
		foreach ($gids as $gid) 
		{
			$script = $this->caller->callScript('gm/checkUser',array('login' => $login, 'name' => $gid));
			if (!is_string($script))
			    $this->getUser()->addCredential($gid);
		}
		
		/* check if this is the administrator for site */
		if ( !is_string( $script = $this->caller->callScript('gm/checkUser',array('login' => $login, 'name' => 'www')) ) ) 
		    $this->getUser()->setAttribute('www', 'true');
		
		$this->getUser()->setGroup();
	}

	/* simple authentication */
	public function executeAuth(sfWebRequest $request)
	{
		if ($request->isMethod('post'))	{
			$args = array();
			$args['login'] = $request->getParameter('login');
			$args['password'] = $request->getParameter('password');

			$script = $this->caller->callScript('auth',$args);
			if ( is_string($script) ) {
				$this->getUser()->setFlash('status_bar',$script);
				$this->redirect($this->getModuleName().'/'.$this->getActionName());
			}
			$this->authenticate($args['login']);
			$this->redirect('@homepage');
		}
		return sfView::SUCCESS;
	}
	public function executeLogout(sfWebRequest $request)
	{
		$this->getUser()->clearCredentials();
		$this->getUser()->setAttribute('login', null);
		$this->getUser()->setAttribute('www', null);
		$this->getUser()->setAttribute('group', 'all');
		$this->getuser()->setAuthenticated(false);
		$this->getUser()->shutdown();
		$this->getUser()->setFlash('status_bar','You are logged out');
		$this->redirect('@homepage');
	}
	
/* openid functions */

	/* openid authentication */
	public function executeLogin(sfWebRequest $request)
	{
		if (!$this->getRequest()->isMethod('post')) {
			error_reporting(E_ALL & ~E_NOTICE);	//chg php.ini: allow_call_time_pass_reference = on
			return sfView::SUCCESS;
			
		} else {
			$identity = $request->getParameter('identity');
			error_reporting(E_ALL);
			$result = $this->getRedirectHtml($identity);
			if ($result['success']) $this->html = $result['htmlCode'];
			else $this->html = $result['error'];
			return 'Afterwards';
		}
	}
	public function executeOpenidError() {echo 'error!';
		$this->error = $this->getRequest()->getErrors();
	}
	public function openIDCallback($openid_validation_result)
	{
		// TODO check for other openid providers
  		$this->authenticate(substr($openid_validation_result['identity'],0,strstr($openid_validation_result['identity'],'.')));
  		sfContext::getInstance()->getResponse()->setCookie('known_openid_identity',$openid_validation_result['identity']);
  		$back = '@homepage';
  		$this->redirect($back);
	}
}
