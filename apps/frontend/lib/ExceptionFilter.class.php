<?php

class ExceptionFilter extends sfFilter
{
	public function execute($filterChain)
	{
		try 
		{
			$filterChain->execute();
        	} catch (sfStopException $e) 
		{
	               throw $e;
		} catch (sfException $e) 
		{
			$this->getContext()->getLogger()->emerg($e->getMessage());
			$response = $this->getContext()->getResponse();
			$content = $response->getContent();
			$response->setContent(str_ireplace('<body>','<body><div class="error_list">'.$e->getMessage().'</div>',$content));
// 			$response->setSlot('status_bar','<div class="error_list">'.$e->getMessage().'</div>');
        	}
	}
}
