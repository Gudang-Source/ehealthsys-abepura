<?php

/**
 * This is the model class for table "pengajuanpegawai_t".
 *
 * The followings are the available columns in table 'pengajuanpegawai_t':
 * @property integer $pengajuanpegawai_t_id
 * @property string $tglpengajuan
 * @property string $nopengajuan
 * @property integer $mengajukan_id
 * @property integer $mengetahui_id
 * @property string $keterangan
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengpegawaidetT[] $pengpegawaidetTs
 */
class KPPengajuanPegawaiT extends CActiveRecord
{
    public $nopengajuan_awal;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KPPengajuanPegawaiT the static model class
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
        return 'pengajuanpegawai_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tglpengajuan, nopengajuan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('mengajukan_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
            array('nopengajuan', 'length', 'max'=>50),
            array('keterangan, update_time, update_loginpemakai_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengajuanpegawai_t_id, tglpengajuan, nopengajuan, mengajukan_id, mengetahui_id, keterangan, menyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'pengpegawaidetTs' => array(self::HAS_MANY, 'PengpegawaidetT', 'pengajuanpegawai_t_id'),
            'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
            'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
            'mengajukan' => array(self::BELONGS_TO, 'PegawaiM', 'mengajukan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pengajuanpegawai_t_id' => 'Pengajuan Pegawai',
            'tglpengajuan' => 'Tanggal Rencana Penerimaan Pegawai',
            'nopengajuan' => 'No. Rencana Penerimaan Pegawai',
            'mengajukan_id' => 'Yang Mengajukan',
            'mengetahui_id' => 'Mengetahui',
            'keterangan' => 'Keterangan',
            'menyetujui_id' => 'Menyetujui',
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

        $criteria->compare('pengajuanpegawai_t_id',$this->pengajuanpegawai_t_id);
        $criteria->compare('LOWER(tglpengajuan)',strtolower($this->tglpengajuan),true);
        $criteria->compare('LOWER(nopengajuan)',strtolower($this->nopengajuan),true);
        $criteria->compare('mengajukan_id',$this->mengajukan_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('pengajuanpegawai_t_id',$this->pengajuanpegawai_t_id);
        $criteria->compare('LOWER(tglpengajuan)',strtolower($this->tglpengajuan),true);
        $criteria->compare('LOWER(nopengajuan)',strtolower($this->nopengajuan),true);
        $criteria->compare('mengajukan_id',$this->mengajukan_id);
        $criteria->compare('mengetahui_id',$this->mengetahui_id);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
        
        public $mengajukanNama;
        public $namayangmengajukan;
        public $mengetahui;
        
}
?>
