<?php

/**
 * permissions actions.
 *
 * @package    usic
 * @subpackage permissions
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class permissionsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->permissions_table_list = PermissionsTablePeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PermissionsTableForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PermissionsTableForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($permissions_table = PermissionsTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object permissions_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new PermissionsTableForm($permissions_table);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($permissions_table = PermissionsTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object permissions_table does not exist (%s).', $request->getParameter('id')));
    $this->form = new PermissionsTableForm($permissions_table);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($permissions_table = PermissionsTablePeer::retrieveByPk($request->getParameter('id')), sprintf('Object permissions_table does not exist (%s).', $request->getParameter('id')));
    $permissions_table->delete();

    $this->redirect('permissions/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $permissions_table = $form->save();
      $this->redirect('permissions/edit?id='.$permissions_table->getId());
    }
  }
}
