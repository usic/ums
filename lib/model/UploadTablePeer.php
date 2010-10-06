<?php

class UploadTablePeer extends BaseUploadTablePeer
{
#	static public $states = array('available' => 'available for all','availableForGid' => 'available for group','unavailable' => 'unavailable');
	static public $states = array(
	    'available' => 'available for all',
	    'availableForGid' => 'available for logged in',
	    'unavailable' => 'available for me');
		//deleted state for internal usage

	/* returns array( 'all'=>'all', uid=>uid ) */
	public static function getUploaders()
	{
		$connection = Propel::getConnection();
		$query = 'SELECT DISTINCT %s FROM %s';
		$query = sprintf($query, UploadTablePeer::USER, UploadTablePeer::TABLE_NAME);
		$statement = $connection->prepare($query);
		$statement->execute();
		$uploaders['all'] = 'all';
		while ($row = $statement->fetch(PDO::FETCH_NUM))
		{
			$uploaders[$row[0]] = $row[0];
		}
		return $uploaders;
	}
}
