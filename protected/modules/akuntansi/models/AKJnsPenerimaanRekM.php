<?php

    class AKJnsPenerimaanRekM extends JnspenerimaanrekM
    {
		public $rekening5_nb;
            public static function model($className=__CLASS__)
            {
                    return parent::model($className);
            }

            public function searchJenisPenerimaan()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;
					if(!empty($this->jnspenerimaanrek_id)){
						$criteria->addCondition("t.jnspenerimaanrek_id = ".$this->jnspenerimaanrek_id);			
					}
					if(!empty($this->rekening5_id)){
						$criteria->addCondition("t.rekening5_id = ".$this->rekening5_id);			
					}
					
					
					if(!empty($this->jenispenerimaan_kode)){
						$criteria->compare('LOWER(jenispenerimaan_kode)', strtolower($this->jenispenerimaan_kode), true);
					}
					if(!empty($this->jenispenerimaan_nama)){
						$criteria->compare('LOWER(jenispenerimaan_nama)', strtolower($this->jenispenerimaan_nama), true);
					}
					if(!empty($this->jenispenerimaan_namalain)){
						$criteria->compare('LOWER(jenispenerimaan_namalain)', strtolower($this->jenispenerimaan_namalain), true);
					}
					if(!empty($this->rekening_debit)){
						$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekening_debit), true);
					}
					if(!empty($this->rekeningKredit)){
						$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekeningKredit), true);
					}
					
//                    $criteria->compare('LOWER(t.saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group = 't.jenispenerimaan_id';
					$criteria->select = 't.jenispenerimaan_id';
					
					$criteria->join =	"JOIN jenispenerimaan_m ON jenispenerimaan_m.jenispenerimaan_id = t.jenispenerimaan_id
										JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
                    
                    // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    ));
            }
            
             public function searchJenisPenerimaanPrint()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;
                    $criteria->select = 'jenispenerimaan_id';
					if(!empty($this->jnspenerimaanrek_id)){
						$criteria->addCondition("jnspenerimaanrek_id = ".$this->jnspenerimaanrek_id);			
					}
					if(!empty($this->rekening5_id)){
						$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
					}
					
					if(!empty($this->jenispenerimaan_id)){
						$criteria->addCondition("jenispenerimaan_id = ".$this->jenispenerimaan_id);			
					}
//                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group = 'jenispenerimaan_id';
                    // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                    $criteria->limit = -1;
                    
                    if(isset($this->jenispenerimaan_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispenerimaan_nama)', strtolower($this->jenispenerimaan_nama), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_kode)', strtolower($this->jenispenerimaan_kode), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_namalain)', strtolower($this->jenispenerimaan_namalain), true);
                        $record = JenispenerimaanM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispenerimaan_id;
                        }
                        
                       $condition = 'jenispenerimaan_id IN ('. implode(',', $data) .')';
                       $criteria->addCondition($condition);
                    }

                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                    ));
            }
    }

?>