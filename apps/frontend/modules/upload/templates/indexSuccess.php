<h1>Upload List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Uid</th>
      <th>Daytime</th>
      <th>Url</th>
      <th>Filename</th>
      <th>Filesize</th>
      <th>State</th>
      <th>Description</th>
      <th>Category</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($upload_table_list as $upload_table): ?>
    <tr>
      <td><a href="<?php echo url_for('upload/edit?id='.$upload_table->getId()) ?>"><?php echo $upload_table->getId() ?></a></td>
      <td><?php echo $upload_table->getUid() ?></td>
      <td><?php echo $upload_table->getDaytime() ?></td>
      <td><?php echo $upload_table->getUrl() ?></td>
      <td><?php echo $upload_table->getFilename() ?></td>
      <td><?php echo $upload_table->getFilesize() ?></td>
      <td><?php echo $upload_table->getState() ?></td>
      <td><?php echo $upload_table->getDescription() ?></td>
      <td><?php echo $upload_table->getCategoryTable() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('upload/new') ?>">New</a>
