<?php //if ( !$form->isValid() ): ?>
<?php //echo 'st_c = '.$form['student_card']->getValue() ?>
<?php //echo 'err = '.$form['student_card']->getError() ?>
<?php //endif; ?>
<h4>Edit user</h4>

<?php include_partial('form1', array('form' => $form)) ?>

<form action="<?php echo url_for('um/edit') ?>" method="POST">

<?php include_partial('form2', array('form' => $form)) ?>
<?php //include_partial('password', array('form' => $form)) ?>
<?php //echo $form['password']->renderRow(array('required' => 'true')) ?>
<?php //echo $form['confirm_password']->renderRow() ?>
<?php //echo $form['year']->renderRow() ?>
<?php //echo $form['faculty']->renderRow( array('onchange' => 'resubmit();') ) ?>
<?php //echo $form['profession']->renderRow() ?>
<?php //echo $form['reader_card']->renderRow(array('readonly' => 'true')) ?>
<?php //echo $form['student_card']->renderRow(array('readonly'=>'true')) ?>
<?php //echo $form['passport']->renderRow(array('readonly' => 'true')) ?>
<?php include_partial('form3', array('form' => $form)) ?>
	<td colspan="1"><input type="submit" value="Edit" /></td>
	<td colspan="1"><?php echo link_to('Change password', 'um/editPass?login='.$form['login']->getValue()) ?></td>
	</tr>
</table>
</form>
<?php //$form->setProfession($form['profession']->getValue()) ?>
<?php if (is_null($form['profession']->getValue())): ?>
<script language=javascript>resubmit();</script>
<?php endif; ?>

<script language=javascript>
function getGroup()
{
	return "group="+document.getElementById("group").value;
}
</script>

<?php include(sfConfig::get('sf_lib_dir').'/utilities.php') ?>
<?php $groups = getGroups() ?>
<?php echo $st = select_tag('group', options_for_select($groups, current($groups)), 
    array('onchange' => 'buildLink();')) ?>&nbsp
<?php //echo link_to('Add to group', 'gm/addUser?user='.$form['login']->getValue(), 'post=true id="linkadd" ')?>
<a onclick="var f=document.createElement('form'); this.parentNode.appendChild(f); f.method='post'; f.action=this.href+getGroup(); f.submit();return false;" 
    href="<?php echo url_for('gm/addUser').'?user='.$form['login']->getValue().'&' ?>">Add to group</a><br>
<?php echo link_to ('Delete user', 'um/delete?login='.$form['login']->getValue(), array('method' => 'delete', 'confirm' => 'Are you sure?'))?>
	
