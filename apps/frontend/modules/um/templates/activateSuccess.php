<?php include_partial('global/status_bar') ?>
<form action="<?php echo url_for('um/activate') ?>" method="POST">
<table>
	<?php echo $form->render() ?>
	<tr>
	<td colspan="2">
	<input type="submit" />
	</td>
	</tr>
</table>
</form>
