<h4>USIC groups are</h4>
<div id="_list">
<table>
<thead>
</thead>
<tbody>
<?php #$users=gmActions::executeShowUser($request)?>
<?php foreach ($groups as $group): ?>
  <tr>
  <td>
  <?php #print_r($users = $this->caller->callScript('gm/showUser',array('name'=>$group))) );?>
	<?php echo link_to($group, 'gm/showUser?group='.$group) ?>
  </td>
  <td>
	<?php echo link_to('Delete', 'gm/remove?group='.$group, array('post' => 'true', 'confirm' => 'Are you sure?') ) ?>
  </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
