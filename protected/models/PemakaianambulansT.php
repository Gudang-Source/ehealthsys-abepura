<?php

/**
 * This is the model class for table "pemakaianambulans_t".
 *
 * The followings are the available columns in table 'pemakaianambulans_t':
 * @property integer $pemakaianambulans_id
 * @property integer $batalpakaiambulans_id
 * @property integer $mobilambulans_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pesanambulans_t
 * @property integer $pendaftaran_id
 * @property string $tglpemakaianambulans
 * @property string $noidentitas
 * @property string $norekammedis
 * @property string $namapasien
 * @property string $tempattujuan
 * @property string $kelurahan_nama
 * @property string $alamattujuan
 * @property string $rt_rw
 * @property string $nomobile
 * @property string $notelepon
 * @property string $namapj
 * @property string $hubunganpj
 * @property string $alamatpj
 * @property integer $supir_id
 * @property integer $pelaksana_id
 * @property string $paramedis1_id
 * @property string $paramedis2_id
 * @property double $kmawal
 * @property double $kmakhir
 * @property double $jmlbbmliter
 * @property double $jumlahkm
 * @property double $tarifperkm
 * @property double $totaltarifambulans
 * @property string $tglkembaliambulans
 * @property string $untukkeperluan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PemakaianambulansT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $nopolisi;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianambulansT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemakaianambulans_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobilambulans_id, ruangan_id, tglpemakaianambulans, namapasien, tempattujuan, alamattujuan, rt_rw, nomobile, supir_id, jumlahkm, tarifperkm, totaltarifambulans', 'required'),
			array('batalpakaiambulans_id, mobilambulans_id, pasien_id, ruangan_id, pesanambulans_t, pendaftaran_id, supir_id, pelaksana_id,paramedis1_id, paramedis2_id', 'numerical', 'integerOnly'=>true),
			array('kmawal, kmakhir, jmlbbmliter, jumlahkm, tarifperkm, totaltarifambulans', 'numerical'),
			array('noidentitas, namapasien, nomobile, notelepon, namapj', 'length', 'max'=>100),
			array('norekammedis', 'length', 'max'=>10),
			array('tempattujuan, kelurahan_nama, hubunganpj', 'length', 'max'=>50),
			array('rt_rw', 'length', 'max'=>20),
			array('alamatpj,tglkembaliambulans, daftartindakanId, untukkeperluan, update_time, update_loginpemakai_id,longitude,latitude', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nopolisi, pemakaianambulans_id, batalpakaiambulans_id, mobilambulans_id, daftartindakanId,  pasien_id, ruangan_id, pesanambulans_t, pendaftaran_id, tglpemakaianambulans, noidentitas, norekammedis, namapasien, tempattujuan, kelurahan_nama, alamattujuan, rt_rw, nomobile, notelepon, namapj, hubunganpj, alamatpj, supir_id, pelaksana_id, paramedis1_id, paramedis2_id, kmawal, kmakhir, jmlbbmliter, jumlahkm, tarifperkm, totaltarifambulans, tglkembaliambulans, untukkeperluan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan,longitude,latitude', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'mobil'=>array(self::BELONGS_TO, 'MobilambulansM','mobilambulans_id'),
                    'supir'=>array(self::BELONGS_TO, 'PegawaiM','supir_id'),
                    'paramedis1'=>array(self::BELONGS_TO, 'PegawaiM','paramedis1_id'),
                    'paramedis2'=>array(self::BELONGS_TO, 'PegawaiM','paramedis2_id'),
                    'ruanganpemesan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'pelaksana'=>array(self::BELONGS_TO,'PegawaiM','pelaksana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianambulans_id' => 'ID Pemakaian Ambulans',
			'batalpakaiambulans_id' => 'Batal Pakai',
			'mobilambulans_id' => 'Mobil Ambulans',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'pesanambulans_t' => 'Pesanambulans T',
			'pendaftaran_id' => 'Pendaftaran',
			'tglpemakaianambulans' => 'Tanggal Pemakaian Ambulans',
			'noidentitas' => 'No. Identitas',
			'norekammedis' => 'No. Rekam Medis',
			'namapasien' => 'Nama Pasien',
			'tempattujuan' => 'Tempat Tujuan',
			'kelurahan_nama' => 'Kelurahan',
			'alamattujuan' => 'Alamat Tujuan',
			'rt_rw' => 'Rt / Rw',
			'nomobile' => 'No. Mobile',
			'notelepon' => 'No. Telepon',
			'namapj' => 'Nama PJ',
			'hubunganpj' => 'Hubungan PJ',
			'alamatpj' => 'Alamat PJ',
			'supir_id' => 'Supir',
			'pelaksana_id' => 'Pelaksana',
			'paramedis1_id' => 'Paramedis 1',
			'paramedis2_id' => 'Paramedis 2',
			'kmawal' => 'Km Awal',
			'kmakhir' => 'Km Akhir',
			'jmlbbmliter' => 'Jml BBM Liter',
			'jumlahkm' => 'Jumlah Km',
			'tarifperkm' => 'Tarif / Km',
			'totaltarifambulans' => 'Total Tarif Ambulans',
			'tglkembaliambulans' => 'Tanggal Kembali Ambulans',
			'untukkeperluan' => 'Untuk Keperluan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tgl_awal'=>'Tanggal Awal',
                        'tgl_akhir'=>'Tanggal Akhir',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('batalpakaiambulans_id',$this->batalpakaiambulans_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(namapj)',strtolower($this->namapj),true);
		$criteria->compare('LOWER(hubunganpj)',strtolower($this->hubunganpj),true);
		$criteria->compare('LOWER(alamatpj)',strtolower($this->alamatpj),true);
		$criteria->compare('supir_id',$this->supir_id);
		$criteria->compare('pelaksana_id',$this->pelaksana_id);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
		$criteria->compare('kmawal',$this->kmawal);
		$criteria->compare('kmakhir',$this->kmakhir);
		$criteria->compare('jmlbbmliter',$this->jmlbbmliter);
		$criteria->compare('jumlahkm',$this->jumlahkm);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('totaltarifambulans',$this->totaltarifambulans);
		$criteria->compare('LOWER(tglkembaliambulans)',strtolower($this->tglkembaliambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('batalpakaiambulans_id',$this->batalpakaiambulans_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(namapj)',strtolower($this->namapj),true);
		$criteria->compare('LOWER(hubunganpj)',strtolower($this->hubunganpj),true);
		$criteria->compare('LOWER(alamatpj)',strtolower($this->alamatpj),true);
		$criteria->compare('supir_id',$this->supir_id);
		$criteria->compare('pelaksana_id',$this->pelaksana_id);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
		$criteria->compare('kmawal',$this->kmawal);
		$criteria->compare('kmakhir',$this->kmakhir);
		$criteria->compare('jmlbbmliter',$this->jmlbbmliter);
		$criteria->compare('jumlahkm',$this->jumlahkm);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('totaltarifambulans',$this->totaltarifambulans);
		$criteria->compare('LOWER(tglkembaliambulans)',strtolower($this->tglkembaliambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}