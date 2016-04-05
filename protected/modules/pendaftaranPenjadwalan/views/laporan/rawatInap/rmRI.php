<div class="white-container">
    <legend class="rim2">Laporan Kunjungan <b>Rawat Inap</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Ppinfo Kunjungan Rjvs'=>array('index'),
        'Manage',
    );

    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikRMRI&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $format = new MyFormatter();
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchRI',
                array('modPPInfoKunjunganV'=>$model,'format'=> $format)); ?>
    </fieldset>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Global', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganRI'),),
            array('label'=>'Umur', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganUmurRI'),),
            array('label'=>'Jenis Kelamin', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganJkRI'),),
            array('label'=>'Kedatangan Lama / Baru', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusKunjunganRI'),),
            array('label'=>'Agama', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAgamaKunjunganRI'),),
            array('label'=>'Pekerjaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPekerjaanKunjunganRI'),),
            array('label'=>'Status Perkawinan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusPerkawinanKunjunganRI'),),
            array('label'=>'Alamat Lengkap', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAlamatKunjunganRI'),),
            array('label'=>'Kecamatan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKecamatanKunjunganRI'),),
            array('label'=>'Kab. / Kota', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKabKotaKunjunganRI'),),
            array('label'=>'Cara Masuk', 'url'=>$this->createAbsoluteUrl($controller.'/laporanCaraMasukKunjunganRI'),),
            array('label'=>'Rujukan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanRujukanKunjunganRI'),),
            array('label'=>'Rekam Medik', 'url'=>$this->createAbsoluteUrl($controller.'/laporanRMKunjunganRI'),'active'=>true),
            array('label'=>'Kamar Ruangan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKamarRuanganKunjunganRI'),),
            array('label'=>'Keterangan Pulang', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKetPulangKunjunganRI'),),
            array('label'=>'Alasan Pulang', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAlasanPulangKunjunganRI'),),
            array('label'=>'Penjamin', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPenjaminKunjunganRI'),),
            array('label'=>'Nama Dokter', 'url'=>$this->createAbsoluteUrl($controller.'/laporanDokterPemeriksaKunjunganRI'),),
            array('label'=>'Per Unit Pelayanan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanUnitPelayananKunjunganRI'),),
			
                ),
    )); 
    ?>
    <div class="biru">
        <div class="white">
            <!--<div class="block-tabel">-->
                <!--<h6>Table Kunjungan <b>Rawat Inap - Rekam Medis</b></h6>--> 
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatInap._tableRmRI', array('model'=>$model)); ?>
            <!--</div>-->
        </div>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printRMKunjunganRI');
    $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'tips'=>'tips2')); ?>
</div>