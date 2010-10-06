<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('upload/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('upload/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'upload/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['uid']->renderLabel() ?></th>
        <td>
          <?php echo $form['uid']->renderError() ?>
          <?php echo $form['uid'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['daytime']->renderLabel() ?></th>
        <td>
          <?php echo $form['daytime']->renderError() ?>
          <?php echo $form['daytime'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['url']->renderLabel() ?></th>
        <td>
          <?php echo $form['url']->renderError() ?>
          <?php echo $form['url'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['filename']->renderLabel() ?></th>
        <td>
          <?php echo $form['filename']->renderError() ?>
          <?php echo $form['filename'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['filesize']->renderLabel() ?></th>
        <td>
          <?php echo $form['filesize']->renderError() ?>
          <?php echo $form['filesize'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['state']->renderLabel() ?></th>
        <td>
          <?php echo $form['state']->renderError() ?>
          <?php echo $form['state'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
