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
			'header'=>'Tanggal Laporan SEP',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->laporansep_tgl)',
		),
		array(
			'header'=>'Tanggal SEP',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglsep)',
		),
		array(
			'header'=>'Tanggal Pulang',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpulang)',
		),
		array(
			'header'=>'Kode INACBG',
			'type'=>'raw',
			'value'=>'$data->kdinacbg',
		),
		array(
			'header'=>'Nama INACBG',
			'type'=>'raw',
			'value'=>'$data->nminacbg',
		),
		array(
			'header'=>'Jenis Pelayanana',
			'type'=>'raw',
			'value'=>'$data->jnspelayanan',
		),
		array(
			'name'=>'No. Rekam Medik',
			'type'=>'raw',
			'value'=>'$data->nomr',
		),
		array(
			'name'=>'No. SEP',
			'type'=>'raw',
			'value'=>'$data->nosep',
		),
		array(
			'name'=>'No. Kartu',
			'type'=>'raw',
			'value'=>'$data->nokartu',
		),
		array(
			'name'=>'Nama Pasien',
			'type'=>'raw',
			'value'=>'$data->nama',
		),
		array(
			'name'=>'Kode Status SEP',
			'type'=>'raw',
			'value'=>'$data->kdstatsep',
		),
		array(
			'name'=>'Nama Status SEP',
			'type'=>'raw',
			'value'=>'$data->nmstatsep',
		),		
		array(
			'name'=>'Biaya Tagihan',
			'type'=>'raw',
			'value'=>'number_format($data->bytagihan)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Biaya Tarif Gruper',
			'type'=>'raw',
			'value'=>'number_format($data->bytarifgruper)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Biaya Tarif RS',
			'type'=>'raw',
			'value'=>'number_format($data->bytarifrs)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Biaya Top Up',
			'type'=>'raw',
			'value'=>'number_format($data->bytopup)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>