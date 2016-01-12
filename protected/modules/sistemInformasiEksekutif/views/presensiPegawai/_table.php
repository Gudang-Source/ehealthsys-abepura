<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Tabel Presensi Pegawai</div>
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
					'header' => 'Hadir',
					'name' => 'jumlah_hadir',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_hadir)',
					'footer' => 'sum(jumlah_hadir)',
				),
				array(
					'header' => 'Sakit',
					'name' => 'jumlah_sakit',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_sakit)',
					'footer' => 'sum(jumlah_sakit)',
				),
				array(
					'header' => 'Izin',
					'name' => 'jumlah_izin',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_izin)',
					'footer' => 'sum(jumlah_izin)',
				),
				array(
					'header' => 'Dinas',
					'name' => 'jumlah_dinas',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_dinas)',
					'footer' => 'sum(jumlah_dinas)',
				),
				array(
					'header' => 'Alpa',
					'name' => 'jumlah_alpa',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_alpa)',
					'footer' => 'sum(jumlah_alpa)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>