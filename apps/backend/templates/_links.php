<?php $links = PermissionsTablePeer::getLinksForGids(array('www'))?>
<?php foreach ($links as $link): ?>
	<?php echo link_to($link->getName(), $link->getUrl()) ?> &nbsp;<br>
<?php endforeach; ?>

<a href="<?php echo url_for('@homepage').'/../../index.php' //sfConfig::get('sf_web_dir').'/web/backend.php' ?> ">back to main part</a>
