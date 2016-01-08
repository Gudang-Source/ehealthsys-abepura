<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php if(!isset($caraPrint)){ ?>
<?php } ?>
<?php $this->widget($table,array(
    'id'=>'PPInfoKunjungan-v',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
    'mergeColumns' => array('instalasi_nama'),
    'columns'=>array(
        'instalasi_nama',
        'no_rekam_medik',
        'NamaNamaBIN',
        'no_pendaftaran',
        'umur',
        'jeniskelamin',
        'nama_perujuk',
        array(
               'header'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: left')
        ),  
        'alamat_pasien',
        'keterangan_batal'
//        'pasien_id',
//        'jenisidentitas',
//        'no_identitas_pasien',
//        'namadepan',
//        'nama_pasien',
//        'nama_bin',
        /*
        
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
        'no_rekam_medik',
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
        'pekerjaan_id',
        'pekerjaan_nama',

        'tgl_pendaftaran',
        'no_urutantri',
        'transportasi',
        'keadaanmasuk',
        'statusperiksa',
        'statuspasien',
        'kunjungan',
        'alihstatus',
        'byphone',
        'kunjunganrumah',
        'statusmasuk',

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
        'caramasuk_id',
        'caramasuk_nama',
        'shift_id',
        'golonganumur_id',
        'golonganumur_nama',
        'no_rujukan',

        'tanggal_rujukan',
        'diagnosa_rujukan',
        'asalrujukan_id',
        'asalrujukan_nama',
        'penanggungjawab_id',
        'pengantar',
        'hubungankeluarga',
        'nama_pj',
        'ruangan_id',
        'ruangan_nama',
        'instalasi_id',

        'jeniskasuspenyakit_id',
        'jeniskasuspenyakit_nama',
        'kelaspelayanan_id',
        'kelaspelayanan_nama',
        'rujukan_id',
        'pasienpulang_id',
        'profilrs_id',
        */
//        array(
//                        'header'=>Yii::t('zii','View'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{view}',
//        ),
//        array(
//                        'header'=>Yii::t('zii','Update'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{update}',
//                        'buttons'=>array(
//                            'update' => array (
//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                        ),
//                         ),
//        ),
//        array(
//                        'header'=>Yii::t('zii','Delete'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-remove'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendaftaran_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//        ),
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<?php //$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'PPInfoKunjungan-v',
//	'dataProvider'=>$data,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//            'no_rekam_medik',    
//            'NamaNamaBIN',
//            'jeniskasuspenyakit_nama',
//             array(
//               'name'=>'no_pendaftaran',
//               'type'=>'raw',
//               'value'=>'$data->no_pendaftaran',
//               'htmlOptions'=>array('style'=>'text-align: center; width:120px')
//            ),
//            'alamat_pasien',
//            'nama_pegawai',
//            array(
//               'name'=>'CaraBayar/Penjamin',
//               'type'=>'raw',
//               'value'=>'$data->CaraBayarPenjamin',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),            
//            array(
//               'name'=>'ruangan_nama',
//               'type'=>'raw',
//               'value'=>'$data->ruangan_nama',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//            array(
//               'name'=>'statusperiksa',
//               'type'=>'raw',
//               'value'=>'$data->statusperiksa',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); ?>