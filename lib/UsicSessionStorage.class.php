<?php
class UsicSessionStorage extends sfPDOSessionStorage
{
  public function sessionWrite($id, $data)
  {
    // get table/column
    $db_table    = $this->options['db_table'];
    $db_data_col = $this->options['db_data_col'];
    $db_id_col   = $this->options['db_id_col'];
    $db_time_col = $this->options['db_time_col'];
    $db_addon_col = 'username';
    $value = sfContext::getInstance()->getUser()->hasAttribute('login') ?
        sfContext::getInstance()->getUser()->getAttribute('login') : 'NULL';

    $sql = 'UPDATE '.$db_table.' SET '.$db_data_col.' = ?, '.$db_time_col.' = '.time().', '.$db_addon_col.' = '.$value.' WHERE '.$db_id_col.'= ?';

    try
    {
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(1, $data, PDO::PARAM_STR);
      $stmt->bindParam(2, $id, PDO::PARAM_STR);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new sfDatabaseException(sprintf('PDOException was thrown when trying to manipulate session data. Message: %s', $e->getMessage()));
    }

    return true;
  }
}
