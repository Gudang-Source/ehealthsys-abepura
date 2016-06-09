<?php
class ASRencanaaskepdetT extends RencanaaskepdetT
{
	public $diagnosakep_nama,$tandagejala_id,$diagnosakep_kode,
			$iskriteria,$kriteriahasildet_id,$intervensidet_id,
			$rencanaaskep_ir,$rencanaaskep_er,$istandagejala,
			$kriteriadet_id,$isintervensi,$tujuan_nama,$kriteriahasil_nama,$intervensi_nama,$isdiagnosa,$implementasikep_id,
			$indikatorimplkepdet_id,$alternatifdx_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}