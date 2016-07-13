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
		
                
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		
		$criteria->compare('LOWER(t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		
                if (empty($this->penerimaanlinen_id) && empty($this->perawatanlinen_id)) {
                    if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                        $criteria->addBetweenCondition('DATE(t.tglpenerimaanlinen)', $this->tgl_awal, $this->tgl_akhir);
                    }
                    
                    if (!empty($this->jenisperawatan)){
                            $criteria->compare('LOWER(t.jenisperawatanlinen)',strtolower($this->jenisperawatan));
                    } else {
                            $criteria->addCondition("t.jenisperawatanlinen = '".Params::JENISPERAWATAN_DEKONTAMINASI."'");
                    }
                    
                    // $criteria->addCondition("t.statusperawatanlinen = '".Params::STATUSPERAWATAN_SELESAI."'");
                } else if (!empty($this->penerimaanlinen_id)) {
                    $criteria->group = $criteria->select = "t.penerimaanlinen_id, t.linen_id, t.penerimaanlinen_id, t.ruangan_nama, t.nopenerimaanlinen, t.kodelinen, namalinen, t.keteranganpenerimaanlinen_item, t.jenisperawatanlinen";
                }
                
                $criteria->compare('t.perawatanlinen_id', $this->perawatanlinen_id);
                $criteria->compare('t.penerimaanlinen_id', $this->penerimaanlinen_id);
                
                $criteria->join = 'left join pencuciandetail_t p on p.penerimaanlinen_id = t.penerimaanlinen_id and p.linen_id = t.linen_id';
                $criteria->addCondition('p.pencuciandetail_id is null');
                
                $criteria->limit = -1;
                
                // var_dump($criteria); die;
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'pagination'=>false,
		));
	}
}