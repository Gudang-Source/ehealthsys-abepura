<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Total Pertambahan Pasien</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
		</div>
	</div>

	<div class="panel-body">
		<?php
		$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
		$sort = true;
		if (isset($caraPrint)) {
			$data = $model->searchPrint();
			$template = "{items}";
			$sort = false;
			if ($caraPrint == "EXCEL")
				$table = 'ext.bootstrap.widgets.BootExcelGridView';
		} else {
			$data = $dataTable;
			$template = "{summary}\n{items}\n{pager}";
		}
		
		// format date for value

		if ($model->jns_periode == "bulan") {
			$value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
		} elseif ($model->jns_periode == "tahun") {
			$value = "date('Y',(strtotime(" . "$" . "data->periode)))";
		} else {
			$value = "MyFormatter::formatDateTimeForUser(date('Y-m-d',(strtotime(" . "$" . "data->periode))))";
		}
		?>
		
		<?php
		$this->widget($table, array(
			'id' => 'table-grid',
			'dataProvider' => $data,
			'template' => $template,
			'enableSorting' => $sort,
			'itemsCssClass' => 'table table-striped table-condensed',
			'columns' => array(
				array(
					'header' => 'Periode',
					'type' => 'raw',
					'value' => $value,
					'footer' => 'Total',
				),
				array(
					'header' => 'Rumah Sakit',
					'name' => 'jumlah_rs',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_rs)',
					'footer' => 'sum(jumlah_rs)',
				),
				array(
					'header' => 'Klinik',
					'name' => 'jumlah_klinik',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_klinik)',
					'footer' => 'sum(jumlah_klinik)',
				),
				array(
					'header' => 'Dokter',
					'name' => 'jumlah_dokter',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_dokter)',
					'footer' => 'sum(jumlah_dokter)',
				),
				array(
					'header' => 'Puskesmas',
					'name' => 'jumlah_puskesmas',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_puskesmas)',
					'footer' => 'sum(jumlah_puskesmas)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>