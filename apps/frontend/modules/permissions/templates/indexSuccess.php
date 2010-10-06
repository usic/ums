<h1>Permissions List</h1>

<table>
  <thead>
    <tr>
      <th>link</th>
      <th>group</th>
      <th>mode</th>
      <th>when created/changed</th>
      <th>who created/changed</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($permissions_table_list as $permissions_table): ?>
    <tr>
      <td><?php echo LinksTablePeer::retrieveByPK($permissions_table->getLinkId()) ?></td>
      <td><?php echo $permissions_table->getGid() ?></td>
      <td><?php echo $permissions_table->getMode() ?></td>
      <td><?php echo $permissions_table->getChangeAt() ?></td>
      <td><?php echo $permissions_table->getChangeLogin() ?></td>
      <td><?php echo link_to ('edit', url_for('permissions/edit?id='.$permissions_table->getId()) ) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('permissions/new') ?>">New</a>
