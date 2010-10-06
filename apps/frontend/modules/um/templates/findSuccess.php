<?php use_helper('Javascript') ?>

<!-----------
 <h4>How do you want to search:</h4> 

<div id="_list">
<ul>
<?php foreach (UsicUserForm::$findFields as $field): ?>
	<li>
	<?php if_javascript(); ?>
		<?php echo link_to_remote($form[$field]->renderLabel(), array('update'=>'find_field','url'=>'um/drawFindField?field='.$field)) ?>
	<?php end_if_javascript(); ?>
	<noscript>
		<?php echo link_to($form[$field]->renderLabel(), 'um/drawFindField?field='.$field) ?>
	</noscript>
	</li>
<?php endforeach; ?>
<ul>
<div id="find_field"></div>

</div>

----------->

<form method="post" action="<?php echo url_for('um/find') ?>" >
<h4>Enter data for searching:</h4>
<?php $fields = UsicUserForm::$findFields; echo $form[$field]->renderRow() ?>
<input type="submit" >
</form>

