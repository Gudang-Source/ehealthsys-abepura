<?php
    Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<?php
	$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$data = $model->searchLaporan();
    if (isset($caraPrint)){
		$data = $model->searchLaporanPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
    } else{
        $data = $model->searchLaporan();
		$template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
		    'header' => 'No.',
			'headerHtmlOptions'=>array('style'=>'text-align:left;'),
		    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
		),
		array(
			'header'=>'Tanggal Masuk (SEP)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->verifikasi_tglsep)',
		),
		array(
			'header'=>'Tanggal Pulang',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->verifikasi_tglpulang)',
		),
		array(
			'header'=>'Jenis Pelayanan',
			'type'=>'raw',
			'value'=>'$data->verifikasiinasis_jnspelayanan',
		),
		array(
			'header'=>'Kelas Pelayanan',
			'type'=>'raw',
			'value'=>'$data->verifikasiinasis_kelaspelayanan',
		),
		array(
			'header'=>'Status',
			'type'=>'raw',
			'value'=>'$data->verifikasiinasis_status',
		),
		array(
			'header'=>'No. RM',
			'type'=>'raw',
			'value'=>'$data->no_rekam_medik',
		),
		array(
			'name'=>'No. Peserta',
			'type'=>'raw',
			'value'=>'$data->sep',
		),
		array(
			'name'=>'Nama Pasien',
			'type'=>'raw',
			'value'=>'$data->nama_pasien',
		),
		array(
			'name'=>'No. SEP',
			'type'=>'raw',
			'value'=>'$data->nosep',
		),
		array(
			'name'=>'Kode INA-CBG',
			'type'=>'raw',
			'value'=>'$data->verifikasi_kdinacbg',
		),
		array(
			'name'=>'Nama INA-CBG',
			'type'=>'raw',
			'value'=>'$data->verifikasi_nminacbg',
		),	
		array(
			'name'=>'Total Tagihan',
			'type'=>'raw',
			'value'=>'number_format($data->verifikasi_bytagihan)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Total Gruper',
			'type'=>'raw',
			'value'=>'number_format($data->verifikasi_bytarifgruper)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Tagihan Pelayanan RS',
			'type'=>'raw',
			'value'=>'number_format($data->verifikasi_bytagihanrs)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Top Up',
			'type'=>'raw',
			'value'=>'number_format($data->verifikasi_bytopup)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>