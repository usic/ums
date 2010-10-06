<?php echo form_tag('cliens/auth') ?>
<table>
<tr>
	<td>Login:</td>
	<td><?php echo input_tag('login',null,array('size' => 20, 'maxlength' => 20)) ?></td>
</tr><tr>
	<td>Password:</td>
	<td><?php echo input_password_tag('password') ?></td>
</tr><tr>
	<td colspan="2"><?php echo submit_tag('Ok') ?></td>
</tr>
</table>
</form>