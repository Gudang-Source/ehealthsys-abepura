<div class="white-container">
	<legend class='rim2'>Tabel Jumlah Pegawai Berdasarkan Kelompok Umur</legend>

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
        $data = $dataTableUmur;
        $template = "{summary}\n{items}\n{pager}";
    }

    ?>

    <?php
    $this->widget($table, array(
        'id' => 'tableumur-grid',
        'dataProvider' => $data,
        'template' => $template,
        'enableSorting' => $sort,
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Umur',
                'type' => 'raw',
                'value' => '$data->jenis',
                'footer' => 'Total',
            ),
            array(
                'header' => 'Laki - laki',
                'name' => 'jumlah_l',
                'type' => 'raw',
                'value' => 'number_format($data->jumlah_l)',
                'footer' => 'sum(jumlah_l)',
            ),
            array(
                'header' => 'Perempuan',
                'name' => 'jumlah_p',
                'type' => 'raw',
                'value' => 'number_format($data->jumlah_p)',
                'footer' => 'sum(jumlah_p)',
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</div>
</div>