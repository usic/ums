<?php

/**
 * upload actions.
 *
 * @package    usic
 * @subpackage upload
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class uploadActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->upload_table_list = UploadTablePeer::doSelect(new Criteria());
  }

  // caelum, 16.03.2010: not used anymore
  private function download($fromFile, $toFile, $size)
  { 
    $this->getResponse()->clearHttpHeaders();
    /*
    $this->getResponse()->addCacheControlHttpHeader('Cache-control','must-revalidate, post-check=0, pre-check=0');
    $this->getResponse()->setContentType('application/octet-stream', true);
    $this->getResponse()->setHttpHeader('Content-Description: File Transfer', true);
    $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
    $this->getResponse()->setHttpHeader('Accept-Ranges: bytes', true);
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename='.$toFile, true);
    $this->getResponse()->setHttpHeader('Content-Length: '.$size, true);
    */
    
    header('Content Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$toFile);
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    header('Expires: 0');
    header('Cache-control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: '.$size);
    

    ob_clean();
    flush();
    readfile($fromFile);
  }
  // caelum, 16.03.2010: not used anymore
  public function executeDownload(sfWebRequest $request)
  {
    $needed = UploadTablePeer::retrieveByPk($request->getParameter('id'));
    if (!$needed || $needed->getState()=='unavailable')
	$this->forward404();//Unless($needed, printf('Such file does not exist.'));

//    $er = error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
    $this->download($needed->getUrl(), $needed->getFilename(), $needed->getFilesize());
//    error_reporting($er);
    $this->forward('upload','show');
  }

  public function executeShow(sfWebRequest $request)
  {
    $c = $this->getShowCriteria($request);
    $this->pager = new sfPropelPager('UploadTable', '10');
    $this->pager->setCriteria($c);
    if ($this->hasRequestParameter('max')) {
	$this->pager->setMaxPerPage($this->getRequestParameter('max'));
    }
    $this->pager->init();
    $p = $this->hasRequestParameter('page') ? $this->getRequestParameter('page') : $this->pager->getLastPage();
//    echo $this->pager->getLastPage() . ', '. $p;
    $this->pager->setPage($p);
    $this->pager->init();	// hack?
//    $this->upload_table_list = UploadTablePeer::doSelect($this->getShowCriteria($request,$c));
  }

  public function executeShowMy(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->add(UploadTablePeer::USER, $this->getUser()->getAttribute('login'));
    $this->pager = new sfPropelPager('UploadTable', '10');
    $this->pager->setCriteria($this->getShowCriteria($request, $c));
    $this->pager->setPage($this->getRequestParameter('page'), $this->pager->getLastPage());
    if ($this->hasRequestParameter('max')) {
	$this->pager->setMaxPerPage($this->getRequestParameter('max'));
    }
    $this->pager->init();
    $p = $this->hasRequestParameter('page') ? $this->getRequestParameter('page') : $this->pager->getLastPage();
    //echo $this->pager->getLastPage() . ', '. $p;
    $this->pager->setPage($p);
    $this->pager->init();	// hack?
//    $this->upload_table_list = UploadTablePeer::doSelect($this->getShowCriteria($request,$c));
//     $this->setTemplate('show');
  }

  private function getShowCriteria(sfWebRequest $request, Criteria $c = null)
  {
    if (is_null($c))
        $c = new Criteria();
    if ($request->hasParameter('state')) {
	$state = $request->getParameter('state');
	if ( !$this->getUser()->isAuthenticated() ) {
	    // unauthencticated user cannot see anything except "for all" - so ignoring this
	    if  ($state == 'available')
	    	$c->add(UploadTablePeer::STATE, $state);
	    else $this->redirect('upload/show');
	} else {
	    if ($state == 'unavailable') {
		$subc1 = $c->getNewCriterion(UploadTablePeer::STATE, 'unavailable');
	        $subc2 = $c->getNewCriterion(UploadTablePeer::USER, $this->getUser()->getAttribute('login'));
		$subc1->addAnd($subc2);
		$c->add($subc1);
	    // state can be available, availableForGid, deleted
	    } else {
		$c->add(UploadTablePeer::STATE, $state);
	    }
	}
#    	$c->add(UploadTablePeer::STATE, $request->getParameter('state'));
    // no state in request
    } else {
	$subc1 = $c->getNewCriterion(UploadTablePeer::STATE, 'available');
	if ($this->getUser()->isAuthenticated()) {
    	    $subc2 = $c->getNewCriterion(UploadTablePeer::STATE, 'availableForGid');
	    $subc3 = $c->getNewCriterion(UploadTablePeer::STATE, 'unavailable');
//	    $subc4 = $c->getNewCriterion(UploadTablePeer::USER, $this->getUser()->getAttribute('login'));
//	    $subc3->addAnd($subc4);
	    $subc2->addOr($subc3);
	    $subc1->addOr($subc2);
	}
	$c->add($subc1);
	
    }
    
    $who = $request->getParameter('who');
    if ( is_string($who) && ($who != 'all'))
        $c->add(UploadTablePeer::USER, $request->getParameter('who'));
    if ($request->getParameter('cat') != null) 
	$c->add(UploadTablePeer::CATEGORY_ID, $request->getParameter('cat'));
    return $c;
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UploadTableForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new UploadTableForm();

    $this->tmpAction = 'saved';
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($upload_table = UploadTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object upload_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new UploadTableForm($upload_table);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($upload_table = UploadTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object upload_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new UploadTableForm($upload_table);

    $this->tmpAction = 'edited';
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $this->forward404Unless($upload_table = UploadTablePeer::retrieveByPk($id), sprintf('Object upload_table does not exist (%s).', $id));
    if ( unlink($upload_table->getUrl()) && rmdir($upload_table->getDir()) ) {
	sfContext::getInstance()->getLogger()->emerg($this->getUser()->getAttribute('login').' deleted '.$upload_table->getDir());
        $upload_table->delete();

	$this->getUser()->setFlash('status_bar', 'file was deleted');
        $this->redirect('@homepage');
    } else {
    	sfContext::getInstance()->getLogger()->alert(
		"couldn't delete the file from filesystem: " . $upload_table->getUrl().", user - ".$this->getUser()->getAttribute('login'));
	throw new Exception("couldn't delete the file from filesystem");
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
	try 
        {
		$upload_table = $form->save();
	} catch (Exception $e) {
		$this->getUser()->setFlash('status_bar',$e->getMessage());
		$this->redirect('upload/new');
	}
      $this->getUser()->setFlash('status_bar', 'your file was successfully '.$this->tmpAction);
      $this->redirect('upload/edit?id='.$upload_table->getId());
    }
  }
}
