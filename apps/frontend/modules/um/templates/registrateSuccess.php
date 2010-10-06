<?php include_partial('form1', array('form' => $form)) ?>
<form action="<?php echo url_for('um/registrate') ?>" method="POST">
<?php include_partial('form2', array ('form' => $form)) ?>
<?php include_partial('form3', array ('form' => $form)) ?>
	<tr>
	<td colspan="2">
	<input type="submit" />
	</td>
	</tr>
</table>
</form>
<script language=javascript>resubmit();</script>
