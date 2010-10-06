<?php

/**
 * UploadTable form.
 *
 * @package    usic
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UploadTableForm extends BaseUploadTableForm
{
	static $supported_mime = array (
// 				"application/octet-stream",
				"application/rtf","application/pdf","application/postscript","application/vnd.oasis.opendocument.text",
				"application/zip","application/x-zip","application/x-zip-compressed","application/x-gzip","application/bzip2","application/x-tar",
				"application/x-bzip2",
				/* audio */  
				"audio/x-ogg",
				"audio/mpeg3",
				"audio/x-mpeg-3",
				"audio/mpeg",
				"audio/x-mpequrl",
				/* video */
				"application/x-troff-msvideo",
				"video/mpeg",
				"video/x-mpeg",
				"video/avi",
				"video/msvideo",
				"video/x-msvideo",
				"video/x-flv",
				/* "image/",*/ 
				"image/vnd.djvu",
				"image/vnd.djvu", 
				"image/gif",
				"image/x.djvu", "image/vnd.djvu", "image/djvu",
				"audio/x-ogg",
				"image/gif",
				"image/tiff",
				"image/jpeg","image/jpg","image/pjpeg",
				"image/png","image/x-png",
				"image/svg","image/svg+xml","image/svg-xml","text/xml-svg","image/vnd.adobe.svg+xml",
				"text/rtf","text/html","text/plain"
			);

  public function configure()
  {
	$this->widgetSchema['file'] = new sfWidgetFormInputFile();
	$this->validatorSchema['file'] = new sfValidatorFile(array('required' => true, 'max_size' => 1024000000,
		'mime_types' => self::$supported_mime
//		,'mime_type_guessers' => array( 'guessFromFileBinary' )
// 		,'mime_type_guessers'=>array( 'guessFromFileinfo', 'guessFromFileBinary' ) 
		), array('max_size' => 'your file must be less than %max_size%',
			'mime_types'=>'such file format is not recognized'));

	/* uploading files cannot be done via editing */
	if (!$this->isNew()) {
		$this->validatorSchema['file']->setOption('required',false);
	}

	$validators = $this->validatorSchema->getFields();
	$validators['daytime']->setOption('required',false);
	$validators['user']->setOption('required',false);
	unset($this->validatorSchema['url']);
	unset($this->validatorSchema['filesize']);
	unset($this->validatorSchema['filename']);

	$this->widgetSchema['state'] = new sfWidgetFormChoice(array('choices' => UploadTablePeer::$states));
	$this->validatorSchema['state'] = new sfValidatorChoice(array('choices' => array_keys(UploadTablePeer::$states),'required' => true));

	$this->widgetSchema['category_id']->setOption('label', 'Category');
	$this->setDefaults(array('category_id'=>CategoryTablePeer::defaultCategory()));
  }

  protected function doSave($con = null) //$con's type is PropelPDO
  {
	if ($this->isNew()) 
	{
		$file = $this->getValue('file');
		$size = $file->getSize();
		$name = $file->getOriginalName();
		$dirname = sfConfig::get('sf_upload_dir').'/'.sha1($file->getOriginalName().rand(11111, 99999));
		if (!mkdir($dirname))
		    throw new Exception('could not create the directory for your file');
		    
		$path = $dirname . '/' . $file->getOriginalName();

		if (file_exists($path))
		{
 			throw new Exception('such a file already exists');
		}
		$file->save($path);

		// setting fields for database 
		$this->values['user'] = sfContext::getInstance()->getUser()->getAttribute('login');
		$this->values['url'] = $path;
		$this->values['filename'] = $name;
		$this->values['filesize'] = $size;
	}
	return parent::doSave($con);
  }
  public function save($con = null)
  {
	$this->values['user'] = sfContext::getInstance()->getUser()->getAttribute('login');
	return parent::save($con);
  }
}
