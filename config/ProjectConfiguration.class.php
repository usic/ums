<?php

# FROZEN_SF_LIB_DIR: /usr/lib/php/symfony

require_once dirname(__FILE__).'/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
//     $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin'));
#    sfConfig::set('sf_upload_dir', '/var/www/site/htdocs/upload_avail');
    sfConfig::set('sf_upload_dir', '/var/www/upload/upload_avail');
  }
}
