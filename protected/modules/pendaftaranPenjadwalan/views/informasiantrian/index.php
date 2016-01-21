<div class="white-container">
    <?php
    //$this->breadcrumbs=array(
    //	'Ppinformasiantrianpasiens'=>array('index'),
    //	'Manage',
    //);
    //
    //$arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPInformasiantrianpasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPInformasiantrianpasien', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPInformasiantrianpasien', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                
    //$this->menu=$arrMenu;
    //
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('ppinformasiantrianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <?php //$this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>

    <legend class="rim2">Informasi <b>Antrian Pasien</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Antrian Pasien</b></h6>
        <div class="table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'ppinformasiantrianpasien-grid',
        'dataProvider'=>$model->searchTable(true),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Tgl Pendaftaran',
                        'value'=>function($data) {
                            return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                        }
                    ),
                    array(
                            'header'=>'Nama Instalasi',
                            'value'=>'$data->instalasi_nama',
                    ),    
                    array(
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan_nama',
                    ),   
                    array (
                        'header'=>'No Antrian',
                        'value'=>function($data) {
                            $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                            $antrian = AntrianT::model()->findByPk($p->antrian_id);
                            
                            if (!empty($antrian)) return $antrian->loket->loket_singkatan."-".$antrian->noantrian;
                        }
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    'no_pendaftaran',
                    'alamat_pasien',
                    array(
                        'name'=>'caraBayarPenjamin',
                        'value'=>'$data->caraBayarPenjamin',
                        'filter'=>false,
                    ),
                    'statusperiksa',
    //		'pasien_id',
    //		'jenisidentitas',
    //		'no_identitas_pasien',
    //		'namadepan',
    //		
    //		'nama_bin',
                    /*
                    'jeniskelamin',
                    'tempat_lahir',
                    'tanggal_lahir',

                    'rt',
                    'rw',
                    'agama',
                    'golongandarah',
                    'photopasien',
                    'alamatemail',
                    'statusrekammedis',
                    'statusperkawinan',

                    'tgl_rekam_medik',
                    'propinsi_id',
                    'propinsi_nama',
                    'kabupaten_id',
                    'kabupaten_nama',
                    'kelurahan_id',
                    'kelurahan_nama',
                    'kecamatan_id',
                    'kecamatan_nama',
                    ////'pendaftaran_id',
                    array(
                            'name'=>'pendaftaran_id',
                            'value'=>'$data->pendaftaran_id',
                            'filter'=>false,
                    ),

                    'tgl_pendaftaran',

                    'transportasi',
                    'keadaanmasuk',
                    'statusperiksa',
                    'statuspasien',
                    'kunjungan',
                    'alihstatus',
                    'byphone',
                    'kunjunganrumah',
                    'statusmasuk',
                    'umur',
                    'no_asuransi',
                    'namapemilik_asuransi',
                    'nopokokperusahaan',
                    'create_time',
                    'create_loginpemakai_id',
                    'create_ruangan',
                    'carabayar_id',
                    'carabayar_nama',
                    'penjamin_id',
                    'penjamin_nama',
                    'shift_id',
                    'ruangan_id',
                    'ruangan_nama',
                    'instalasi_id',
                    'instalasi_nama',
                    'jeniskasuspenyakit_id',
                    'jeniskasuspenyakit_nama',
                    */
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
    </div>
</div>
<div class="search-form">
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.informasiantrian._search',array(
            'model'=>$model,'format'=>$format
    )); ?> 
    <!-- search-form -->
</div>