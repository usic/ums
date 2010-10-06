<?php

class UploadTable extends BaseUploadTable
{
    // return full path to file, like /var/www/dir
    public function getDir()
    {
	return substr($this->getUrl(), 0, strrpos($this->getUrl(), '/'));
    }
}
