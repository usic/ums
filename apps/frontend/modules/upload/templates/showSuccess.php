<?php use_helper('Object') ?>
<h1>Upload List</h1>
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
<?php include_partial('show1') ?>
<?php include_partial('show2') ?>
      <th>who : <?php echo select_tag('who',options_for_select(UploadTablePeer::getUploaders(),$sf_request->getParameter('who')), 'onchange=document.getElementById(\'shform\').submit()') ?></th>
    </tr>
    </thead>
    <?php foreach ($pager->getResults() as $upload_table): ?>
    <tr>
    <td > 
      <a href="<?php echo 'http://usic.org.ua/upload'.substr($upload_table->getUrl(), strlen(sfConfig::get('sf_upload_dir'))) ?>"  targe="_blank"  title="Завантажити"></a>
      </td>
      <td >
      <a class="name" href="<?php echo 'http://usic.org.ua/upload'.substr($upload_table->getUrl(), strlen(sfConfig::get('sf_upload_dir'))) ?>" title="<?php echo $upload_table->getFilename(); ?>"  targe="_blank" >
    	    <?php $fname = $upload_table->getFilename(); echo strlen($fname) > 23 ? substr(substr($fname,0,strripos($fname,".")),0,23): $fname ?></a></td>
     <!-- <td>--><?php #echo $upload_table->getFilesize() ?><!---/td>-->
<?php include_partial('show3', array('upload_table'=> $upload_table)) ?>
      <td><?php echo $upload_table->getUser() ?></td>
    </tr>
    <?php endforeach; ?>
<tfoot>
<tr><td align="center" colspan="8">
<?php if ($pager->haveToPaginate()): ?>
<?php $getParam = '';//sfContext::getInstance()->getRouting()->getCurrentInternalUri();
    $par = sfContext::getInstance()->getRequest()->getGetParameter('who', '');
    if (strlen($par)>0) $getParam .= '&who='.$par;
    $par = sfContext::getInstance()->getRequest()->getGetParameter('state', '');
    if (strlen($par)>0) $getParam .= '&state='.$par;
    $par = sfContext::getInstance()->getRequest()->getGetParameter('cat', '');
    if (strlen($par)>0) $getParam .= '&cat='.$par;
?>
  <?php echo link_to('first', 'upload/show?page='.$pager->getFirstPage(), 
		array('query_string' => $getParam)) ?>
  <?php echo link_to('&lt;', 'upload/show?page='.$pager->getPreviousPage(), array('query_string' => $getParam)) ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'upload/show?page='.$page,array("query_string"=>$getParam)) ?>
    <?php if ($page !== $pager->getCurrentMaxLink()): ?> - <?php endif ?>
  <?php endforeach ?>
  <?php echo link_to('&gt;', 'upload/show?page='.$pager->getNextPage(), array('query_string' => $getParam)) ?>
  <?php echo link_to('last', 'upload/show?page='.$pager->getLastPage(), array('query_string' => $getParam)) ?>
<?php endif ?>
</td></tr></tfoot>
</form>
</table>
<script type="text/javascript" src="/js/tablesort.js"></script>
<br/>
<?php if (sfContext::getInstance()->getUser()->isAuthenticated()): ?><a href="<?php echo url_for('upload/new') ?>">New</a><?php endif ?>
