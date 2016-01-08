<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlJenisObat())),
    	array('label'=>'Generik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGenerik())),
        array('label'=>'Asal Barang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlAsalBarang())),
    	array('label'=>'Therapi Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTherapiObat())),
    	array('label'=>'Kadar Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKadarObat())),
    	array('label'=>'Satuan Kecil', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlSatuanKecil())),
    	array('label'=>'Satuan Besar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlSatuanBesar())),
    	array('label'=>'Lokasi Gudang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlLokasiGudang())),
    		
    ),
));
?>