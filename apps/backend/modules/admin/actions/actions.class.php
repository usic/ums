<?php

/**
 * admin actions.
 *
 * @package    usic
 * @subpackage admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class adminActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
//    echo 'this user is '.var_dump($this->getUser()->isAuthenticated());
/*    if ($this->getUser()->isAuthenticated()) {
	echo 'yes!'. $this->getUser()->getAttribute('login'); die(0);
    } else {
	echo 'no!'; die(0);
    }	*/
//    if ( !$this->getUser()->isAuthenticated() )
//	$this->redirect('http://usic.org.ua');

    if (isset($_SESSION['usic'])) {
	echo 'usic is set: '. $_SESSION['usic'];
    } else {
	print_r($_SESSION);die(0);
	$this->redirect('/~caelum/project/');
    }
  }
    public function executeRegistrations(sfWebRequest $request)
    {
	$c = new Criteria();
	$this->registrations = RegistrationsTablePeer::doSelect($c);
    }
    public function executeHistory(sfWebRequest $request)
    {
	$c = new Criteria();
	$this->pager = new sfPropelPager('HistoryTable', 10);
	$this->pager->setCriteria($c);
	$this->pager->setPage($this->getRequestParameter('page', 1));
	if ($this->hasRequestParameter('max')) {
	    $this->pager->setMaxPerPage($this->getRequestParameter('max'));
	}
	$this->pager->init();
    }
    
    public function executeLog(sfWebRequest $request)
    {
	$loggers = sfContext::getInstance()->getLogger()->getLoggers();
	$this->logs = $loggers[2]->getLogs();
    }
}
