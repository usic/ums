<?php

class ProfessionsTablePeer extends BaseProfessionsTablePeer
{
	/* returns fields required for the registration of given status */

	static public function getAddingFields($id)
	{
		if (in_array($id, self::studentreaderField()))
			return array('student_card','reader_card','error'=>'You must give either student or reader card.');

		elseif (in_array($id, self::readerField()))
			return array('reader_card','error'=>'You must give reader card.');

		elseif (in_array($id, self::readerpassportField()))
			return array('reader_card','passport','error'=>'You must give either passport or reader card.');

		elseif (in_array($id, self::passportField()))
			return array('passport','error'=>'You must give passport.');
		else return array('error'=>'no such status');
	}
	//bachelor(0), master(1) => either student or reader card
	static public function studentreaderField()
	{
		return array('0','1');
	}
	//candidate(2), preparatory school(6) => reader card	
	static public function readerField()
	{
		return array('2','6');
	}
	//teacher(3), employee(4) => either reader card or passport
	static public function readerpassportField()
	{
		return array('3','4');
	}
	//graduate(5), sponsor(7) => passport
	static public function passportField()
	{
		return array('5','7');
	}
}
