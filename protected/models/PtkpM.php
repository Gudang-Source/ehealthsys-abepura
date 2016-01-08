<?php

/**
 * This is the model class for table "ptkp_m".
 *
 * The followings are the available columns in table 'ptkp_m':
 * @property integer $ptkp_id
 * @property string $tglberlaku
 * @property string $statusperkawinan
 * @property integer $jmltanggunan
 * @property double $wajibpajak_thn
 * @property double $wajibpajak_bln
 * @property boolean $berlaku
 */
class PtkpM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PtkpM the static model class
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
		return 'ptkp_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglberlaku, statusperkawinan, jmltanggunan, wajibpajak_thn, wajibpajak_bln', 'required'),
			array('jmltanggunan', 'numerical', 'integerOnly'=>true),
			array('wajibpajak_thn, wajibpajak_bln', 'numerical'),
			array('statusperkawinan', 'length', 'max'=>20),
			array('berlaku', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ptkp_id, tglberlaku, statusperkawinan, jmltanggunan, wajibpajak_thn, wajibpajak_bln, berlaku', 'safe', 'on'=>'search'),
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
			'ptkp_id' => 'Id',
			'tglberlaku' => 'Tanggal Berlaku',
			'statusperkawinan' => 'Status Perkawinan',
			'jmltanggunan' => 'Jumlah Tanggunan',
			'wajibpajak_thn' => 'Tahun Wajib Pajak',
			'wajibpajak_bln' => 'Bulan Wajib Pajak',
			'berlaku' => 'Berlaku',
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

		$criteria->compare('ptkp_id',$this->ptkp_id);
		$criteria->compare('LOWER(tglberlaku)',strtolower($this->tglberlaku),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('jmltanggunan',$this->jmltanggunan);
		$criteria->compare('wajibpajak_thn',$this->wajibpajak_thn);
		$criteria->compare('wajibpajak_bln',$this->wajibpajak_bln);
		$criteria->compare('berlaku',$this->berlaku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ptkp_id',$this->ptkp_id);
		$criteria->compare('LOWER(tglberlaku)',strtolower($this->tglberlaku),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('jmltanggunan',$this->jmltanggunan);
		$criteria->compare('wajibpajak_thn',$this->wajibpajak_thn);
		$criteria->compare('wajibpajak_bln',$this->wajibpajak_bln);
		//$criteria->compare('berlaku',$this->berlaku);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}