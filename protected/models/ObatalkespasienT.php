<?php

/**
 * This is the model class for table "obatalkespasien_t".
 *
 * The followings are the available columns in table 'obatalkespasien_t':
 * @property integer $obatalkespasien_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property integer $daftartindakan_id
 * @property integer $sumberdana_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $satuankecil_id
 * @property integer $ruangan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $tipepaket_id
 * @property integer $obatalkes_id
 * @property integer $penjualanresep_id
 * @property integer $pegawai_id
 * @property integer $racikan_id
 * @property integer $pendaftaran_id
 * @property integer $kelaspelayanan_id
 * @property integer $shift_id
 * @property integer $pasienadmisi_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property integer $permintaan_oa
 * @property integer $jmlkemasan_oa
 * @property integer $kekuatan_oa
 * @property string $satuankekuatan_oa
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $jmlexposerad
 * @property string $kontrasrad
 * @property double $biayaservice
 * @property double $biayakonseling
 * @property double $jasadokterresep
 * @property double $biayakemasan
 * @property double $biayaadministrasi
 * @property double $tarifcyto
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruanganj
 * @property integer $permohonanoadetail_id
 */
class ObatalkespasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkespasienT the static model class
	 */
        public $subtotal,$diskon,$totaltarifservice,$tarif_satuan,$discount_tindakan,$qty_tindakan,$tarifcyto_tindakan,$iurbiaya_tindakan,$tgl_tindakan;
        public $is_pilihoa;
        public $biayalain = 0;
        public $subtotaloa=0;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'obatalkespasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, carabayar_id, sumberdana_id, pasien_id, ruangan_id, tipepaket_id, obatalkes_id, shift_id, tglpelayanan', 'required'),
			array('penjamin_id, carabayar_id, daftartindakan_id, sumberdana_id, pasienmasukpenunjang_id, pasienanastesi_id, pasien_id, satuankecil_id, ruangan_id, tindakanpelayanan_id, tipepaket_id, obatalkes_id, penjualanresep_id, pegawai_id, racikan_id, pendaftaran_id, kelaspelayanan_id, shift_id, pasienadmisi_id, rke, permohonanoadetail_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, jmlexposerad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, permintaan_oa, jmlkemasan_oa, kekuatan_oa', 'numerical'),
			array('r, oa', 'length', 'max'=>2),
			array('satuankekuatan_oa, kontrasrad', 'length', 'max'=>20),
			array('signa_oa', 'length', 'max'=>30),
			array('etiket', 'length', 'max'=>100),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, discount, create_ruangan', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('qty_oa','cekStok','on'=>'retail'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkespasien_id, is_pilihoa, penjamin_id, subtotal, diskon, totaltarifservice, carabayar_id, daftartindakan_id, sumberdana_id, pasienmasukpenunjang_id, pasienanastesi_id, pasien_id, satuankecil_id, ruangan_id, tindakanpelayanan_id, tipepaket_id, obatalkes_id, penjualanresep_id, pegawai_id, racikan_id, pendaftaran_id, kelaspelayanan_id, shift_id, pasienadmisi_id, tglpelayanan, r, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, satuankekuatan_oa, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, jmlexposerad, kontrasrad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permohonanoadetail_id', 'safe', 'on'=>'search'),
		);
	}
        
        protected function afterSave() {
            parent::afterSave();
            
            if (!empty($this->pendaftaran)) $this->checkSudahbayar();
        }
        
        function checkSudahBayar() {
            $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
            
            $adm = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran->pendaftaran_id));
            
            if ($this->cekTindakanOa()) {
                // echo $this->pendaftaran_id; die;
                PendaftaranT::model()->updateByPk($this->pendaftaran_id, array(
                    'pembayaranpelayanan_id'=>null,
                ));
                if (!empty($adm)) {
                    PasienadmisiT::model()->updateByPk($adm->pasienadmisi_id, array(
                        'pembayaranpelayanan_id'=>null,
                    ));
                }
            }
        }

        function cekTindakanOa() {
            $tindakan = self::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'tindakansudahbayar_id is null',
            ));
            
            $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'oasudahbayar_id is null',
            ));
            
            return (count($tindakan) + count($oa)) > 0;
        }
        
        public function cekStok(){
            if (!$this->hasErrors()){
                $stok = StokobatalkesT::getJumlahStok($this->obatalkes_id);
//                if ($stok < 0){
//                    $this->addError('qty', 'Stok Barang tidak ada' );
//                }
//                if ($this->qty_oa > $stok){
//                    $this->addError('qty_oa', 'Barang tidak boleh lebih dari '.$stok);
//                }
                
                if ($this->discount > $this->hargajual_oa){
                    $this->addError('discount', 'Discount tidak boleh lebih besar dari '.$this->hargajual_oa);
                }
                // di comment tgl 1 April 2013 //
                if ($this->qty_oa <= 0){
                    $this->addError('qty_oa', 'Quantity tidak boleh kurang dari 1');
                }
                
                // end dicomment //
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
                    'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
                    'penjualanresep'=>array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'), //untuk handling relasi dengan penjualan resep
                    'oasudahbayar'=>array(self::BELONGS_TO, 'OasudahbayarT', 'oasudahbayar_id'), // handling relasi dengan oasudahbayar
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
                    'racikan'=>array(self::BELONGS_TO, 'RacikanM','racikan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkespasien_id' => 'Obatalkespasien',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Carabayar',
			'daftartindakan_id' => 'Daftartindakan',
			'sumberdana_id' => 'Sumberdana',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'satuankecil_id' => 'Satuankecil',
			'ruangan_id' => 'Ruangan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tipepaket_id' => 'Tipepaket',
			'obatalkes_id' => 'Obatalkes',
			'penjualanresep_id' => 'Penjualanresep',
			'pegawai_id' => 'Pegawai',
			'racikan_id' => 'Racikan',
			'pendaftaran_id' => 'Pendaftaran',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'shift_id' => 'Shift',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglpelayanan' => 'Tanggal Pelayanan',
			'r' => 'R',
			'rke' => 'Rke',
			'permintaan_oa' => 'Permintaan Oa',
			'jmlkemasan_oa' => 'Jmlkemasan Oa',
			'kekuatan_oa' => 'Kekuatan Oa',
			'satuankekuatan_oa' => 'Satuankekuatan Oa',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'signa_oa' => 'Signa Oa',
			'harganetto_oa' => 'Harganetto Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'etiket' => 'Etiket',
			'jmlexposerad' => 'Jmlexposerad',
			'kontrasrad' => 'Kontrasrad',
			'biayaservice' => 'Biayaservice',
			'biayakonseling' => 'Biayakonseling',
			'jasadokterresep' => 'Jasadokterresep',
			'biayakemasan' => 'Biayakemasan',
			'biayaadministrasi' => 'Biayaadministrasi',
			'tarifcyto' => 'Tarifcyto',
			'discount' => 'Discount',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
			'oa' => 'Oa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_oa',$this->permintaan_oa);
		$criteria->compare('jmlkemasan_oa',$this->jmlkemasan_oa);
		$criteria->compare('kekuatan_oa',$this->kekuatan_oa);
		$criteria->compare('LOWER(satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('jmlexposerad',$this->jmlexposerad);
		$criteria->compare('LOWER(kontrasrad)',strtolower($this->kontrasrad),true);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tarifcyto',$this->tarifcyto);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
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
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_oa',$this->permintaan_oa);
		$criteria->compare('jmlkemasan_oa',$this->jmlkemasan_oa);
		$criteria->compare('kekuatan_oa',$this->kekuatan_oa);
		$criteria->compare('LOWER(satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('jmlexposerad',$this->jmlexposerad);
		$criteria->compare('LOWER(kontrasrad)',strtolower($this->kontrasrad),true);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tarifcyto',$this->tarifcyto);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
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
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {
                if (!strlen($this->$columnName)) continue;
                if ($column->dbType == 'date')
                {
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                }
            }
            return true;
        }
        
        protected function beforeValidate ()
        {
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {
                if ($column->dbType == 'date')
                {
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
            }
            return parent::beforeValidate();
        }
        //Jika gagal memanggil nama obat
        public function getInfoObat($id){
            $modObat = ObatalkesM::model()->findByPk($id);
            if(!empty($modObat->obatalkes_id)){
                return $modObat->obatalkes_kode." - ".$modObat->obatalkes_nama;
            }else{
                return "";
            }
        }
}