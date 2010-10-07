<?php $links = PermissionsTablePeer::getLinksForGids($sf_user->listCredentials())?>
<?php $requests = RegistrationRequestsTablePeer::doSelect(new Criteria());?>
<?php $uploads  = UploadTablePeer::doSelect(new Criteria());?>
<?php 
$myuploads=0;
foreach($uploads as $upload){
	if($upload->getUser()==$sf_user->getAttribute('login')){
	  $myuploads++;	
	}
}
?>
<ul>
<?php foreach ($links as $link): ?>
<?php# echo $link->getUrl();?>
<?php if (($link->getId()!==4)&&($link->getId()!==24)&&(sfContext::getInstance()->getUser()->isAuthenticated())){ 
	if($link->getId()==13){
	    echo "<li>".link_to($link->getName()."&nbsp;(".count($requests).")", $link->getUrl())."</li>" ;
	}
	elseif($link->getId()==3){
	    echo "<li>".link_to($link->getName()."&nbsp;(".count($uploads).")", $link->getUrl())."</li>" ;
	}
	elseif($link->getId()==6){
	    echo "<li>".link_to($link->getName()."&nbsp;(".($myuploads).")", $link->getUrl())."</li>" ;
	}
	else{
	    echo "<li>".link_to($link->getName(), $link->getUrl())."</li>" ;
	}
  }
  elseif(!sfContext::getInstance()->getUser()->isAuthenticated()){
    echo "<li>".link_to($link->getName(), $link->getUrl())."</li>" ;
    }
 ?>
<?php #Who sfContext::getInstance()->getUser()->isAuthenticated()?>
<?php endforeach; ?>
<?php if (($sf_user->getAttribute('www'))&&( sfContext::getInstance()->getUser()->isAuthenticated())):?>
<?php echo "<li>". link_to('Admin functions', 'admin/index')."</li>" ?>
<?php endif; ?>
</ul>
