<?php
class LAPenerimaanpencucianlinenV extends PenerimaanpencucianlinenV
{
	public $tgl_awal,$tgl_akhir,$jenisperawatan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPencucianLinen()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$format = new MyFormatter();
		$this->tgl_awal		= $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir	= $format->formatDateTimeForDb($this->tgl_akhir);
		
		$criteria->limit=1000;
		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}
		
		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)', $this->tgl_awal, $this->tgl_akhir,true);
		
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		
		$criteria->compare('LOWER(nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		
		if(!empty($this->jenisperawatan)){
			$criteria->compare('LOWER(jenisperawatanlinen)',strtolower($this->jenisperawatan));
		}else{
			$criteria->addCondition("jenisperawatanlinen = '".Params::JENISPERAWATAN_DEKONTAMINASI."'");
		}
		
		$criteria->addCondition("statusperawatanlinen = '".Params::STATUSPERAWATAN_SELESAI."'");

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}