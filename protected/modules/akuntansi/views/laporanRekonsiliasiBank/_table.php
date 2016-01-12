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
			'header'=>'No. Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'$data->rekonsiliasibank_no',
		),
		array(
			'header'=>'Tanggal Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->rekonsiliasibank_tgl)',
		),
		array(
			'header'=>'Bank',
			'type'=>'raw',
			'value'=>'$data->namabank',
		),
		array(
			'header'=>'Jenis Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'$data->jenisrekonsiliasibank_nama',
		),
		array(
			'header'=>'Kode Rekening',
			'type'=>'raw',
			'value'=>'$data->getKodeRekening()',
		),
		array(
			'name'=>'Nama Rekening',
			'type'=>'raw',
			'value'=>'$data->getNamaRekening()',
		),
		array(
			'name'=>'Saldo Debit',
			'type'=>'raw',
			'value'=>'number_format($data->saldodebit)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Saldo Kredit',
			'type'=>'raw',
			'value'=>'number_format($data->saldokredit)',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>