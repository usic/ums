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
