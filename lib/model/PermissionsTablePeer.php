<?php

class PermissionsTablePeer extends BasePermissionsTablePeer
{
	/* by default returns only links which are enabled (set to 'on') */
	public static function getLinksForGids($gids,$mode='on')
	{
		/*$c = new Criteria();
		$c->add(PermissionsTablePeer::GID, $gid);
		$c->add(PermissionsTablePeer::MODE, $mode);
		$permissions = PermissionsTablePeer::doSelect($c);*/
		
		$connection = Propel::getConnection();
		$subquery = '';
		$n = count($gids)-1; $i = 0;
		while ($i<$n)
		{
			$subquery .= ' '.PermissionsTablePeer::GID.'=\''.$gids[$i].'\' OR '; 
			$i++;
		}
		$subquery .= ' '.PermissionsTablePeer::GID.'=\''.$gids[$n].'\'';
		$query = 'SELECT %s, %s from %s WHERE %s=\''.$mode.'\' AND ( '.$subquery.' )';
		$query = sprintf($query, PermissionsTablePeer::ID, PermissionsTablePeer::LINK_ID,PermissionsTablePeer::TABLE_NAME, PermissionsTablePeer::MODE);
		$statement = $connection->prepare($query);
		$statement->execute();
		$links = array(); $i = 0;
		while ($permission = $statement->fetch(PDO::FETCH_NUM))
		{
			$links[$i] = LinksTablePeer::retrieveByPk($permission[1]); $i++;
		}
		return $links;
	}
	
	/* used in security checking */
	public static function getGidsForLink($link)
	{
// 		$c = new Criteria();
// 		$c->add(PermissionsTablePeer::LINK_ID,$link);
// 		$permissions = PermissionsTablePeer::doSelect($c);
		$connection = Propel::getConnection();
//		$query = 'SELECT DISTINCT %s FROM %s WHERE %s = \'security\' and %s = '.$link;
//		$query = sprintf($query, PermissionsTablePeer::GID, PermissionsTablePeer::TABLE_NAME, PermissionsTablePeer::MODE, PermissionsTablePeer::LINK_ID);
		$query = 'SELECT DISTINCT %s FROM %s WHERE %s = '.$link;
		$query = sprintf($query, PermissionsTablePeer::GID, PermissionsTablePeer::TABLE_NAME, PermissionsTablePeer::LINK_ID);		
		$statement = $connection->prepare($query);
		$statement->execute();
		$gids = array();
		while ($row = $statement->fetch(PDO::FETCH_NUM))
		{
			$gids[$row[0]] = $row[0];
		}
		return $gids;
	}

	/* returns all diferent gids thar are present in the permissions rules except group www = administration group for web-interface */
	public static function getGids()
	{
		$connection = Propel::getConnection();
		$query = 'SELECT DISTINCT %s FROM %s';
		$query = sprintf($query, PermissionsTablePeer::GID, PermissionsTablePeer::TABLE_NAME);
		$statement = $connection->prepare($query);
		$statement->execute();
		$gids = array();
		while ($row = $statement->fetch(PDO::FETCH_NUM))
		{
			if ($row[0] != 'www')
			    $gids[$row[0]] = $row[0];
		}
		return $gids;
	}
	
	public static function getModes()
	{
		return self::$modes;
	}
	
	private static $modes = array('on', 'security', 'off');
}
