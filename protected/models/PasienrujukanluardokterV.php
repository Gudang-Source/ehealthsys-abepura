<?php

/**
 * This is the model class for table "pasienrujukanluardokter_v".
 *
 * The followings are the available columns in table 'pasienrujukanluardokter_v':
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
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $statusperiksa
 * @property integer $rujukan_id
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $rujukandari_id
 * @property string $namaperujuk
 * @property string $spesialis
 * @property string $alamatlengkap
 */
class PasienrujukanluardokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienrujukanluardokterV the static model class
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
		return 'pasienrujukanluardokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, profilrs_id, rt, rw, pendaftaran_id, kelaspelayanan_id, tindakanpelayanan_id, qty_tindakan, instalasi_id, penjamin_id, daftartindakan_id, kategoritindakan_id, tindakankomponen_id, komponentarif_id, pasienmasukpenunjang_id, rujukan_id, asalrujukan_id, rujukandari_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan, tarif_tindakan, tarifcyto_tindakan, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan', 'numerical'),
			array('no_rekam_medik, satuantindakan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, daftartindakan_kode, no_masukpenunjang', 'length', 'max'=>20),
			array('nama_pasien, kelaspelayanan_nama, instalasi_nama, penjamin_nama, statusperiksa, asalrujukan_nama, spesialis', 'length', 'max'=>50),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('tempat_lahir, komponentarif_nama', 'length', 'max'=>25),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('namaperujuk', 'length', 'max'=>100),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgl_tindakan, cyto_tindakan, tglmasukpenunjang, alamatlengkap', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, profilrs_id, no_rekam_medik, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, kelaspelayanan_id, kelaspelayanan_nama, tindakanpelayanan_id, tgl_tindakan, tarif_satuan, tarif_tindakan, qty_tindakan, satuantindakan, cyto_tindakan, tarifcyto_tindakan, instalasi_id, instalasi_nama, penjamin_id, penjamin_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, kategoritindakan_id, kategoritindakan_nama, tindakankomponen_id, komponentarif_id, komponentarif_nama, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan, pasienmasukpenunjang_id, no_masukpenunjang, tglmasukpenunjang, statusperiksa, rujukan_id, asalrujukan_id, asalrujukan_nama, rujukandari_id, namaperujuk, spesialis, alamatlengkap', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profil RS',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Alias',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'tarif_satuan' => 'Tarif. Satuan',
			'tarif_tindakan' => 'Tarif. Tindakan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'satuantindakan' => 'Satuan Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarif Cyto Tindakan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Nama Penjamin',
			'daftartindakan_id' => 'Tindakan',
			'daftartindakan_kode' => 'Kode Tindakan',
			'daftartindakan_nama' => 'Nama Tindakan',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Kategori Tindakan',
			'tindakankomponen_id' => 'Tindakan Komponen',
			'komponentarif_id' => 'Komponen Tarif',
			'komponentarif_nama' => 'Komponen Tarif',
			'iurbiayakomp' => 'Iur Biaya Komponen',
			'tarif_tindakankomp' => 'Tarif Komponen Tindakan',
			'tarifcyto_tindakankomp' => 'Tarif cyto Komponen Tindakan',
			'tarif_kompsatuan' => 'Satuan Tarif Kompenen',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'no_masukpenunjang' => 'No. Masuk Penunjang',
			'tglmasukpenunjang' => 'Tanggal Masuk Penunjang',
			'statusperiksa' => 'Status Periksa',
			'rujukan_id' => 'Rujukan',
			'asalrujukan_id' => 'AsalRujukan',
			'asalrujukan_nama' => 'AsalRujukan',
			'rujukandari_id' => 'Rujukan Dari',
			'namaperujuk' => 'Nama Perujuk',
			'spesialis' => 'Spesialis',
			'alamatlengkap' => 'Alamat Lengkap',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('iurbiayakomp',$this->iurbiayakomp);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('tarifcyto_tindakankomp',$this->tarifcyto_tindakankomp);
		$criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('iurbiayakomp',$this->iurbiayakomp);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('tarifcyto_tindakankomp',$this->tarifcyto_tindakankomp);
		$criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}