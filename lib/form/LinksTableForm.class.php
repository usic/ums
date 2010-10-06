<?php

/**
 * LinksTable form.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class LinksTableForm extends BaseLinksTableForm
{
  public function configure()
  {
	parent::configure();
	$this->validatorSchema['created_at']->setOption('required', false);
  }
}
