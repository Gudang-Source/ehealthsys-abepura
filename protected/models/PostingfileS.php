<?php

/**
 * This is the model class for table "postingfile_s".
 *
 * The followings are the available columns in table 'postingfile_s':
 * @property integer $postingfile_id
 * @property string $tgluploadfile
 * @property string $namafile
 * @property string $deskripsifile
 * @property string $pathfile
 * @property string $imagefile
 * @property integer $jmldownload
 * @property boolean $postingfile_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PostingfileS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostingfileS the static model class
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
		return 'postingfile_s';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgluploadfile, namafile, pathfile, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jmldownload', 'numerical', 'integerOnly'=>true),
			array('namafile', 'length', 'max'=>200),
			array('deskripsifile, imagefile, postingfile_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('postingfile_id, tgluploadfile, namafile, deskripsifile, pathfile, imagefile, jmldownload, postingfile_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'postingfile_id' => 'Postingfile',
			'tgluploadfile' => 'Tgluploadfile',
			'namafile' => 'Namafile',
			'deskripsifile' => 'Deskripsifile',
			'pathfile' => 'Pathfile',
			'imagefile' => 'Imagefile',
			'jmldownload' => 'Jmldownload',
			'postingfile_aktif' => 'Postingfile Aktif',
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

		$criteria->compare('postingfile_id',$this->postingfile_id);
		$criteria->compare('LOWER(tgluploadfile)',strtolower($this->tgluploadfile),true);
		$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
		$criteria->compare('LOWER(deskripsifile)',strtolower($this->deskripsifile),true);
		$criteria->compare('LOWER(pathfile)',strtolower($this->pathfile),true);
		$criteria->compare('LOWER(imagefile)',strtolower($this->imagefile),true);
		$criteria->compare('jmldownload',$this->jmldownload);
		$criteria->compare('postingfile_aktif',$this->postingfile_aktif);
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
		$criteria->compare('postingfile_id',$this->postingfile_id);
		$criteria->compare('LOWER(tgluploadfile)',strtolower($this->tgluploadfile),true);
		$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
		$criteria->compare('LOWER(deskripsifile)',strtolower($this->deskripsifile),true);
		$criteria->compare('LOWER(pathfile)',strtolower($this->pathfile),true);
		$criteria->compare('LOWER(imagefile)',strtolower($this->imagefile),true);
		$criteria->compare('jmldownload',$this->jmldownload);
		$criteria->compare('postingfile_aktif',$this->postingfile_aktif);
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
}