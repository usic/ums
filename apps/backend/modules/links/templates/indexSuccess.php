<h1>Links List</h1>

<table>
  <thead>
    <tr>
      <th>Module name</th>
      <th>Action name</th>
      <th>Name</th>
      <th>Created at</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($links_table_list as $links_table): ?>
    <tr>
      <td><?php echo $links_table->getModuleName() ?></td>
      <td><?php echo $links_table->getActionName() ?></td>
      <td><?php echo $links_table->getName() ?></td>
      <td><?php echo $links_table->getCreatedAt() ?></td>
      <td><?php echo link_to('edit', url_for('links/edit?id='.$links_table->getId())) ?></td>      
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('links/new') ?>">New</a>
