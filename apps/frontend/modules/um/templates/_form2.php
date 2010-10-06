<table>
<?php echo $form->renderGlobalErrors() ?>
	<?php echo ($form['surname']->renderRow())?>
	<?php echo $form['name']->renderRow() ?>
	<?php echo $form['middle_name']->renderRow() ?>
	<?php echo ( $form->isNew() ? $form['login']->renderRow() : $form['login']->renderRow(array('readonly' => 'true'), $form['login']->renderLabelName().' (ro)') ) ?>
