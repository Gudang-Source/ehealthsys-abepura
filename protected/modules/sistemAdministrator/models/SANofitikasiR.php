<?php

/**
 * This is the model class for table "notifikasi_r".
 *
 * The followings are the available columns in table 'notifikasi_r':
 * @property integer $nofitikasi_id
 * @property integer $instalasi_id
 * @property integer $modul_id
 * @property string $tglnotifikasi
 * @property string $judulnotifikasi
 * @property string $isinotifikasi
 * @property boolean $isread
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $lamahrnotif
 */
class SANofitikasiR extends NofitikasiR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NofitikasiR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchFrame()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->nofitikasi_id)){
			$criteria->addCondition('nofitikasi_id ='.$this->nofitikasi_id);
		}
		
		$modul_id = (isset(Yii::app()->session['modul_id']) ? Yii::app()->session['modul_id'] : 0);
		$criteria->addCondition('modul_id ='.$modul_id);
		$criteria->compare('LOWER(tglnotifikasi)',strtolower($this->tglnotifikasi),true);
		$criteria->compare('LOWER(judulnotifikasi)',strtolower($this->judulnotifikasi),true);
		$criteria->compare('LOWER(isinotifikasi)',strtolower($this->isinotifikasi),true);
		$criteria->compare('isread',$this->isread);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('lamahrnotif',$this->lamahrnotif);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'create_time desc')
		));
	}
        
	
}