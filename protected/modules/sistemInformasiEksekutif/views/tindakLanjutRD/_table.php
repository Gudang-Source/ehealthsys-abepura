<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Tabel Tindak Lanjut IGD</div>
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
                    'header' => 'Rawat Inap',
                    'name' => 'jumlah_dirawat',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_dirawat)',
                    'footer' => 'sum(jumlah_dirawat)',
                ),
                array(
                    'header' => 'Rawat Jalan',
                    'name' => 'jumlah_dirujuk',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_dirujuk)',
                    'footer' => 'sum(jumlah_dirujuk)',
                ),
                array(
                    'header' => 'Pasien Pulang',
                    'name' => 'jumlah_pulang',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_pulang)',
                    'footer' => 'sum(jumlah_pulang)',
                ),
                array(
                    'header' => 'Pasien Meninggal',
                    'name' => 'jumlah_meninggal',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_meninggal)',
                    'footer' => 'sum(jumlah_meninggal)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>