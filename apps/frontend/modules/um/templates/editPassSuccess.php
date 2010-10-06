<h4>Enter your new password:</h4>
<table>
<form action=<?php echo url_for($_SERVER['REQUEST_URI']) ?> method="post">
<?php echo $form->renderGlobalErrors()?>
<?php include_partial('password', array('form' => $form))?>
<tr><td colspan="2"><input type="submit" /></td></tr>
</form>
</table>