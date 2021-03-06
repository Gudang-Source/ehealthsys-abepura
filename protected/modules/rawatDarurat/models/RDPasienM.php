<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RDPasienM extends PasienM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public $umur;
//    public $tgl_rm_awal;
//    public $tgl_rm_akhir;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('no_rekam_medik, tgl_rekam_medik, jenisidentitas, nama_pasien, tanggal_lahir, alamat_pasien, agama, 
                          warga_negara, statusrekammedis, create_ruangan, kabupaten_id, kelurahan_id, propinsi_id, kecamatan_id,
                          jeniskelamin', 'required'),
                    array('pekerjaan_id, kelurahan_id, pendidikan_id, propinsi_id, kecamatan_id, suku_id, profilrs_id, kabupaten_id, rt, rw, anakke, jumlah_bersaudara', 'numerical', 'integerOnly'=>true),
                    array('no_rekam_medik, statusrekammedis', 'length', 'max'=>10),
                    array('jenisidentitas, namadepan, jeniskelamin, kelompokumur_id, statusperkawinan, agama, rhesus, no_mobile_pasien', 'length', 'max'=>20),
                    array('no_identitas_pasien, nama_bin', 'length', 'max'=>30),
                    array('nama_pasien', 'length', 'max'=>50),
                    array('tempat_lahir, warga_negara', 'length', 'max'=>25),
                    array('golongandarah', 'length', 'max'=>2),
                    array('no_telepon_pasien', 'length', 'max'=>15),
                    array('photopasien', 'length', 'max'=>200),
                    array('alamatemail', 'length', 'max'=>100),
                    array('update_time, update_loginpemakai_id, tgl_meninggal,tgl_rm_awal,tgl_rm_akhir', 'safe'),

                    array('create_time, tgl_rekam_medik','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                    array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                    array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                    array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update'),
                    array('no_telepon_pasien', 'match', 'pattern'=>"/^([0-9()]*)$/", 'message'=>'Hanya inputan numerik, "(", ")",dan "+" yang diperbolehkan'),
                    array('no_mobile_pasien', 'match', 'pattern'=>"/^([0-9+]*)$/", 'message'=>'Hanya inputan numerik dan "+" yang diperbolehkan'),

                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('pasien_id, pekerjaan_id, kelurahan_id, pendidikan_id, propinsi_id, kecamatan_id, suku_id, profilrs_id, kabupaten_id, no_rekam_medik, tgl_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, kelompokumur, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, statusrekammedis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_meninggal', 'safe', 'on'=>'search'),
                    array('propinsiNama, kabupatenNama, kecamatanNama, kelurahanNama','safe','on'=>'searchWithDaerah'),
                    array('tgl_rm_awal, tgl_rm_akhir','safe','on'=>'searchPasien'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                    'pasien_id' => 'Pasien',
                    'pekerjaan_id' => 'Pekerjaan',
                    'kelurahan_id' => 'Kelurahan',
                    'pendidikan_id' => 'Pendidikan',
                    'propinsi_id' => 'Propinsi',
                    'kecamatan_id' => 'Kecamatan',
                    'suku_id' => 'Suku',
                    'profilrs_id' => 'Profilrs',
                    'kabupaten_id' => 'Kota / Kabupaten',
                    'no_rekam_medik' => 'No. Rekam Medik',
                    'tgl_rekam_medik' => 'Tgl. Rekam Medik',
                    'jenisidentitas' => 'Jenis Identitas',
                    'no_identitas_pasien' => 'No. Identitas',
                    'namadepan' => 'Nama Depan',
                    'nama_pasien' => 'Nama Pasien',
                    'nama_bin' => 'Alias',
                    'jeniskelamin' => 'Jenis Kelamin',
                    'kelompokumur_id' => 'Kelompok Umur',
                    'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'alamat_pasien' => 'Alamat Pasien',
                    'rt' => 'RT/RW',
                    'rw' => 'Rw',
                    'statusperkawinan' => 'Status Perkawinan',
                    'agama' => 'Agama',
                    'golongandarah' => 'Golongan Darah',
                    'rhesus' => 'Rhesus',
                    'anakke' => 'Anak ke',
                    'jumlah_bersaudara' => 'Jumlah Bersaudara',
                    'no_telepon_pasien' => 'No. Telepon',
                    'no_mobile_pasien' => 'No. Mobile',
                    'warga_negara' => 'Warga Negara',
                    'photopasien' => '',
                    'alamatemail' => 'Alamat Email',
                    'statusrekammedis' => 'Status Rekam medis',
                    'create_time' => 'Create Time',
                    'update_time' => 'Update Time',
                    'create_loginpemakai_id' => 'Create Loginpemakai',
                    'update_loginpemakai_id' => 'Update Loginpemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'tgl_meninggal' => 'Tgl. Meninggal',
                    'tgl_rm_awal' => 'Tgl. Rekam Medik',
                    'tgl_rm_akhir' => 's/d',
            );
    }
    
     /**
      * 
      * @param type $cek mixed array
      * @return CActiveDataProvider 
      */
     public function searchPasien(){
         
            $criteria=new CDbCriteria;
//            $criteria->addBetweenCondition('tgl_rekam_medik', $this->tgl_rm_awal, $this->tgl_rm_akhir);
            $criteria->addCondition('tgl_rekam_medik BETWEEN \''.$this->tgl_rm_awal.'\' AND \''.$this->tgl_rm_akhir.'\'');
            $criteria->compare('TRIM(no_rekam_medik)', trim($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id);				
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id);				
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);				
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id);				
			}
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
            $criteria->with = array('propinsi','kabupaten','kecamatan','kelurahan');
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
		
		/**
		* Mengambil daftar semua propinsi
		* @return CActiveDataProvider 
		*/
		public function getPropinsiItems()
		{
		   return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
		}
		/**
		* Mengambil daftar semua kabupaten berdasarkan propinsi
		* @return CActiveDataProvider 
		*/
		public function getKabupatenItems($propinsi_id=null)
		{
		   $criteria = new CDbCriteria();
		   if(!empty($propinsi_id)){
			   $criteria->addCondition("propinsi_id = ".$propinsi_id); 			
		   }
		   $criteria->compare('kabupaten_aktif', true);
		   $criteria->order='kabupaten_nama';
		   $models = KabupatenM::model()->findAll($criteria);
		   return $models;
		}
	   /**
		* Mengambil daftar semua kecamatan berdasarkan kabupaten
		* @return CActiveDataProvider 
		*/
		public function getKecamatanItems($kabupaten_id=null)
		{
		   $criteria = new CDbCriteria();
		   if(!empty($kabupaten_id)){
			   $criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
		   }
		   $criteria->compare('kecamatan_aktif', true);
		   $criteria->order='kecamatan_nama';
		   $models = KecamatanM::model()->findAll($criteria);
		   return $models;
		}
		/**
		* Mengambil daftar semua kelurahan berdasarkan kecamatan
		* @return CActiveDataProvider 
		*/
		public function getKelurahanItems($kecamatan_id=null)
		{
		   $criteria = new CDbCriteria();
		   if(!empty($kecamatan_id)){
			   $criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
		   }
		   $criteria->compare('kelurahan_aktif', true);
		   $criteria->order='kelurahan_nama';
		   $models = KelurahanM::model()->findAll($criteria);
		   return $models;
		}
  }
?>
