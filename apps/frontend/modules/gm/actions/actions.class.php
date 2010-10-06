<?php

/**
 * gm actions.
 *
 * @package    usic
 * @subpackage gm
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class gmActions extends sfActions
{
	private $caller = null;
	public function __construct($context, $moduleName, $actionName)
	{
		parent::__construct($context, $moduleName, $actionName);
		$this->caller = new ScriptCaller();
	}

	public function executeAdd(sfWebRequest $request)
	{
		$this->form = new UsicGroupForm();
		if ($request->isMethod('post')) 
		{
			$this->form->bind($request->getParameter('group'));
			if ($this->form->isValid()) {
 				$script = $this->caller->callScript('gm/add',$this->form->getValues());
				if ( $script != null ) {
					$this->getUser()->setFlash('status_bar',$script);
					$this->redirect('gm/add');
				} 
				$this->getUser()->setFlash('status_bar', 'group was added');
				$this->redirect('gm/show');
			}
		}
	}
	
	public function executeAddUser(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') && $request->hasParameter('user') && $request->hasParameter('group'));
		$user = $request->getParameter('user');
		$group = $request->getParameter('group');
		$result = $this->caller->callScript('gm/addUser', array('login' => $user, 'name' => $group));
		is_string($result) ? $this->getUser()->setFlash('status_bar', $result) : 
				    $this->getUser()->setFlash('status_bar', 'user '.$user.' was added to the group '.$group);
		$this->redirect('@homepage');
	}
	
	public static function getGroups()
	{
		$groups = $this->caller->callScript('gm/show');
		if (is_string($groups)) {
			sfContext::getInstance()->getUser()->setFlash('status_bar',$groups);
		}
		return $groups;
	}
	public function executeShow(sfWebRequest $request)
	{
		$this->groups = $this->caller->callScript('gm/show');
		if (is_string($this->groups)) {
			$this->getUser()->setFlash('status_bar',$this->groups);
			$this->redirect('@homepage');
		}
	}
	public function executeShowUser(sfWebRequest $request)
	{
		$this->forward404Unless($request->hasParameter('group'));
		$this->group = $request->getParameter('group');
	        $this->users = $this->caller->callScript('gm/showUser',array('name'=>$request->getParameter('group')));
	#	print_r($this->users);
		if (is_string($this->users)) {
		        $this->getUser()->setFlash('status_bar',$this->users);
			$this->redirect('gm/show');
		}
		$this->group = substr(array_shift($this->users), 0, -1);		
	}
	public function executeRemove(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') && $request->hasParameter('group'));
		$this->script = $this->caller->callScript('gm/remove', array('name' => $request->getParameter('group'), 'login' => null));
		if (is_string($this->script)) {
			$this->getUser()->setFlash('status_bar',$this->script);
			$this->redirect('gm/show');
		}
		$this->getUser()->setFlash('status_bar', 'group is removed');
		$this->redirect('@homepage');
	}
	public function executeRemoveUser(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') && $request->hasParameter('user') && $request->hasParameter('group'));
		$group = $request->getParameter('group');
		$user = $request->getParameter('user');
		$this->script = $this->caller->callScript('gm/remove', array('name' => $group, 'login' => $user));
		if (is_string($this->script)) {
			$this->getUser()->setFlash('status_bar',$this->script);
			$this->redirect('gm/showUser?group='.$group);
		}
		$this->getUser()->setFlash('status_bar', 'user is removed from group');
		$this->redirect('gm/show');	
	}
/*	public function executeDelete(sfWebRequest $request)
	{
		//after forwarding/linking from executeFind
	}
	public function executeEdit(sfWebRequest $request)
	{
	}
*/
}
