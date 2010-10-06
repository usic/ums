<?php $links = PermissionsTablePeer::getLinksForGids(array('www'))?>
<?php foreach ($links as $link): ?>
	<?php echo link_to($link->getName(), $link->getUrl()) ?> &nbsp;<br>
<?php endforeach; ?>
