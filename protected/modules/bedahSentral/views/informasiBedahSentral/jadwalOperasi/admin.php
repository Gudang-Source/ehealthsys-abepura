<div class="white-container">
    <legend class="rim2">Informasi <b>Jadwal Operasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Reinformasipenjualanprodukpos Vs'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('reinformasipenjualanprodukpos-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Jadwal Operasi</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'reinformasipenjualanprodukpos-v-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',

                    ),
                    array(
                        'header'=>'Tanggal Rencana Operasi',
                        'type'=>'raw',
                        'value'=>'$data->tglrencanaoperasi'
                    ),
                    array(
                        'header'=>'Mulai Operasi /'."<br>".'Selesai Operasi',
                        'type'=>'raw',
                        'value'=>'$data->mulaioperasi." / "."<br>".$data->selesaioperasi',
                    ),
                   array(
                        'header'=>'Golongan Operasi',
                        'type'=>'raw',
                        'value'=>'(isset($data->golonganoperasi_id)?$data->golonganoperasi->golonganoperasi_nama:"")',
                    ),
                    array(
                        'header'=>'Jenis Operasi /'."<br>".'Operasi',
                        'type'=>'raw',
                        'value'=>'$data->operasi->kegiatanoperasi->kegiatanoperasi_nama." /"."<br>".$data->operasi->operasi_nama',
                    ),
                    array(
                        'header'=>'Status Operasi',
                        'type'=>'raw',
                        'value'=>'$data->statusoperasi',
                    ),
                    array(
                        'header'=>'Dokter Pelaksana I /'."<br>".'Dokter Pelaksana II',
                        'type'=>'raw',
                        'value'=>'(isset($data->dokterpelaksana1_id)?$data->dokter1->nama_pegawai:"")." /"."<br>".(isset($data->dokterpelaksana2_id)?$data->dokter2->nama_pegawai:"")',
                    ),
                    array(
                        'header'=>'Dokter Anastesi',
                        'type'=>'raw',
                        'value'=>'(isset($data->dokteranastesi_id) ? $data->dokteranastesi->nama_pegawai:"")',
                    ),
                    array(
                        'header'=>'No. Rekam Medik/'."<br>".'No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'(isset($data->pasien_id) ? $data->pasien->no_rekam_medik:"")." /"."<br>".(isset($data->pendaftaran_id) ? $data->pendaftaran->no_pendaftaran:"")',
                    ),
                     array(
                        'header'=>'Nama Pasien '."<br>".'Bin - Binti',
                        'type'=>'raw',
                        'value'=>'$data->pasien->nama_pasien." bin"."<br>".$data->pasien->nama_bin',
                    ),
                     array(
                        'header'=>'Umur /'."<br>".'Jenis Kelamin',
                        'type'=>'raw',
                        'value'=>'$data->pendaftaran->umur." /"."<br>".$data->pasien->jeniskelamin',
                    ),
    //             
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php 
        $this->renderPartial('jadwalOperasi/_search',array(
                'model'=>$model,
        )); 
        ?>
    </fieldset>
</div>