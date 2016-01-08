<?php

class SAPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
    public $tempPhoto;
	public $getNoKeputusan;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	/**
	 * untuk pemilihan pegawai di:
	 * - master organigram
	 * @return \CActiveDataProvider
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('pegawai_aktif',true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				));
	}

    public function getKabupatenItems($propinsi_id=null){
        if (!empty($propinsi_id)) {
            return KabupatenM::model()->findAllByAttributes (array('kabupaten_aktif'=>TRUE, 'propinsi_id'=>$propinsi_id), array('order'=>'kabupaten_nama asc'));
        } else if(!empty($this->propinsi_id)) {     
            return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama asc');
        } else {
            return array();
        }  
    }
    public function getKecamatanItems($kabupaten_id=null){
        if (!empty($kabupaten_id))
            return KecamatanM::model()->findAllByAttributes (array('kecamatan_aktif'=>TRUE, 'kabupaten_id'=>$kabupaten_id), array('order'=>'kecamatan_nama asc'));
        else
            return KecamatanM::model()->findAll('kecamatan_aktif=TRUE ORDER BY kecamatan_nama asc');
    }
    public function getKelurahanItems($kecamatan_id=null){
        if (!empty($kecamatan_id))
            return KelurahanM::model()->findAllByAttributes (array('kelurahan_aktif'=>TRUE, 'kecamatan_id'=>$kecamatan_id),array('order'=>'kelurahan_nama asc'));
        else
            return KelurahanM::model()->findAll('kelurahan_aktif=TRUE ORDER BY kelurahan_nama asc');
    }   
    
    /**
     * Overide function karena ada format tanggal yang salah saat simpan / update
     */
    protected function beforeValidate ()
    {
        return parent::beforeSave();
    }
    public function beforeSave() 
    {
        return parent::beforeSave();
    }

	public function getNoKeputusan(){
		$modPegJab = PegawaijabatanR::model()->findByAttributes (array('pegawai_id'=>$this->pegawai_id), array('order'=>'tglditetapkanjabatan DESC'));
		$nomorkeputusan = isset($modPegJab->nomorkeputusanjabatan) ? $modPegJab->nomorkeputusanjabatan : "";
		return $nomorkeputusan; 
	}	
	
}