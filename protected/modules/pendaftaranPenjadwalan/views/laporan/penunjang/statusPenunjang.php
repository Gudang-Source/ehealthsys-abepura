<div class="white-container">
    <legend class="rim2">Laporan Kunjungan <b>Rawat Jalan</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Ppinfo Kunjungan Rjvs'=>array('index'),
        'Manage',
    );

    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikStatusPenunjang&id=1');
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
    <fieldset class="search-form box">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchPenunjang',array(
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
            array('label'=>'Global', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganPenunjang'),),
            array('label'=>'Umur', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganUmurPenunjang'),),
            array('label'=>'Jenis Kelamin', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganJkPenunjang'),),
            array('label'=>'Kedatangan Lama / Baru', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusKunjunganPenunjang'),'active'=>true),
            array('label'=>'Agama', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAgamaKunjunganPenunjang'),),
            array('label'=>'Pekerjaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPekerjaanKunjunganPenunjang'),),
            array('label'=>'Status Perkawinan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusPerkawinanKunjunganPenunjang'),),
            array('label'=>'Alamat Lengkap', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAlamatKunjunganPenunjang'),),
            array('label'=>'Kecamatan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKecamatanKunjunganPenunjang'),),
            array('label'=>'Kab. / Kota', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKabKotaKunjunganPenunjang'),),
            array('label'=>'Cara Masuk', 'url'=>$this->createAbsoluteUrl($controller.'/laporanCaraMasukKunjunganPenunjang'),),
            array('label'=>'Rujukan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanRujukanKunjunganPenunjang'),),
            array('label'=>'Pemeriksaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPemeriksaanKunjunganPenunjang'),),
            array('label'=>'Keterangan Pulang', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKetPulangKunjunganPenunjang'),),
            array('label'=>'Penjamin Pasien', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPenjaminKunjunganPenunjang'),),
            array('label'=>'Nama Dokter', 'url'=>$this->createAbsoluteUrl($controller.'/laporanDokterPemeriksaKunjunganPenunjang'),),
            array('label'=>'Per Unit Pelayanan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanUnitPelayananKunjunganPenunjang'),),

                ),
    )); 
    ?>
    <div class="biru">
        <div class="white">
            <!--<div class="block-tabel">-->
                <!--<h6>Table Kunjungan <b>Rawat Jalan - Status Kunjungan</b></h6>-->
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tableStatus', array('model'=>$model)); ?>
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
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printStatusKunjunganPenunjang');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'tips'=>'bukuregister')); 
    ?>
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.penunjang/_jsFunctions', array('model'=>$model));?>
</div>