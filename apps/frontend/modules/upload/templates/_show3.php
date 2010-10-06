      <td><?php echo formatsize($upload_table->getFilesize()) ?></td>
      <td><?php echo $upload_table->getDaytime() ?></td>
      <td><?php echo UploadTablePeer::$states[$upload_table->getState()] ?></td>
      <td>&nbsp;<?php $desc = $upload_table->getDescription(); echo strlen($desc) > 222 ? substr($desc, 0, strpos($desc, ' ', 200)) : $desc ?></td>
      <td><?php echo $upload_table->getCategoryTable() ?></td>
