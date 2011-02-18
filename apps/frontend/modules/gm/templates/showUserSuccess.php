<h4>Users in group <?php echo $group ?></h4>
<?php if (strlen($users[0])>1): ?>
<?php foreach($users as $user): ?>
<ul>
<li><?php echo $user.'&nbsp&nbsp&nbsp'.link_to ('remove from group', 'gm/removeUser?group='.$group.'&user='.$user, array('post'=>'true', 'confirm'=>'Are you sure?')) .'<form method="post" action="/user/find" ><input type="hidden" name="user[login]" value="'.trim($user).'" ><input type="submit" value="Information" ></form>' ?></li>
</ul>
<?php endforeach; ?>
<?php else: ?>
There are no users in this group.
<?php endif; ?>
