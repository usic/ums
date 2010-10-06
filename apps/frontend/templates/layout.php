<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php if (!include_slot('title')):?>
        <?php include_title() ?>
    <?php endif; ?>
    <?php use_javascript("analytics.js") ?>
    <link href="/css/popups.css" rel="stylesheet" type="text/css" >
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
  
  <h1><a href="<?php echo url_for('@homepage')?>" >USIC Upload</a></h1>
    <div id="content">
	<?php echo $sf_content ?>
    </div>
    <!--<div id="links"><?php include_partial('global/links')?></div> -->
    <div id="links">	
	<?php include_partial('global/links')?>
</div>
    <div id="status">
	<?php include_partial('global/status_bar')?>
    </div>
  </body>
</html>
