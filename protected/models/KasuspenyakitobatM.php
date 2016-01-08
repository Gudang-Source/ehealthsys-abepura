<?php

/**
 * This is the model class for table "kasuspenyakitobat_m".
 *
 * The followings are the available columns in table 'kasuspenyakitobat_m':
 * @property integer $jeniskasuspenyakit_id
 * @property integer $obatalkes_id
 */
class KasuspenyakitobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KasuspenyakitobatM the static model class
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
		return 'kasuspenyakitobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_id, obatalkes_id', 'required'),
                                                array('jeniskasuspenyakit_id, obatalkes_id', 'cekdata'),
			array('jeniskasuspenyakit_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskasuspenyakit_id, obatalkes_id', 'safe', 'on'=>'search'),
		);
	}
        
                public function cekdata($attribute, $params)
                {
                    $querydata = KasuspenyakitobatM::model()->findAllByAttributes(array('jeniskasuspenyakit_id'=>$this->jeniskasuspenyakit_id, 'obatalkes_id'=>$this->obatalkes_id));
                    if (!$this->hasErrors()) {
                        if (count($querydata) > 0)
                        {
                            $this->addError('jeniskasuspenyakit_id, obatalkes_id', 'Kasus '.$this->jeniskasuspenyakit->jeniskasuspenyakit_nama.' dengan obat '.$this->obatalkes->obatalkes_nama. ' telah tersedia di database');
                            return false;
                        }
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
                                    'obatalkes'=>array(self::BELONGS_TO,'ObatalkesM', 'obatalkes_id'),
                                    'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'obatalkes_id' => 'Obat Alkes',
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

		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
                $criteria->order = 'jeniskasuspenyakit_id, obatalkes_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJeniskasuspenyakitItems()
        {
            return JeniskasuspenyakitM::model()->findAll();
        }
        
        public function getObatalkesItems()
        {
            return ObatalkesM::model()->findAll();
        }
}