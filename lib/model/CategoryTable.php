<?php

class CategoryTable extends BaseCategoryTable
{
	public function __toString()
	{
		return $this->name;
	}
}
