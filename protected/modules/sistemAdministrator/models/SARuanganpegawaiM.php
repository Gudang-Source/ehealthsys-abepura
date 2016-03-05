<?php


class SARuanganpegawaiM extends RuanganpegawaiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
       	$sessionruangan = Yii::app()->user->ruangan_id;
            
		$criteria=new CDbCriteria;
        $criteria->with = array('ruangan','pegawai');
        //$criteria->order = 'pegawai.nama_pegawai';
                        
        if (Yii::app()->controller->module->id !='sistemAdministrator') {
            $criteria->addCondition('t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
        }else{
			if (!empty($sessionruangan) && $sessionruangan != 1){
				$criteria->addCondition('t.ruangan_id ='.$sessionruangan);
			}
        }  
	    $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
	    $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if (!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id ='.$this->pegawai_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'ruangan_nama'=>array(
                                    'asc'=>'ruangan.ruangan_nama',
                                    'desc'=>'ruangan.ruangan_nama DESC',
                                ),
                                'nama_pegawai'=>array(
                                    'asc'=>'pegawai.nama_pegawai ASC',
                                    'desc'=>'pegawai.nama_pegawai DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}

	public function searchPrint ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$sessionruangan = Yii::app()->user->ruangan_id;
            
		$criteria=new CDbCriteria;
		$criteria->with = array('ruangan','pegawai');
		$criteria->order = 'pegawai.nama_pegawai';
                                
		if (Yii::app()->controller->module->id !='sistemAdministrator') {
			$criteria->addCondition('t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
		}else{
			$criteria->addCondition('t.ruangan_id ='.$sessionruangan && $sessionruangan != 1);
		}  
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		if (!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id ='.$this->pegawai_id);
		}
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'ruangan_nama'=>array(
                                    'asc'=>'ruangan.ruangan_nama',
                                    'desc'=>'ruangan.ruangan_nama DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>false,
		));
	}
}