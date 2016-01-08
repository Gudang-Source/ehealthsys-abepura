<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Tabel Penerimaan dan Pengeluaran Umum</div>
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
					'header' => 'Penerimaan',
					'name' => 'jumlah_penerimaan',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_penerimaan)',
					'footer' => 'sum(jumlah_penerimaan)',
				),
				array(
					'header' => 'Pengeluaran',
					'name' => 'jumlah_pengeluaran',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_pengeluaran)',
					'footer' => 'sum(jumlah_pengeluaran)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>