<?php
/**
 * This is the model class for table "tindakanrm_m".
 *
 * The followings are the available columns in table 'tindakanrm_m':
 * @property integer $tindakanrm_id
 * @property integer $jenistindakanrm_id
 * @property integer $daftartindakan_id
 * @property string $tindakanrm_nama
 * @property string $tindakanrm_namalainnya
 * @property boolean $tindakanrm_aktif
 */
class RMTindakanrmM extends TindakanrmM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanrmM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
