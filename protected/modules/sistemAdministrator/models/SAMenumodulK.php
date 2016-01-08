<?php

/**
 * This is the model class for table "misirs_m".
 *
 * The followings are the available columns in table 'misirs_m':
 * @property integer $misi_id
 * @property integer $profilrs_id
 * @property string $misi
 */
class SAMenumodulK extends MenumodulK
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MisirsM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->menu_id)){
			$criteria->addCondition('menu_id ='.$this->menu_id);
		}
		if (!empty($this->kelmenu_id)){
			$criteria->addCondition('kelmenu_id ='.$this->kelmenu_id);
		}
		if (!empty($this->modul_id)){
			$criteria->addCondition('modul_id ='.$this->modul_id);
		}
		$criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('LOWER(menu_namalainnya)',strtolower($this->menu_namalainnya),true);
		$criteria->compare('LOWER(menu_key)',strtolower($this->menu_key),true);
		$criteria->compare('LOWER(menu_url)',strtolower($this->menu_url),true);
		$criteria->compare('LOWER(menu_icon)',strtolower($this->menu_icon),true);
		$criteria->compare('LOWER(menu_fungsi)',strtolower($this->menu_fungsi),true);
		$criteria->compare('menu_urutan',$this->menu_urutan);
		$criteria->compare('menu_aktif',$this->menu_aktif);
		//$criteria->order = 'kelompokmenu.kelmenu_nama, menu_urutan';
		//$criteria->with = array('kelompokmenu','modulk');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        

}