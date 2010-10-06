<?php use_helper('Object') ?>
<?php
function formatsize($file_size) {
	if( $file_size >= 1073741824 ) {
	  $file_size = round( $file_size / 1073741824 * 100 ) / 100 . " Gb";
	} elseif( $file_size >= 1048576 ) {
	  $file_size = round( $file_size / 1048576 * 100 ) / 100 . " Mb";
	} elseif( $file_size >= 1024 ) {
	  $file_size = round( $file_size / 1024 * 100 ) / 100 . " Kb";
	} else {
	  $file_size = $file_size . " b";
	}
																				return $file_size;
}
?>
<h1>My Uploads</h1>

<?php include_partial('show1') ?>
<?php include_partial('show2') ?>
<th align="center" valign="top" colspan="3">Action</th>
<!---th></th>-->
    </tr>
  </thead>
  <tfoot>
  <tr><td align="center" colspan="10">
  <?php if ($pager->haveToPaginate()): ?>
    <?php echo link_to('first', 'upload/showMy?page='.$pager->getFirstPage()) ?>
    <?php echo link_to('&lt;', 'upload/showMy?page='.$pager->getPreviousPage()) ?>
    <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
      <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'upload/showMy?page='.$page) ?>
      <?php if ($page != $pager->getCurrentMaxLink()): ?> - <?php endif ?>
    <?php endforeach ?>
    <?php echo link_to('&gt;', 'upload/showMy?page='.$pager->getNextPage()) ?>
    <?php echo link_to('last', 'upload/showMy?page='.$pager->getLastPage()) ?>
  <?php endif ?>
  </td></tr>
  </tfoot>
  <tbody>
    <?php foreach ($pager->getResults() as $upload_table): ?>
    <tr>
	<td><a  href="<?php echo 'http://usic.org.ua/upload'.substr($upload_table->getUrl(), strlen(sfConfig::get('sf_upload_dir'))) ?>" targe="_blank"></td>
      <td><a class="name" href="<?php echo 'http://usic.org.ua/upload'.substr($upload_table->getUrl(), strlen(sfConfig::get('sf_upload_dir'))) ?>" targe="_blank">
    	<?php $fname = $upload_table->getFilename(); echo strlen($fname) > 50 ? substr($fname, 0, 50)."\n".substr($fname, 51) : $fname ?></a></td>
      <?php include_partial('show3', array('upload_table'=> $upload_table)) ?>
      <td class="edit"><a href="<?php echo url_for('upload/edit?id='.$upload_table->getId()) ?>" title="Редагувати">&nbsp;&nbsp;&nbsp;</a></td>
      <td class="delete"><a href="<?php echo url_for('upload/delete?id='.$upload_table->getId())?>" onclick="return confirm('are you sure you want to delete this file?')" title="Видалити">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
      <td class="download"><a href="<?php echo 'http://usic.org.ua/upload'.substr($upload_table->getUrl(), strlen(sfConfig::get('sf_upload_dir'))) ?>" targe="_blank" title="Завантажити"></a>
     </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</form>
</table>

  <a href="<?php echo url_for('upload/new') ?>">New</a>
