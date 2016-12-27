<?php

/**
 * This is the model class for table "buatjanjipoli_t".
 *
 * The followings are the available columns in table 'buatjanjipoli_t':
 * @property integer $buatjanjipoli_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property string $tglbuatjanji
 * @property string $harijadwal
 * @property string $tgljadwal
 * @property boolean $byphone
 * @property string $keteranganbuatjanji
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PPBuatJanjiPoliT extends BuatjanjipoliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BuatjanjipoliT the static model class
	 */
        public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=new CDbCriteria;
                
                $criteria->addBetweenCondition('DATE(tglbuatjanji)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
                if (!empty($this->ruangan_id)){
                    $criteria->addCondition(" t.ruangan_id = '".$this->ruangan_id."' ");
                }
                $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->with=array('pegawai','ruangan','pasien');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
		/**
		 * kriteria pencarian untuk dashboard
		 * @return \CActiveDataProvider
		 */
		public function searchDashboard()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('DATE(tglbuatjanji)', date("Y-m-d"));
			$criteria->with=array('pegawai','ruangan','pasien');
			$criteria->order = 'tglbuatjanji ASC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
		}
        
        /**
        * untuk nilai grafik kotak Buat Janji Poli
        * @return CActiveDataProvider : jumlah
        */
        public function searchKotakJanjiPoli(){
            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('DATE(create_time)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->select = 'count(buatjanjipoli_id) as data';
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        public function getNamaAlias($nama,$alias){
            if(!empty($alias)){
                return $nama.' Alias '.$alias;
            }else{
                return $nama;
            }
        }
        

}

?>