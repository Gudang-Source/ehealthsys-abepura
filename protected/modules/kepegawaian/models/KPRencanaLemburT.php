 <?php

/**
 * This is the model class for table "rencanalembur_t".
 *
 * The followings are the available columns in table 'rencanalembur_t':
 * @property integer $rencanalembur_id
 * @property integer $pegawai_id
 * @property integer $realisasilembur_id
 * @property string $tglrencana
 * @property string $norencana
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property string $keterangan
 * @property integer $pemberitugas_id
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property RealisasilemburT[] $realisasilemburTs
 */
class KPRencanaLemburT extends CActiveRecord
{
        public $rencana_nm;
        public $rencana_nip;
        public $mengetahui_nama;
        public $menyetujui_nama;
        public $pemberitugas_nama;
        public $karlembur_nama;
        public $tgl_awal;
        public $tgl_akhir;
        public $jamMulai;
        public $jamSelesai;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KPRencanaLemburT the static model class
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
        return 'rencanalembur_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, tglrencana, norencana, nourut, tglmulai, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pegawai_id, realisasilembur_id, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
            array('norencana', 'length', 'max'=>20),
            array('nourut', 'length', 'max'=>3),
            array('alasanlembur', 'length', 'max'=>500),
            array('tglselesai, keterangan, update_time, update_loginpemakai_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rencanalembur_id, pegawai_id, realisasilembur_id, tglrencana, norencana, nourut, alasanlembur, tglmulai, tglselesai, keterangan, pemberitugas_id, mengetahui_id, menyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     *
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'realisasilemburTs' => array(self::HAS_MANY, 'RealisasilemburT', 'rencanalembur_id'),
        );
    }
    */
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'realisasilemburTs' => array(self::HAS_MANY, 'RealisasilemburT', 'rencanalembur_id'),
                        // untuk kolom mengetahui, menyetujui dan pemberitugas
                        'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'pemberitugas' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'rencanalembur_id' => 'Rencana Lembur',
            'pegawai_id' => 'Pegawai',
            'realisasilembur_id' => 'Realisasi Lembur',
            'tglrencana' => 'Tanggal Rencana',
            'norencana' => 'No. Rencana',
            'nourut' => 'No. Urut',
            'alasanlembur' => 'Alasan Lembur',
            'tglmulai' => 'Tanggal Mulai Lembur',
            'tglselesai' => 'Tanggal Selesai Lembur',
            'keterangan' => 'Keterangan',
            'pemberitugas_id' => 'Pemberi Tugas',
            'mengetahui_id' => 'Mengetahui',
            'menyetujui_id' => 'Menyetujui',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Login pemakai',
            'update_loginpemakai_id' => 'Update Login pemakai',
            'create_ruangan' => 'Create Ruangan',
            
            'mengetahui_nama' => 'Mengetahui',
            'menyetujui_nama' => 'Menyetujui',
            'pemberitugas_nama' => 'Pemberi Tugas',

            'rencana_nip'=>'No. Induk Pegawai',
            'rencana_nama'=>'Nama Pegawai',

            'tgl_awal'=>'Tanggal Awal Rencana Lembur',
            'tgl_akhir'=>'Tanggal Akhir Rencana Lembur',
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

        $criteria->compare('rencanalembur_id',$this->rencanalembur_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('realisasilembur_id',$this->realisasilembur_id);
        $criteria->compare('LOWER(tglrencana)',strtolower($this->tglrencana),true);
        $criteria->compare('LOWER(norencana)',strtolower($this->norencana),true);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(alasanlembur)',strtolower($this->alasanlembur),true);
        $criteria->compare('LOWER(tglmulai)',strtolower($this->tglmulai),true);
        $criteria->compare('LOWER(tglselesai)',strtolower($this->tglselesai),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('pemberitugas_id',$this->pemberitugas_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('menyetujui_id',$this->menyetujui_id);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
        public function searchInformasiRencanaLembur()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
                // Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
                //Format tanggal DB
                $format = new MyFormatter;

                //Tanggal Awal jika kosong
                if(empty($this->tgl_awal)){
                    $this->tgl_awal = '1900-01-01 00:00:00';
                }else{
                    $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
                }
                if(empty($this->tgl_akhir)){
                    $this->tgl_akhir = '1900-01-01 00:00:00';
                }else{
                    $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
                }
             
                $merge = new CDbCriteria;
                
                
                /**
                 * Merging Kolom norencana Yang sama
                 */
                $merge->select='tglrencana, norencana, mengetahui_id, menyetujui_id, pemberitugas_id';
                $merge->distinct='trim(norencana)';
                $merge->order = 'tglrencana';
                /**
                 * Untuk mencari range tanggal
                 */
                $merge->addCondition("t.realisasilembur_id IS NULL AND t.tglrencana BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."'");
                return new CActiveDataProvider($this, array(
			'criteria'=>$merge,
		));
                
                
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('rencanalembur_id',$this->rencanalembur_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('realisasilembur_id',$this->realisasilembur_id);
        $criteria->compare('LOWER(tglrencana)',strtolower($this->tglrencana),true);
        $criteria->compare('LOWER(norencana)',strtolower($this->norencana),true);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(alasanlembur)',strtolower($this->alasanlembur),true);
        $criteria->compare('LOWER(tglmulai)',strtolower($this->tglmulai),true);
        $criteria->compare('LOWER(tglselesai)',strtolower($this->tglselesai),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('pemberitugas_id',$this->pemberitugas_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('menyetujui_id',$this->menyetujui_id);
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
        /**
         * Untuk menampilkan attribute pegawai berdasarkan id
         */
        public function getPegawaiAttributes($pegawaiId = null, $attributes = null){
            $pegawaiAttributes = PegawaiM::model()->findByPk($pegawaiId);
            if (isset($pegawaiAttributes)){
                return $pegawaiAttributes->$attributes;
            }
        }

} 



?>