<?php

class HistoryTable extends BaseHistoryTable
{
	public function __construct($user="",$gid="",$act="",$arguments="",$rcode="")
	{
		parent::__construct();
		$this->setUser($user);
		$this->setGid($gid);
		if (!is_null($act))
		{
		    $c = new Criteria();
    		    $c->add(ActionsTablePeer::ACTION,$act);
		    $action = ActionsTablePeer::doSelectOne($c);
		    if ($action) $this->setActionId($action->getId());
		}
		$this->setArguments($arguments);
		$this->setReturnCode($rcode);
	}
	public function getAction()
	{
		$this->getActionsTable()->getAction();
	}
}
