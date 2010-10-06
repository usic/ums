<?php

/**
 * PermissionsTable form.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
 
 include sfConfig::get('sf_lib_dir').'/utilities.php';
class PermissionsTableForm extends BasePermissionsTableForm
{
    public function configure()
    {
//	$gids = PermissionsTablePeer::getGids();
	$gids = getGroups();
	$this->widgetSchema['gid'] = new sfWidgetFormChoice( array('choices' => $gids ) );
	$this->validatorSchema['gid'] = new sfValidatorChoice( array('choices' => array_keys($gids), 'required' => true) );
	
	$modes = PermissionsTablePeer::getModes();
	$this->widgetSchema['mode'] = new sfWidgetFormChoice( array('choices' => array_combine($modes, $modes)) );
	$this->validatorSchema['mode'] = new sfValidatorChoice( array('choices' => $modes, 'required' => true) );
	
	$this->validatorSchema['change_at']->setOption('required', false);
	$this->validatorSchema['change_login']->setOption('required', false);
    }
    
    protected function doSave($con = null)
    {
	$this->values['change_login'] = sfContext::getInstance()->getUser()->getAttribute('login');
	return parent::doSave($con);
    }
}
