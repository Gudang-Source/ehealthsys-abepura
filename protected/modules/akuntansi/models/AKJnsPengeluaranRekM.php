<?php

    class AKJnsPengeluaranRekM extends JnspengeluaranrekM
    {
            /**
             * Returns the static model of the specified AR class.
             * @param string $className active record class name.
             * @return AKJnsPengeluaranRekM the static model class
             */
            public static function model($className=__CLASS__)
            {
                    return parent::model($className);
            }
            
            public function searchJenisPengeluaran()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;
					
                    if(!empty($this->jnspengeluaranrek_id)){
                            $criteria->addCondition("t.jnspengeluaranrek_id = ".$this->jnspengeluaranrek_id);			
                    }
                    if(!empty($this->jenispengeluaran_id)){
                            $criteria->addCondition("t.jenispengeluaran_id = ".$this->jenispengeluaran_id);			
                    }
                    if(!empty($this->rekening5_id)){
                            $criteria->addCondition("t.rekening5_id = ".$this->rekening5_id);			
                    }			

                    if(!empty($this->jenispengeluaran_kode)){
                            $criteria->compare('LOWER(jenispengeluaran_kode)', strtolower($this->jenispengeluaran_kode), true);
                    }
                    if(!empty($this->jenispengeluaran_nama)){
                            $criteria->compare('LOWER(jenispengeluaran_nama)', strtolower($this->jenispengeluaran_nama), true);
                    }
                    if(!empty($this->jenispengeluaran_namalain)){
                            $criteria->compare('LOWER(jenispengeluaran_namalain)', strtolower($this->jenispengeluaran_namalain), true);
                    }
                    if(!empty($this->rekening_debit)){
                            $criteria->compare('LOWER(nmrekening5)', strtolower($this->rekening_debit), true);
                    }
                    if(!empty($this->rekeningKredit)){
                            $criteria->compare('LOWER(nmrekening5)', strtolower($this->rekeningKredit), true);
                    }
					
//                    $criteria->compare('LOWER(t.saldonormal)',strtolower($this->saldonormal),true);
					$criteria->select = 't.jenispengeluaran_id';
                    $criteria->group='t.jenispengeluaran_id';
					
					$criteria->join =	"JOIN jenispengeluaran_m ON jenispengeluaran_m.jenispengeluaran_id = t.jenispengeluaran_id
										JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
					
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    ));
            }
            
            public function searchJenisPengeluaranPrint()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;

                    $criteria->select = 'jenispengeluaran_id';
					if(!empty($this->jnspengeluaranrek_id)){
						$criteria->addCondition("jnspengeluaranrek_id = ".$this->jnspengeluaranrek_id);			
					}
					if(!empty($this->jenispengeluaran_id)){
						$criteria->addCondition("jenispengeluaran_id = ".$this->jenispengeluaran_id);			
					}
					if(!empty($this->rekening5_id)){
						$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
					}
//                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group='jenispengeluaran_id';
                    
                    if(isset($this->jenispengeluaran_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispengeluaran_nama)', strtolower($this->jenispengeluaran_nama), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_kode)', strtolower($this->jenispengeluaran_kode), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_namalain)', strtolower($this->jenispengeluaran_namalalin), true);
                        $record = JenispengeluaranM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispengeluaran_id;
                        }
                        
                       $condition = 'jenispengeluaran_id IN ('. implode(',', $data) .')';
                       $criteria->addCondition($condition);
                    }
                    
                    $criteria->limit = -1;

                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                    ));
            }

    }

?>