      <th align="center" valign="top" class="sortable-currency"><a href="#">Size</a></th>
      <th align="center" valign="top" class="sortable-text"><a href="#">When</a></th>
      <th align="center" valign="top" >State : <?php echo select_tag('state', options_for_select(UploadTablePeer::$states, $sf_request->getParameter('state')),'onchange=document.getElementById(\'shform\').submit()') ?></th>
      <th align="center" valign="top" class="sortable-text"><a href="#">Description</a></th>
      <th align="center" valign="top" >Category: <?php echo select_tag('cat', objects_for_select(CategoryTablePeer::doSelect(new Criteria()),'getId','__toString',$sf_request->getParameter('cat'),'include_blank=true'),'onchange=document.getElementById(\'shform\').submit()') ?></th>

