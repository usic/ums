<?php

class LinksTable extends BaseLinksTable
{
	public function getUrl()
	{
		return url_for($this->getModuleName().'/'.$this->getActionName());
	}
	
	public function __toString()
	{
	    return $this->getName();
	}
}
