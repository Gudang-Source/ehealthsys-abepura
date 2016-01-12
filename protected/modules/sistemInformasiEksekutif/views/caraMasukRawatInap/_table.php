<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Tabel Jumlah Rawat Inap Berdasarkan Cara Masuk</div>
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
					'header' => 'Langsung Rawat Inap',
					'name' => 'jumlah_ri',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_ri)',
					'footer' => 'sum(jumlah_ri)',
				),
				array(
					'header' => 'Melalui Rawat Darurat',
					'name' => 'jumlah_rd',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_rd)',
					'footer' => 'sum(jumlah_rd)',
				),
				array(
					'header' => 'Melalui Rawat Jalan',
					'name' => 'jumlah_rj',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_rj)',
					'footer' => 'sum(jumlah_rj)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>