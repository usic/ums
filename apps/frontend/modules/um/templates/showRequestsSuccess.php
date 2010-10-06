<h4>Who wants to register in USIC:</h4>
<table>
<thead>
<tr>
    <th>login</th>
    <th>when</th>
    <th></th>
<tr>
</thead>
<tbody>
<?php foreach ($requests as $request): ?>
<tr>
    <td><?php echo link_to($request->getName(), 'um/add?id='.$request->getId()) ?></td>
    <td><?php echo $request->getDaytime() ?></td>
    <td><?php echo link_to('remove', 'um/removeRequest?id='.$request->getId()) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>