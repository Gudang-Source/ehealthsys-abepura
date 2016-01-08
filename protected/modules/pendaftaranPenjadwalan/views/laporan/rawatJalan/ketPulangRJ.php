<div class="white-container">
    <legend class="rim2">Laporan Kunjungan <b>Rawat Jalan</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Ppinfo Kunjungan Rjvs'=>array('index'),
        'Manage',
    );

    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikKetPulangRJ&id=1');
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
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchRJ',array(
            'modPPInfoKunjunganV'=>$model,'format'=>$format
        )); ?>
    </fieldset>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Global', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganRJ'),),
            array('label'=>'Umur', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganUmurRJ'),),
            array('label'=>'Jenis Kelamin', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganJkRJ'),),
            array('label'=>'Kedatangan Lama / Baru', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusKunjunganRJ'),),
            array('label'=>'Agama', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAgamaKunjunganRJ'),),
            array('label'=>'Pekerjaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPekerjaanKunjunganRJ'),),
            array('label'=>'Status Perkawinan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusPerkawinanKunjunganRJ'),),
            array('label'=>'Alamat Lengkap', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAlamatKunjunganRJ'),),
            array('label'=>'Kecamatan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKecamatanKunjunganRJ'),),
            array('label'=>'Kab. / Kota', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKabKotaKunjunganRJ'),),
            array('label'=>'Cara Masuk', 'url'=>$this->createAbsoluteUrl($controller.'/laporanCaraMasukKunjunganRJ'),),
            array('label'=>'Rujukan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanRujukanKunjunganRJ'),),
            array('label'=>'Pemeriksaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPemeriksaanKunjunganRJ'),),
            array('label'=>'Keterangan Pulang', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKetPulangKunjunganRJ'),'active'=>true),
            array('label'=>'Penjamin Pasien', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPenjaminKunjunganRJ'),),
            array('label'=>'Nama Dokter', 'url'=>$this->createAbsoluteUrl($controller.'/laporanDokterPemeriksaKunjunganRJ'),),
            array('label'=>'Per Unit Pelayanan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanUnitPelayananKunjunganRJ'),),

                ),
    )); 
    ?>
    <div class="biru">
        <div class="white">
            <!--<div class="block-tabel">-->
                <!--<h6>Table Kunjungan <b>Rawat Jalan - Keterangan Pulang</b></h6>-->
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tableKetPulang', array('model'=>$model)); ?>
            <!--</div>-->
        </div>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKetPulangKunjunganRJ');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model'=>$model));?>
</div>