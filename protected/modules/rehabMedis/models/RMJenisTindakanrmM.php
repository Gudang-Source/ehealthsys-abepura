<?php
/**
 * This is the model class for table "jenistindakanrm_m".
 *
 * The followings are the available columns in table 'jenistindakanrm_m':
 * @property integer $jenistindakanrm_id
 * @property string $jenistindakanrm_nama
 * @property string $jenistindakanrm_namalainnya
 * @property boolean $jenistindakanrm_aktif
 */
class RMJenisTindakanrmM extends JenistindakanrmM
{
    public $ruangan_id;
    public $penjamin_id;
    public $kelaspelayanan_id;
    public $tindakanrm_nama;
    public $daftartindakan_id,$tindakanrm_id,$harga_tariftindakan,$jenistarif_id;
    public $is_pilih = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JenistindakanrmM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
            return array(
                    'jenistindakanrm_id' => 'Jenis Tindakan RM',
                    'jenistindakanrm_nama' => 'Nama Jenis Tindakan',
                    'jenistindakanrm_namalainnya' => 'Nama Jenis Tindakan Lainnya',
                    'jenistindakanrm_aktif' => 'Aktif',
                    'tindakanrm_id'=>'Tindakan RM',
            );
    }
}
?>
