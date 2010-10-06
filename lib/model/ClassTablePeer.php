<?php

class ClassTablePeer extends BaseClassTablePeer
{
	public static function getFaculties()
	{
		$connection = Propel::getConnection();
		$query = 'SELECT DISTINCT %s FROM %s';
		$query = sprintf($query, ClassTablePeer::FACULTY, ClassTablePeer::TABLE_NAME);
		$statement = $connection->prepare($query);
		$statement->execute();
		$i = 0;
		while ($row = $statement->fetch(PDO::FETCH_NUM))
		{
			$faculties[$i] = $row[0];
			++$i;
		}
		/* WTF??? */

// 		$c = new Criteria();
// 		$c->clearSelectColumns();
//         	$c->addSelectColumn(ClassTablePeer::ID);
//         	$c->addSelectColumn(ClassTablePeer::NAME);
//         	$c->addSelectColumn(ClassTablePeer::FACULTY);
//         	$c->addSelectColumn(ClassTablePeer::PROFESSION_ID);
// 		$c->setDistinct();
// 		$faculties = ClassTablePeer::doSelect($c);
// 		print $this->faculties[0]->getId().'\n';
// 		print $this->faculties[0]->getName().'\n';
// 		print $this->faculties[0]->getFaculty().'\n';
// 		print $this->faculties[0]->getProfessionId().'\n';
// 		$i = 0;
// 		print_r($faculties);
/*		foreach($faculties as $f) {
			print $f->getFaculty();
			print $i;++$i; print_r($f);
		}*/
		return $faculties;

	}
}
