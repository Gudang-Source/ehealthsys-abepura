<?php


class GFInformasikartustokobatalkesV extends InformasikartustokobatalkesV
{
        public $tgl_awal, $tgl_akhir, $transaksi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformasi()
        {
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('DATE(create_time)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
			if(!empty($this->penerimaandetail_id)){
				$criteria->addCondition('penerimaandetail_id = '.$this->penerimaandetail_id);
			}
			if(!empty($this->penerimaanbarang_id)){
				$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
			}
			if(!empty($this->fakturpembelian_id)){
				$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
			}
			if(!empty($this->returpembelian_id)){
				$criteria->addCondition('returpembelian_id = '.$this->returpembelian_id);
			}
			if(!empty($this->terimamutasidetail_id)){
				$criteria->addCondition('terimamutasidetail_id = '.$this->terimamutasidetail_id);
			}
			if(!empty($this->returdetail_id)){
				$criteria->addCondition('returdetail_id = '.$this->returdetail_id);
			}
			if(!empty($this->mutasioadetail_id)){
				$criteria->addCondition('mutasioadetail_id = '.$this->mutasioadetail_id);
			}
			if(!empty($this->obatalkespasien_id)){
				$criteria->addCondition('obatalkespasien_id = '.$this->obatalkespasien_id);
			}
			if(!empty($this->terimamutasi_id)){
				$criteria->addCondition('terimamutasi_id = '.$this->terimamutasi_id);
			}
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
			}
			if(!empty($this->pemusnahanoadetail_id)){
				$criteria->addCondition('pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
			}
			if(!empty($this->pemusnahanobatalkes_id)){
				$criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
			}
			if(!empty($this->formstokopname_id)){
				$criteria->addCondition('formstokopname_id = '.$this->formstokopname_id);
			}
            $criteria->compare('LOWER(noterimabarang)',strtolower($this->noterimabarang),true);
            $criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
            $criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
            $criteria->compare('LOWER(noterimamutasi)',strtolower($this->noterimamutasi),true);
            $criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition('returpenerimaan_id = '.$this->returpenerimaan_id);
			}
			if(!empty($this->mutasioaruangan_id)){
				$criteria->addCondition('mutasioaruangan_id = '.$this->mutasioaruangan_id);
			}
            $criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
            $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
            $criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
			if(!empty($this->formuliropname_id)){
				$criteria->addCondition('formuliropname_id = '.$this->formuliropname_id);
			}
            $criteria->compare('LOWER(noformulir)',strtolower($this->noformulir),true);
			if(!empty($this->stokopnamedet_id)){
				$criteria->addCondition('stokopnamedet_id = '.$this->stokopnamedet_id);
			}
			if(!empty($this->stokopname_id)){
				$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
			}
            $criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
            $criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
			if(!empty($this->asalbarang_id)){
				$criteria->addCondition('asalbarang_id = '.$this->asalbarang_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
			}
            $criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('stokoa_aktif',$this->stokoa_aktif);
			if(!empty($this->tglkadaluarsa)){
				$criteria->compare('DATE(tglkadaluarsa)',  MyFormatter::formatDateTimeForDb($this->tglkadaluarsa));
			}
            if($this->transaksi){
				$criteria->addCondition($this->transaksi.' > 0'); 
			}
            
            $criteria->order="create_time DESC";
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        /**
         * menampilkan nama transaksi
         */
        public function getNamaTransaksi(){
			if(!empty($this->penerimaanbarang_id)){
                return 'Penerimaan Barang dari '.$this->NamaSupplier;
            }else if(!empty($this->returpembelian_id)){
                return $this->getAttributeLabel("returpembelian_id");
            }else if(!empty($this->terimamutasi_id)){
                return $this->getAttributeLabel("terimamutasi_id");
            }else if(!empty($this->returresep_id)){
                return $this->getAttributeLabel("returresep_id");
            }else if(!empty($this->returpenerimaan_id)){
                return $this->getAttributeLabel("returpenerimaan_id");
            }else if(!empty($this->mutasioaruangan_id)){
                return $this->getAttributeLabel("mutasioaruangan_id");
            }else if(!empty($this->penjualanresep_id)){
                return $this->getAttributeLabel("penjualanresep_id");
            }else if(!empty($this->pemusnahanobatalkes_id)){
                return $this->getAttributeLabel("pemusnahanobatalkes_id");
            }else if(!empty($this->stokopname_id)){
                return $this->getAttributeLabel("stokopname_id");
            }else if(!empty($this->pemakaianobat_id)){
                return 'Pemakaian di Ruangan '.$this->ruangan_nama;
            }
        }
		
        public function getNamaSupplier(){
			$modPenerimaanBarang = PenerimaanbarangT::model()->findByPk($this->penerimaanbarang_id);
			$return = !empty($modPenerimaanBarang)?$modPenerimaanBarang->supplier->supplier_nama:null;
			return $return;
        }
		
		public function getNamaTransaksiKartuStok(){
			$transaksi = array(
                                'mutasioaruangan_id'=>$this->getAttributeLabel("mutasioaruangan_id"),
                                'pemakaianobat_id'=>'Pemakaian di Ruangan',
                                'pemusnahanobatalkes_id'=>$this->getAttributeLabel("pemusnahanobatalkes_id"),
                                'terimamutasi_id'=>$this->getAttributeLabel("terimamutasi_id"),
				'penerimaanbarang_id'=>$this->getAttributeLabel("penerimaanbarang_id"),                                
                                'penjualanresep_id'=>$this->getAttributeLabel("penjualanresep_id"),				
				'returpembelian_id'=>$this->getAttributeLabel("returpembelian_id"),
                                'returpenerimaan_id'=>$this->getAttributeLabel("returpenerimaan_id"),
                                'returresep_id'=>$this->getAttributeLabel("returresep_id"),
                                'stokopname_id'=>$this->getAttributeLabel("stokopname_id"),								
			);
			return $transaksi;
		}
		
		public function getTransaksiMasukItems(){
			$transaksi = array(
				'penerimaanbarang_id'=>$this->getAttributeLabel("penerimaanbarang_id"),
				'terimamutasi_id'=>$this->getAttributeLabel("terimamutasi_id"),
				'returresep_id'=>$this->getAttributeLabel("returresep_id"),
				'stokopname_id'=>$this->getAttributeLabel("stokopname_id"),
			);
			return $transaksi;
		}
        /**
		 * untuk transaksi pemusnahan obat
		 * @return \CActiveDataProvider
		 */
        public function searchDialogPemusnahan()
        {
			$format = new MyFormatter();
            $criteria=new CDbCriteria;
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}else{
				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_kode),true,'OR');
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_nama),true,'OR');
			$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);			
            $criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('DATE(tglkadaluarsa)',$format->formatDateTimeForDb($this->tglkadaluarsa));
            if($this->transaksi){
				$criteria->addCondition($this->transaksi.' > 0'); 
			}
            $criteria->addCondition('stokoa_aktif = TRUE'); 
            $criteria->addCondition('qtystok_in > 0'); 
            
            $criteria->limit=5;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
		/**
		 * menampilkan stok berdasarkan group batch (stokobatalkes_id dan stokobatalkesasal_id
		 * @return type
		 */
		public function getStokObatBatch(){ // menampilkan stok obat per ruangan login
            return StokobatalkesT::getJumlahStokBatch($this->stokobatalkes_id);
        }
}