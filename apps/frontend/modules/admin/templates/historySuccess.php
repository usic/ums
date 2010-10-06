<h4>Історія виклику утиліт</h4>
<br>
Показувати на сторінці: <br>
<?php echo link_to('20 записів', 'admin/history?max=20') ?> <br>
<?php echo link_to('30 записів', 'admin/history?max=30') ?> <br>
<?php echo link_to('40 записів', 'admin/history?max=30') ?> <br>

<b>Результати з <?php echo $pager->getCurrent()->getDaytime() ?> по <?php echo $pager->getObjectByCursor($pager->getLastIndice())->getDaytime() ?>:</b>
<table>
<thead>
<tr>
<td>коли</td>
<td>хто</td>
<td>дія</td>
<td>аргументи</td>
<td>результат</td>
</tr>
</thead>
<tbody>
<?php foreach($pager->getResults() as $entry): ?>
<tr>
<td><?php echo $entry->getDaytime() ?></td>
<td><?php echo $entry->getUser() ?></td>
<td><?php echo $entry->getActionsTable()->getAction() ?></td>
<td><?php echo $entry->getArguments() ?></td>
<td><?php echo $entry->getReturnCode() ?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php echo link_to('first', 'admin/history?page='.$pager->getFirstPage()) ?>
  <?php echo link_to('&lt;', 'admin/history?page='.$pager->getPreviousPage()) ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'admin/history?page='.$page) ?>
    <?php if ($page != $pager->getCurrentMaxLink()): ?>    -   <?php endif ?>
  <?php endforeach ?>
  <?php echo link_to('&gt;', 'admin/history?page='.$pager->getNextPage()) ?>
  <?php echo link_to('last', 'admin/history?page='.$pager->getLastPage()) ?>
<?php endif ?>
