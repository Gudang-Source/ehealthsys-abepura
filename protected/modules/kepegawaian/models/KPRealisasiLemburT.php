<?php
class KPRealisasiLemburT extends RealisasilemburT
{
    public $rencana_nm;
    public $rencana_nomorindukpegawai;
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
     * @return KPRealisasiLemburT the static model class
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
        return 'realisasilembur_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, tglrealisasi, norealisasi, nourut, alasanlembur, tglmulai, tglselesai, pemberitugas_id, mengetahui_id, menyetujui_id, create_time, create_user', 'required'),
            array('rencanalembur_id, pegawai_id, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
            array('norealisasi', 'length', 'max'=>20),
            array('nourut', 'length', 'max'=>3),
            array('alasanlembur', 'length', 'max'=>500),
            array('create_user', 'length', 'max'=>50),
            array('keterangan,isharilembur', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('realisasilembur_id, rencanalembur_id, pegawai_id, tglrealisasi, norealisasi, nourut, alasanlembur, tglmulai, tglselesai, keterangan, pemberitugas_id, mengetahui_id, menyetujui_id, create_time, create_user, isharilembur', 'safe', 'on'=>'search'),
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
            'rencanalembur' => array(self::BELONGS_TO, 'RencanalemburT', 'rencanalembur_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
        );
    }
    */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                    'rencanalembur' => array(self::BELONGS_TO, 'KPRencanaLemburT', 'rencanalembur_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    // untuk kolom mengetahui, menyetujui dan pemberitugas
                    'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
                    'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
                    'pemberitugas' => array(self::BELONGS_TO, 'PegawaiM', 'pemberitugas_id'),
            );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'realisasilembur_id' => 'Realisasi Lembur',
            'rencanalembur_id' => 'Rencana Lembur',
            'pegawai_id' => 'Pegawai',
            'tglrealisasi' => 'Tanggal Realisasi',
            'norealisasi' => 'No. Realisasi',
            'nourut' => 'No. Urut',
            'alasanlembur' => 'Alasan Lembur',
            'tglmulai' => 'Tanggal Mulai',
            'tglselesai' => 'Tanggal Selesai',
            'keterangan' => 'Keterangan',
            'pemberitugas_id' => 'Pemberi Tugas',
            'mengetahui_id' => 'Mengetahui',
            'menyetujui_id' => 'Menyetujui',
            'create_time' => 'Create Time',
            'create_user' => 'Create User',
			'isharilembur' => 'Lembur Pada Hari Libur',
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

        $criteria->compare('realisasilembur_id',$this->realisasilembur_id);
        $criteria->compare('rencanalembur_id',$this->rencanalembur_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(tglrealisasi)',strtolower($this->tglrealisasi),true);
        $criteria->compare('LOWER(norealisasi)',strtolower($this->norealisasi),true);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(alasanlembur)',strtolower($this->alasanlembur),true);
        $criteria->compare('LOWER(tglmulai)',strtolower($this->tglmulai),true);
        $criteria->compare('LOWER(tglselesai)',strtolower($this->tglselesai),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('pemberitugas_id',$this->pemberitugas_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('menyetujui_id',$this->menyetujui_id);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(create_user)',strtolower($this->create_user),true);
		$criteria->addCondition('isharilembur is true');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('realisasilembur_id',$this->realisasilembur_id);
        $criteria->compare('rencanalembur_id',$this->rencanalembur_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(tglrealisasi)',strtolower($this->tglrealisasi),true);
        $criteria->compare('LOWER(norealisasi)',strtolower($this->norealisasi),true);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(alasanlembur)',strtolower($this->alasanlembur),true);
        $criteria->compare('LOWER(tglmulai)',strtolower($this->tglmulai),true);
        $criteria->compare('LOWER(tglselesai)',strtolower($this->tglselesai),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('pemberitugas_id',$this->pemberitugas_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('menyetujui_id',$this->menyetujui_id);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(create_user)',strtolower($this->create_user),true);
        $criteria->compare('LOWER(isharilembur)',strtolower($this->isharilembur),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function searchInformasiRealisasiLembur()
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
                 * Merging Kolom norealisasi Yang sama
                 */
                $merge->select='tglrealisasi, norealisasi, mengetahui_id, menyetujui_id, pemberitugas_id';
                $merge->distinct='trim(norealisasi)';
                $merge->order = "tglrealisasi";
                /**
                 * Untuk mencari range tanggal
                 */
                $merge->addCondition("t.tglrealisasi BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."'");

                return new CActiveDataProvider($this, array(
                        'criteria'=>$merge,
                ));


        }  
        /**
         * Untuk menampilkan attribute pegawai berdasarkan id
         */
        public function getPegawaiAttributes($pegawaiId = null, $attributes = null){
            $pegawaiAttributes = PegawaiM::model()->findByPk($pegawaiId);
            return $pegawaiAttributes->$attributes;
        }
}
?>
