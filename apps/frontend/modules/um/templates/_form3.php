	<?php echo $form['entering_year']->renderRow() ?>
	<?php echo $form['status']->renderRow() ?>
	<?php echo $form['faculty']->renderRow(array('onchange' => 'resubmit();')) ?>
	<?php echo $form['profession']->renderRow() ?>
	<?php if ($form->isNew()):?>
	<?php echo $form['reader_card']->renderRow() ?>
	<?php echo $form['student_card']->renderRow() ?>
	<?php echo $form['passport']->renderRow() ?>
	<?php else: ?>
	<?php echo $form['reader_card']->renderRow(array('readonly' => 'true'), $form['reader_card']->renderLabelName().' (ro)') ?>
	<?php echo $form['student_card']->renderRow(array('readonly'=>'true'), $form['student_card']->renderLabelName().' (ro)') ?>
	<?php echo $form['passport']->renderRow(array('readonly' => 'true'), $form['passport']->renderLabelName().' (ro)') ?>	
	<?php endif; ?>
	<tr>
	
