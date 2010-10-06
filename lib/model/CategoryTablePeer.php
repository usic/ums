<?php

class CategoryTablePeer extends BaseCategoryTablePeer
{
	static public function defaultCategory()
	{
		$c = new Criteria(CategoryTablePeer::DATABASE_NAME);
		$c->add(CategoryTablePeer::NAME, 'unknown');
		return CategoryTablePeer::doSelectOne($c);
	}
}
