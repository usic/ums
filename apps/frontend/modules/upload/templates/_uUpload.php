<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>


<?php if ($form->getObject()->isNew()): ?>
What are you doing here?
<?php else: ?>

<form action="<?php echo url_for('upload/update?id='.$form->getObject()->getId()) ?>" method="post" enctype="multipart/form-data" >
<input type="hidden" name="sf_method" value="put" />

  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('upload/show') ?>">Cancel</a>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>

    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['file']->renderLabel() ?></th>
        <td>
          <?php echo $form->getObject()->getFilename() ?>
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
        <th><?php echo $form['category_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['category_id']->renderError() ?>
          <?php echo $form['category_id'] ?>
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

<?php endif; ?>
