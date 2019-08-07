<?php

class KOKartuangsuranV extends KartuangsuranV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $filterTanggal;

	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		if (isset($this->tglAwal) && isset($this->tglAkhir) && !empty($this->tglAwal) && !empty($this->tglAkhir)) {
			$criteria->addBetweenCondition('tglpinjaman', $this->tglAwal, $this->tglAkhir);
		}
			//if (isset($this->tglAwal) && isset($this->tglAkhir)) {$criteria->addCondition('tgljatuhtempoangs BETWEEN \''.$this->tglAwal.'\' AND \''.$this->tglAkhir.'\'');
//		}
		if(!empty($this->pegawai_id))$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		//$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		if(!empty($this->jabatan_id))$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		//$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		if(!empty($this->unit_id))$criteria->addCondition('unit_id = '.$this->unit_id);
		//$criteria->compare('unit_id',$this->unit_id);
		//$criteria->compare('namaunit',$this->namaunit,true);
		if(!empty($this->keanggotaan_id))$criteria->addCondition('keanggotaan_id = '.$this->keanggotaan_id);
		//$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		//$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('totalangsuran',$this->totalangsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		if(!empty($this->jmlangsuran_id))$criteria->addCondition('jmlangsuran_id = '.$this->jmlangsuran_id);
		//$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		if(!empty($this->pinjaman_id))$criteria->addCondition('pinjaman_id = '.$this->pinjaman_id);
		//$criteria->compare('pinjaman_id',$this->pinjaman_id);
		//$criteria->compare('statuspinjaman',$this->statuspinjaman);
		if ($this->statuspinjaman == 'LUNAS') {
			$criteria->addCondition('isudahbayar = true');}
		else if($this->statuspinjaman == 'BELUM LUNAS') {
			$criteria->addCondition('isudahbayar = false');
		}
		//$criteria->compare('isudahbayar',$this->isudahbayar);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);

		//var_dump($criteria); die;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi() {
		$criteria = $this->search()->criteria;
		$criteria->select = $criteria->group = 'nokeanggotaan,
                    jmlangsuran_id,
                    nama_pegawai,
                    tglangsuran,                    
                    angsuran_ke,
                    golonganpegawai_nama,
                    tglpinjaman,
                    pinjaman_id,
                    no_pinjaman,
                    jml_pinjaman,
                    jmlpokok_angsuran,
                    jmljasa_angsuran,
                    jmlpembayaran,               
                    tgljatuhtempoangs';
//isudahbayar
		//if (isset($this->a_tglAwal) && isset($this->a_tglAkhir) && !empty($this->a_tglAkhir) && !empty($this->a_tglAkhir)) {
                if ($this->filterTanggal == TRUE){
                    $criteria->addBetweenCondition('tglangsuran', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
                }
		//}
                $criteria->compare('LOWER(no_pinjaman)',  strtolower($this->no_pinjaman), true);
                $criteria->compare('nokeanggotaan',$this->nokeanggotaan, true);
                $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		if (!empty($this->statuspinjaman)) {			
                    $criteria->compare("statuspinjaman", $this->statuspinjaman, true);
                }
                
                if (!empty($this->golonganpegawai_id)) {                    
                    $criteria->addCondition("golonganpegawai_id = '".$this->golonganpegawai_id."' ");
                }
                $criteria->order = "tglangsuran DESC";
                $criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        //''
			//'sort'=>array(
			//	'defaultOrder'=>'nama_pegawai, tglpinjaman, angsuran_ke'
			//),
		));
	}

	function searchPrint() {
		$criteria = $this->search()->criteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>false,
		));
	}
	function searchPrintInformasi() {
		$criteria = $this->searchInformasi()->criteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>false,
			'sort'=>array(
				'defaultOrder'=>'nama_pegawai, tglpinjaman, angsuran_ke'
			),
		));
	}

	

	 public function getTotAP($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpokok_angsuran;
		}
		return $total;
	}

	public function getTotJA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmljasa_angsuran;
		}
		return $total;
	}

	public function getSubTotAng($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += ($item->jmlpokok_angsuran + $item->jmljasa_angsuran);
		}
		return $total;
	}

	public function getTotSA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$angsuran = JmlangsuranT::model()->findByPk($item->jmlangsuran_id);
			$total += ($angsuran->sisa);
		}
		return $total;
	}
        
       
}