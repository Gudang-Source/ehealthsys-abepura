<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarPasienPulang-grid',
	'dataProvider'=>$modPasienYangPulang->searchRD(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(	
//                'tglpasienpulang',
		array(
                    'header'=>'Tgl. Pasien Pulang',
                    'value'=>'$data->tglpasienpulang',
                ),
                array(
                    'header'=>'Tgl. Pendaftaran/ <BR> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran',
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik'
                ),  
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien'
                ),
                array(
                    'header'=>'Jenis Kasus Penyakit',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ), 
                array(
                    'header'=>'Cara Bayar/ Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayardanPenjamin'
                ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        return $p->pegawai->namaLengkap;
                    },
                ),
                array(
                    'header'=>'Cara/ Kondisi Pulang',
                    'type'=>'raw',
                    'value'=>'$data->CaradanKondisiPulang'
		),
                
//                'tgladmisi',
                
//                'umur',
//                
                /*
                array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->KelasPelayanan'
                ),
                 * 
                 */ 
//                'jeniskasuspenyakit_nama',

//                array(
//                       'header'=>'Batal Pulang',
//                       'type'=>'raw',
//                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik Untuk Membatalkan Kepulangan"))',
//                    ),
                array(
                       'header'=>'Batal Pulang',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                           Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                               array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
              
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
echo CHtml::hiddenField('pasien_id','',array('readonly'=>TRUE));
echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>TRUE));
?>
