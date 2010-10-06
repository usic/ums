<?php

/**
 * um actions.
 *
 * @package    usic
 * @subpackage um
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class umActions extends sfActions
{
	private $caller = null;
	public function __construct($context, $moduleName, $actionName)
	{
		parent::__construct($context, $moduleName, $actionName);
		$this->caller = new ScriptCaller();
	}
	
	private $message = 'The last step for registration: talk to somebody from usic staff members (and don\'t forget your documents like cards and/or passports:) )';
	private function requestGranted()
	{
		$file = sfConfig::get('sf_registration_requests_dir') . sha1($this->form->getValue('login'));echo $file;
		if (file_exists($file))
		{
			$this->getUser()->setFlash('status_bar','You have already requested for registration. Now talk to usic staff members');
			return false;
		}
		if ( file_put_contents($file, serialize($this->form)) == FALSE )
		{
			sfContext::getInstance()->getLogger()->emerg('couldn\'t create file with registration request');		
			return false;
		}
		$request = new RegistrationRequestsTable($this->form->getValue('login'), $file);
		$request->save();
		return true;
	}
	public function executeRemoveRequest(sfWebRequest $request)
	{
		$this->forward404Unless($data = RegistrationRequestsTablePeer::retrieveByPK($request->getParameter('id')));
		$this->redirectUnless ($this->removeRequestImpl($data), '@homepage', 500);
		$this->redirect('@homepage');
	}
	
	private function removeRequestImpl(RegistrationRequestsTable $request)
	{
		$file = $request->getDataLocation();
		$name = $request->getName();
		$request->delete();
		if ( file_exists($file) )
		{
		    if ( $err = unlink($file) )
		    {
			sfContext::getInstance()->getLogger()->emerg('unlink file with registration request name = '.$name.' returned '.$err);
			return false; 
	    	    }
		} else 
			sfContext::getInstance()->getLogger()->alert('removing registration request without data file with name = '.$name);
		return true;
	}	
	

	public function executeRegistrate(sfWebRequest $request)
	{
		$this->form = new UsicUserForm();
		if ($request->isMethod('post')) 
		{
			$this->form->getValidatorSchema()->offsetUnset('password');
			$this->form->getValidatorSchema()->offsetUnset('confirm_password');
			$this->form->bind($request->getParameter('user'));
			if ($this->form->isValid()) 
			{
				$this->redirectUnless ( $this->requestGranted(), '@homepage', 500 );
				$this->getUser()->setFlash('status_bar',$this->message);
				$this->redirect('@homepage');
			}
		}
	}
	
	public function executeShowRequests(sfWebRequest $request)
	{
		$this->requests = RegistrationRequestsTablePeer::doSelect(new Criteria());
	}
	
	public function executeAdd(sfWebRequest $request)
	{
		$this->form = new UsicUserForm();
//		$this->data = new RegistrationRequestsTable();
		if ($request->isMethod('get'))
		{
			$this->forward404Unless( $data = RegistrationRequestsTablePeer::retrieveByPK($request->getParameter('id')) );
			$this->getUser()->setFlash('request', $data);
			$this->redirectUnless( $this->form = unserialize( file_get_contents($data->getDataLocation()) ), '@homepage', 500 );
			$this->form->setProfession($this->form->getValue('profession'));
		}
		if ($request->isMethod('post')) 
		{
			$this->form->bind($request->getParameter('user'));
			if ($this->form->isValid()) 
			{
 				$script = $this->caller->callScript('um/add',$this->form->getValues());
				if ( $script != null ) {
					$this->getUser()->setFlash('status_bar', $script);
					$this->removeRequestImpl($this->getUser()->getFlash('request'));
					$this->redirect('@homepage');
				} 
				$registr = new RegistrationsTable();
				$registr->setRegisteredLogin( $this->form->getValue('login') );
				$registr->setStaffLogin( $this->getUser()->getAttribute('login') );
				$registr->save();
				
				$this->removeRequestImpl($this->getUser()->getFlash('request'));
				
				$this->getUser()->setFlash('status_bar', $this->form->getValue('login').' is our user!');
				$this->redirect('@homepage');
			}
		}
	}
	
	public function executeFind(sfWebRequest $request)
	{
		$this->form = new UsicUserForm();
		if ($request->isMethod('post'))
		{
			//$this->form->bind($request->getParameter('user')); print_r($request->getParameter('user'));print_r ($this->form->getValues());

			$script = $this->caller->callScript('um/find', array('login' => $request->getParameter('user[login]'), 'values' => null) );
			if (is_string($script)) {
				$this->getUser()->setFlash('status_bar', $script);
				$this->redirect('um/find');
			}
			$this->form = new UsicUserForm($script);
			$this->form->setNewFalse();
			$this->setTemplate('edit');
		}
	}
	public function executeEdit(sfWebRequest $request)
	{
		$this->form = new UsicUserForm();
		$this->form->setNewFalse();
		if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter('user'));
			/* XXX temporary (?) hack */
