<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Istirahat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'default-tab', 'onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/istirahat')),        
        array('label'=>'Opname (Sudah Pulang)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'rawat-inap','onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/opnameSP')),        
        array('label'=>'Opname (Sedang Dirawat)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'rawat-inap','onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/opnameRI')),        
        array('label'=>'Indikasi Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'rawat-inap','onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/indikasiRI')),        
        array('label'=>'Diagnosa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/diagnosa')),        
        array('label'=>'Meninggal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'rawat-inap','onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/suratMeninggal')),        
        array('label'=>'Lahir', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'rawat-inap','onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/suratLahir')),        
        array('label'=>'Berbadan Sehat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/suratBadanSehat')),        
        array('label'=>'Penyakit Gawat Darurat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/penyakitRD')),        
        array('label'=>'Layak Naik Pesawat Terbang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/layakNaikPesawat')),        
        array('label'=>'Cuti Hamil', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/cutiHamil')),        
        array('label'=>'Cuti Melahirkan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/cutiMelahirkan')),        
        array('label'=>'Jalan Ambulans antar Jenazah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/antarJenazah')),        
        array('label'=>'Jalan Ambulans menjemput pasien di Bandara', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/jemputPasien')),        
        array('label'=>'Jalan Ambulans menjemput jenazah di Bandara', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/jemputJenazah')),        
        array('label'=>'Refraksi Mata', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/refraksiMata')),        
        array('label'=>'Pengurusan Paspor', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/pengurusanPaspor')),        
//        array('label'=>'Rujukan Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/rujukanPasien')),        
//        array('label'=>'Pengantar Tagihan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/pengantarTagihan')),        
//        array('label'=>'Pernyataan untuk Melunasi Sisa Biaya Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/melunasiSisaBayar')),        
//        array('label'=>'Pernyataan Penyerahan Surat Jaminan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/penyerahanPenjamin')),        
//        array('label'=>'Kuasa Pemberi Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeterangan/kuasaPemberiRK')),        
    ),
));
?>