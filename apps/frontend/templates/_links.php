<?php $links = PermissionsTablePeer::getLinksForGids($sf_user->listCredentials())?>
<ul>
<?php foreach ($links as $link): ?>
<?php# echo $link->getUrl();?>
<?php if (($link->getId()!==4)&&($link->getId()!==24)&&(sfContext::getInstance()->getUser()->isAuthenticated())){  
    echo "<li>".link_to($link->getName(), $link->getUrl())."</li>" ;
  }
  elseif(!sfContext::getInstance()->getUser()->isAuthenticated()){
    echo "<li>".link_to($link->getName(), $link->getUrl())."</li>" ;
    }
 ?>
<?php endforeach; ?>
<?php if ($sf_user->getAttribute('www')): ?>
<?php echo "<li>". link_to('Admin functions', 'admin/index')."</li>" ?>
<?php endif; ?>
</ul>
