<?php

/**
 * links actions.
 *
 * @package    usic
 * @subpackage links
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class linksActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->links_table_list = LinksTablePeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new LinksTableForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LinksTableForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($links_table = LinksTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object links_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new LinksTableForm($links_table);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($links_table = LinksTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object links_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new LinksTableForm($links_table);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($links_table = LinksTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object links_table does not exist (%s).', $request->getParameter('id')));
    $links_table->delete();

    $this->redirect('links/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $links_table = $form->save();

      $this->redirect('links/edit?id='.$links_table->getId());
    }
  }
}
