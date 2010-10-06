<h4>Історія реєстрацій</h4>

<table>
<thead>
<tr>
<td>коли</td>
<td>хто</td>
<td>кого</td>
</tr>
</thead>
<tbody>
<?php foreach($registrations as $registration): ?>
<tr>
<td><?php echo $registration->getDaytime() ?></td>
<td><?php echo $registration->getStaffLogin() ?></td>
<td><?php echo $registration->getRegisteredLogin() ?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
