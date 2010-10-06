<?php include_partial('form1', array('form' => $form)) ?>

<form action="<?php echo url_for('um/add') ?>" method="POST">

<?php include_partial('form2', array('form' => $form)) ?>
<?php include_partial('password', array('form' => $form)) ?>
<?php include_partial('form3', array('form' => $form)) ?>
	<td colspan="2">
	<input type="submit" value="Add"/>
	</td>
	</tr>
</table>
</form>
<script language=javascript>//resubmit();</script>
<?php //echo ($form) ?>
<?php //echo serialize($form)?>