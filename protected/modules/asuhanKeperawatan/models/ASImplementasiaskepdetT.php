<?php
class ASImplementasiaskepdetT extends ImplementasiaskepdetT
{
	
	public $diagnosakep_nama,$iskolaborasi,$rencanaaskepdet_ketkolaborasi,$rencanaaskep_id,$isdiagnosa,$intervensi_id,$intervensi_nama
			,$indikatorimplkepdet_id,$evaluasiaskepdet_subjektif,$evaluasiaskepdet_objektif,$evaluasiaskepdet_assessment,$evaluasiaskepdet_planning,$evaluasiaskepdet_hasil,
			$evaluasiaskep_id,$alternatifdx_id, $implementasikep_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}