      <th align="center" valign="top">Size</th>
      <th align="center" valign="top">When</th>
      <th align="center" valign="top">State : <?php echo select_tag('state', options_for_select(UploadTablePeer::$states, $sf_request->getParameter('state')),'onchange=document.getElementById(\'shform\').submit()') ?></th>
      <th align="center" valign="top">Description</th>
      <th align="center" valign="top">Category : <?php echo select_tag('cat', objects_for_select(CategoryTablePeer::doSelect(new Criteria()),'getId','__toString',$sf_request->getParameter('cat'),'include_blank=true'),'onchange=document.getElementById(\'shform\').submit()') ?></th>

