<?php

/**
 * This is the model class for table "gambartubuh_m".
 *
 * The followings are the available columns in table 'gambartubuh_m':
 * @property integer $gambartubuh_id
 * @property string $nama_gambar
 * @property string $nama_file_gbr
 * @property string $path_gambar
 * @property double $gambar_resolusi_x
 * @property double $gambar_resolusi_y
 * @property string $gambar_create
 * @property string $gambar_update
 * @property boolean $gambartubuh_aktif
 */
class GambartubuhM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GambartubuhM the static model class
	 */
    public $temp_path, $temp_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gambartubuh_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_gambar', 'required'),
			array('gambar_resolusi_x, gambar_resolusi_y', 'numerical'),
			array('nama_gambar, nama_file_gbr', 'length', 'max'=>100),
			array('temp_path, temp_nama, gambar_update, gambartubuh_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gambartubuh_id, nama_gambar, nama_file_gbr, path_gambar, gambar_resolusi_x, gambar_resolusi_y, gambar_create, gambar_update, gambartubuh_aktif', 'safe', 'on'=>'search'),
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
			'gambartubuh_id' => 'ID Gambar Tubuh',
			'nama_gambar' => 'Nama Gambar',
			'nama_file_gbr' => 'File Gambar',
			'path_gambar' => 'Path Gambar',
			'gambar_resolusi_x' => 'Gambar Resolusi X',
			'gambar_resolusi_y' => 'Gambar Resolusi Y',
			'gambar_create' => 'Gambar Create',
			'gambar_update' => 'Gambar Update',
			'gambartubuh_aktif' => 'Gambar Tubuh Aktif',
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

		//if(!empty($this->gambartubuh_id)){
			//$criteria->addCondition('gambartubuh_id = '.$this->gambartubuh_id);
		//}
		$criteria->compare('LOWER(nama_gambar)',strtolower($this->nama_gambar),true);
		$criteria->compare('LOWER(nama_file_gbr)',strtolower($this->nama_file_gbr),true);
		$criteria->compare('LOWER(path_gambar)',strtolower($this->path_gambar),true);
		$criteria->compare('gambar_resolusi_x',$this->gambar_resolusi_x);
		$criteria->compare('gambar_resolusi_y',$this->gambar_resolusi_y);
		//$criteria->compare('LOWER(gambar_create)',strtolower($this->gambar_create),true);
		//$criteria->compare('LOWER(gambar_update)',strtolower($this->gambar_update),true);                
                $criteria->compare('gambartubuh_aktif',isset($this->gambartubuh_aktif)?$this->gambartubuh_aktif:true);                
               

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