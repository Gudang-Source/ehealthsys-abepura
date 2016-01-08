 <?php

/**
 * This is the model class for table "pasienpelayanandokterrs_v".
 *
 * The followings are the available columns in table 'pasienpelayanandokterrs_v':
 * @property integer $pasien_id
 * @property integer $profilrs_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $tindakanpelayanan_id
 * @property string $tgl_tindakan
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property integer $qty_tindakan
 * @property string $satuantindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $tindakankomponen_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $iurbiayakomp
 * @property double $tarif_tindakankomp
 * @property double $tarifcyto_tindakankomp
 * @property double $tarif_kompsatuan
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 */
class MOPasienpelayanandokterrsV extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOPasienpelayanandokterrsV the static model class
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
        return 'pasienpelayanandokterrs_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, profilrs_id, rt, rw, pendaftaran_id, kelaspelayanan_id, tindakanpelayanan_id, qty_tindakan, instalasi_id, penjamin_id, daftartindakan_id, kategoritindakan_id, tindakankomponen_id, komponentarif_id, pegawai_id, gelarbelakang_id', 'numerical', 'integerOnly'=>true),
            array('tarif_satuan, tarif_tindakan, tarifcyto_tindakan, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan', 'numerical'),
            array('no_rekam_medik, satuantindakan, gelardepan', 'length', 'max'=>10),
            array('namadepan, jeniskelamin, no_pendaftaran, daftartindakan_kode', 'length', 'max'=>20),
            array('nama_pasien, kelaspelayanan_nama, instalasi_nama, penjamin_nama, nama_pegawai, nama_keluarga', 'length', 'max'=>50),
            array('nama_bin, umur', 'length', 'max'=>30),
            array('tempat_lahir, komponentarif_nama', 'length', 'max'=>25),
            array('daftartindakan_nama', 'length', 'max'=>200),
            array('kategoritindakan_nama', 'length', 'max'=>150),
            array('gelarbelakang_nama', 'length', 'max'=>15),
            array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgl_tindakan, cyto_tindakan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasien_id, profilrs_id, no_rekam_medik, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, kelaspelayanan_id, kelaspelayanan_nama, tindakanpelayanan_id, tgl_tindakan, tarif_satuan, tarif_tindakan, qty_tindakan, satuantindakan, cyto_tindakan, tarifcyto_tindakan, instalasi_id, instalasi_nama, penjamin_id, penjamin_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, kategoritindakan_id, kategoritindakan_nama, tindakankomponen_id, komponentarif_id, komponentarif_nama, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan, pegawai_id, gelardepan, nama_pegawai, nama_keluarga, gelarbelakang_id, gelarbelakang_nama', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasien_id' => 'Pasien',
            'profilrs_id' => 'Profilrs',
            'no_rekam_medik' => 'No Rekam Medik',
            'tgl_rekam_medik' => 'Tgl Rekam Medik',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
            'nama_bin' => 'Nama Bin',
            'jeniskelamin' => 'Jeniskelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat Pasien',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'pendaftaran_id' => 'Pendaftaran',
            'no_pendaftaran' => 'No Pendaftaran',
            'tgl_pendaftaran' => 'Tgl Pendaftaran',
            'umur' => 'Umur',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
            'tindakanpelayanan_id' => 'Tindakanpelayanan',
            'tgl_tindakan' => 'Tgl Tindakan',
            'tarif_satuan' => 'Tarif Satuan',
            'tarif_tindakan' => 'Tarif Tindakan',
            'qty_tindakan' => 'Qty Tindakan',
            'satuantindakan' => 'Satuantindakan',
            'cyto_tindakan' => 'Cyto Tindakan',
            'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin Nama',
            'daftartindakan_id' => 'Daftartindakan',
            'daftartindakan_kode' => 'Daftartindakan Kode',
            'daftartindakan_nama' => 'Daftartindakan Nama',
            'kategoritindakan_id' => 'Kategoritindakan',
            'kategoritindakan_nama' => 'Kategoritindakan Nama',
            'tindakankomponen_id' => 'Tindakankomponen',
            'komponentarif_id' => 'Komponentarif',
            'komponentarif_nama' => 'Komponentarif Nama',
            'iurbiayakomp' => 'Iurbiayakomp',
            'tarif_tindakankomp' => 'Tarif Tindakankomp',
            'tarifcyto_tindakankomp' => 'Tarifcyto Tindakankomp',
            'tarif_kompsatuan' => 'Tarif Kompsatuan',
            'pegawai_id' => 'Pegawai',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'nama_keluarga' => 'Nama Keluarga',
            'gelarbelakang_id' => 'Gelarbelakang',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        if(!empty($this->profilrs_id)){
            $criteria->addCondition('profilrs_id = '.$this->profilrs_id);
        }
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
        $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
        $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
        $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
        if(!empty($this->rt)){
            $criteria->addCondition('rt = '.$this->rt);
        }
        if(!empty($this->rw)){
            $criteria->addCondition('rw = '.$this->rw);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        if(!empty($this->tindakanpelayanan_id)){
            $criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
        }
        $criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
        $criteria->compare('tarif_satuan',$this->tarif_satuan);
        $criteria->compare('tarif_tindakan',$this->tarif_tindakan);
        if(!empty($this->qty_tindakan)){
            $criteria->addCondition('qty_tindakan = '.$this->qty_tindakan);
        }
        $criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
        $criteria->compare('cyto_tindakan',$this->cyto_tindakan);
        $criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
        if(!empty($this->instalasi_id)){
            $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
        }
        $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id = '.$this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
        if(!empty($this->daftartindakan_id)){
            $criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
        }
        $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        if(!empty($this->kategoritindakan_id)){
            $criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
        }
        $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
        if(!empty($this->tindakankomponen_id)){
            $criteria->addCondition('tindakankomponen_id = '.$this->tindakankomponen_id);
        }
        if(!empty($this->komponentarif_id)){
            $criteria->addCondition('komponentarif_id = '.$this->komponentarif_id);
        }
        $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
        $criteria->compare('iurbiayakomp',$this->iurbiayakomp);
        $criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
        $criteria->compare('tarifcyto_tindakankomp',$this->tarifcyto_tindakankomp);
        $criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
        if(!empty($this->gelarbelakang_id)){
            $criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
        }
        $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);

        return $criteria;
    }
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}