//			$this->form->setValidator('student_card', new sfValidatorString( array('required' => 'false') ));
//			$this->form->getFormFieldSchema()->getWidget('student_card')->setValue(null);
			if ($this->form->isValid()) {
 				$script = $this->caller->callScript('um/edit', $this->form->getValues());	//XXX
				if ( $script != null ) {
					$this->getUser()->setFlash('status_bar', $script);
					$this->redirect('um/find');
				} 

				$this->getUser()->setFlash('status_bar', 'user was edited');
				$this->redirect('@homepage');
			}
		}
	}
	
	public function executeEditMyPass(sfWebRequest $request)
	{
		$this->form = UsicUserForm::createPasswordForm();
		if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter('pass'));
			if ($this->form->isValid())
			{
			    $script = $this->caller->callScript('um/edit', array_merge($this->form->getValues(), array('login' => $this->getUser()->getAttribute('login'))) );
			    if ( $script != null )
				$this->getUser()->setFlash('status_bar', $script);
			    else
				$this->getUser()->setFlash('status_bar', 'your password was edited');
			    $this->redirect('@homepage');
			}
		}
		$this->setTemplate('editPass');
	}
	public function executeEditPass(sfWebRequest $request)
	{
		$this->form = UsicUserForm::createPasswordForm();
		if ($request->isMethod('get') &&  $request->hasParameter('login'))
		    $this->getUser()->setFlash('login_mod', $request->getParameter('login'));
		    //sfContext::getInstance()->getResponse()->setCookie('login', $request->getParameter('login'), time() + 60*3);

		if ( $request->isMethod('post') )
		{
		$login = $this->getUser()->getFlash('login_mod');
		if ( $login )
		{
			$this->form->bind($request->getParameter('pass'));
			if ($this->form->isValid())
			{
			    $script = $this->caller->callScript('um/edit', array_merge($this->form->getValues(), array('login' => $login) )  );
			    if ( $script != null )
				$this->getUser()->setFlash('status_bar', $script);
			    else
				$this->getUser()->setFlash('status_bar', $login.' password was edited');
			    $this->redirect('@homepage');
			} else $this->getUser()->setFlash('status_bar', 'wtf');
		}
		}
	}
	public function executeDrawFindField(sfWebRequest $request)
	{
		$this->forwardUnless($this->getRequest()->isXmlHttpRequest() && $request->isMethod('post') && in_array($field = $request->getParameter('field'), UsicUserForm::$findFields),'um','find');
		$f = new UsicUserForm(); 
		$this->form = $f;
		$this->field = $field;
	}
	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
 		$script = $this->caller->callScript('um/delete',array('login' => $request->getParameter('login')));
		if ( $script != null ) {
			$this->getUser()->setFlash('status_bar',$script);
			$this->redirect('um/find');
		} 
		$this->redirect('@homepage');
	}
	public function executeActivate(sfWebRequest $request)
	{
		$this->form = new UsicUserActivationForm();
		if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter('activation'));
			if ($this->form->isValid()) {
				$script = $this->caller->callScript('um/activate',$this->form->getValues());
				if ( is_string($script) ) {
					$this->getUser()->setFlash('status_bar',$script);
					$this->redirect('um/activate');
				} 
				$this->getUser()->setFlash('user '.$this->form->getValue('login').' was activated');
				$this->redirect('@homepage');
			}
		}
	}
	public function executeDeactivate(sfWebRequest $request)
	{
		$this->forward404Unless($this->getRequest()->getParameter('login'));
		$script = $this->caller->callScript('um/deactivate', $this->form()->getParameter('login'));
		if (is_string($script)) {
			$this->getUser()->setFlash('status_bar',$script);
			$this->redirect('um/deactivate');
		}
		$this->getUser()->setFlash('user '.$this->form()->getParameter('login').' was deactivated');
		$this->redirect('@homepage');
	}
	private function processFind()
	{
		$this->echo = 'ecp';
	}

}
