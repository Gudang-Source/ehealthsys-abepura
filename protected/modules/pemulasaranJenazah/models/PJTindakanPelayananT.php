<?php

class PJTindakanPelayananT extends TindakanpelayananT
{
    public $kategoritindakan_nama;
    public $daftartindakan_nama;
    public $jenistarif_id;
    public $persencyto_tindakan;
    public $subtotal;
    public $dokterpemeriksa1_nama;
    public $dokterpendamping_nama;
    public $dokteranastesi_nama;
    public $dokterdelegasi_nama;
    public $dokterpemeriksa2_nama;
    public $bidan_nama;
    public $suster_nama;
    public $perawat_nama;
    public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getTipePakets()
    {
        return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif'=>true));
    }
    
    public function getRuangans($instalasi_id=null)
    {
        $criteria = new CdbCriteria();
        if (!empty($instalasi_id)){
            $criteria->compare('instalasi_id',$instalasi_id);
        }
        $criteria->addCondition('ruangan_aktif = true');
        return RuanganM::model()->findAll($criteria);
    }

    public function search10Besar()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('daftartindakan_id',124);
        $criteria->order = 'tgl_tindakan desc';
        $criteria->limit = 10;


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }

}