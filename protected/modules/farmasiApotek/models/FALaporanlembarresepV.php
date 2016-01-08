<?php 
class FALaporanlembarresepV extends LaporanlembarresepV {



    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function criteriaLaporan()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->select = 'instalasiasal_nama, ruanganasal_nama';
        $criteria->group = 'instalasiasal_nama, ruanganasal_nama';
        $criteria->order = 'instalasiasal_nama, ruanganasal_nama';
//		$criteria->addBetweenCondition('tglresep',$this->tgl_awal,$this->tgl_akhir);

        return $criteria;
    }
    
    public function searchLaporan()
    {
        return new CActiveDataProvider($this, array(
                    'criteria'=>$this->criteriaLaporan(),
            ));
    }
    
    public function searchGrafikLembarResep()
    {
            $criteria = new CDbCriteria;
            $criteria->select = 'carabayar_nama AS data, COUNT(penjualanresep_id) AS jumlah';
            $criteria->group = 'carabayar_nama';

            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
            ));
    }
        
    protected function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pegawai_id,  instalasiasal_nama, ruanganasal_nama, count(r) as rke, carabayar_id, penjamin_id,carabayar_nama, penjamin_nama, penjualanresep_id';
		$criteria->group = 'pegawai_id,  instalasiasal_nama, ruanganasal_nama, carabayar_id, penjamin_id,carabayar_nama, penjamin_nama, penjualanresep_id';
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);						
		}
		$criteria->addBetweenCondition('date(tglresep)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('instalasiasal_nama',$this->instalasiasal_nama);
                if (!is_array($this->ruanganasal_nama)){
                    $this->ruanganasal_nama = 0;
                }
                if (!is_array($this->penjamin_id)){
                    $this->penjamin_id = 0;
                }

		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
                
//		$criteria->compare('rke',$this->rke);
                $criteria->addCondition('r is not null');
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);						
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);						
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);						
		}
                $crit = new CDbCriteria();
                $crit->select = 'pegawai_id, instalasiasal_nama, ruanganasal_nama, sum(rke) as rke, carabayar_id, penjamin_id, carabayar_nama, penjamin_nama,count(penjualanresep_id) as noresep';
                $crit->group = 'pegawai_id, instalasiasal_nama, ruanganasal_nama, carabayar_id,carabayar_nama, penjamin_nama, penjamin_id';
                
		return $crit;
	}
        
        
        public function searchTable(){
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        public function searchPrint(){
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function searchGrafik(){
        
            $criteria = $this->functionCriteria();

            $criteria2 = $criteria;
            $criteria2->select = 'count(noresep) as jumlah';
            if (!empty($this->carabayar_nama)){
                $criteria2->select .= ', penjamin_nama as data'; 
                $criteria2->group = 'penjamin_nama';
            }
            else if (!empty($this->instalasiasal_nama)){
                $criteria2->select .= ', ruanganasal_nama as data'; 
                $criteria2->group = 'ruanganasal_nama';
            }
            else{
                $criteria2->select .= ', carabayar_nama as data'; 
                $criteria2->group = 'carabayar_nama';
            }


            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }
        
        public function primaryKey(){
            return 'pendaftaran_id';
        }
        
        public function getKolomCarabayarItems() {
            $tr='';
            $modCarabayar = Yii::app()->db->createCommand('SELECT carabayar_nama FROM carabayar_m WHERE carabayar_aktif=TRUE ORDER BY carabayar_nourut')->queryAll();
            foreach ($modCarabayar as $kolom) {
                $tr .=  "<th>$kolom[carabayar_nama]</th>";
            }
            return $tr;
        }
        
        public function getCaraBayarValue($tipe, $instalasi='', $ruangan='', $tgl_awal, $tgl_akhir) {
            $tr='';
            $modCarabayar = Yii::app()->db->createCommand("SELECT carabayar_nama FROM carabayar_m WHERE carabayar_aktif=TRUE ORDER BY carabayar_nourut")->queryAll();
            if ($tipe=='value') {
                foreach ($modCarabayar as $kolom) {
                    $data = Yii::app()->db->createCommand(
                            "SELECT COUNT(penjualanresep_id) AS jumlah
                            FROM laporanlembarresep_v
                            WHERE
                                carabayar_nama='$kolom[carabayar_nama]'
                            AND
                                instalasiasal_nama='$instalasi'
                            AND
                                ruanganasal_nama='$ruangan'
                            AND DATE(tglresep) BETWEEN '$tgl_awal' AND '$tgl_akhir'"
                    )->queryAll();
                    $tr .=  "<td>".number_format($data[0]['jumlah'],0,"",",")."</td>";
                }
            } else if ($tipe='totalkeseluruhan') {
                    $data = Yii::app()->db->createCommand(
                            "SELECT COUNT(penjualanresep_id) AS total
                            FROM laporanlembarresep_v
                            WHERE
                                instalasiasal_nama='$instalasi'
                            AND
                                ruanganasal_nama='$ruangan'
                            AND DATE(tglresep) BETWEEN '$tgl_awal' AND '$tgl_akhir'"
                    )->queryAll();
                    $tr .=  "<td>".number_format($data[0]['total'],0,"",",")."</td>";
            }
            return $tr;
        }
        
        public function getCaraBayarTotal($tgl_awal, $tgl_akhir) {
            $tr='';
                $modCarabayar = Yii::app()->db->createCommand('SELECT carabayar_nama FROM carabayar_m WHERE carabayar_aktif=TRUE ORDER BY carabayar_nourut')->queryAll();
                foreach ($modCarabayar as $kolom) {
                    $data = Yii::app()->db->createCommand(
                            "SELECT COUNT(penjualanresep_id) AS jumlah
                            FROM laporanlembarresep_v
                            WHERE
                                carabayar_nama='$kolom[carabayar_nama]'
                            AND
                                tglresep BETWEEN '$tgl_awal' AND '$tgl_akhir'"
                    )->queryAll();
                    $tr .=  "<td>".$data[0]['jumlah']."</td>";
                }
                    $total = Yii::app()->db->createCommand("SELECT COUNT(penjualanresep_id) AS totalsemua FROM laporanlembarresep_v WHERE tglresep BETWEEN '$tgl_awal' AND '$tgl_akhir' ")->queryAll();
                    $tr .= "<td>".number_format($total[0]['totalsemua'],0,"",",")."</td>";
                return $tr;
        }

}