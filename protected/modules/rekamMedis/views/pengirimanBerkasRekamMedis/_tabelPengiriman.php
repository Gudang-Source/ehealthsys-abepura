<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rkpeminjamandokumenrm-v-grid',
	'dataProvider'=>$modPengiriman->searchPengiriman(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=> 'Pilih',
			'type'=>'raw',
			'value'=>'
				CHtml::hiddenField(\'Dokumen[ii][dokrekammedis_id]\', $data->dokrekammedis_id).
				CHtml::hiddenField(\'Dokumen[ii][pasien_id]\', $data->pasien_id).
				CHtml::hiddenField(\'Dokumen[ii][pendaftaran_id]\', $data->pendaftaran_id).
				CHtml::hiddenField(\'Dokumen[ii][ruangan_id]\', $data->ruangan_id).
				CHtml::hiddenField(\'Dokumen[ii][peminjamanrm_id]\', $data->peminjamanrm_id).
				CHtml::checkBox(\'Dokumen[ii][cekList]\', false, array(\'onclick\'=>\'setUrutan();setLengkap();\', \'class\'=>\'cekList\'));
				',
		),
		'lokasirak_nama',
		'subrak_nama',
		array(
			'header'=>'Warna Dokumen',
			'type'=>'raw',
//                    'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
			'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(), true)',
		),
		'no_rekam_medik',
//		'pendaftaran.tgl_pendaftaran',
		'no_pendaftaran',
		'nama_pasien',
		'tanggal_lahir',
		'jeniskelamin',
		'alamat_pasien',
		'instalasi_nama',
		'ruangan_nama',
		array(
			'header'=>'Kelengkapan',
			'type'=>'raw',
			'value'=>'CHtml::checkBox(\'Dokumen[ii][kelengkapan]\', \'true\', array(\'class\'=>\'lengkap\'))',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array(
			'header'=>'Print',
			'class'=>'CCheckBoxColumn',     
//			'selectableRows'=>0,
			'id'=>'Dokumen[ii][printpengiriman]',
			'checked'=>'$data->printpeminjaman',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){
			var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
	}',
)); ?> 
<?php $dokumen = CHtml::activeId($model, 'dokrekammedis_id'); ?>