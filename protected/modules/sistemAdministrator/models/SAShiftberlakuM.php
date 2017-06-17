<?php
/**
 * @type model -- digunakan untuk mengelola data pada tabel shiftberlaku_m dan hanya berlaku pada modul kepegawaian
 * @author Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website <http://piindonesia.co.id>
 */

class SAShiftberlakuM extends ShiftberlakuM
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
}