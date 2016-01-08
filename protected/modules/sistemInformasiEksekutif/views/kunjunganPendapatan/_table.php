<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
$table = "table table-striped table-condensed";
$format = new MyFormatter();

if (isset($caraPrint)) {
    $layout = '';
    $table = 'table table-striped';
//        $data = $modelLaporan->searchNeraca();
    $template = "{summary}\n{items}\n{pager}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $layout = 'max-width:1250px;overflow-x:scroll;';
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Tabel Pendapatan Terhadap Kunjungan</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>

    <div class="panel-body">
        <div id="table-grid" class="grid-view" style="<?php echo $layout; ?>">
            <table class="<?php echo $table; ?>">
                <thead>
                    <tr>
                        <th id="tableLaporan_c0">
                            Periode
                        </th>
                        <th id="tableLaporan_c0">
                            Pendapatan
                        </th>
                        <th id="tableLaporan_c0">
                            Kunjungan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_pendapatan = 0;
                    $total_kunjungan = 0;
                    foreach ($dataTable as $value) {
                        ?> <tr>
                            <td>
                                <?php
                                if ($model->jns_periode == "bulan") {
                                    echo $format->formatMonthForUser(date('Y-m', (strtotime($value['periode']))));
                                } else if ($model->jns_periode == "tahun") {
                                    echo date('Y', (strtotime($value['periode'])));
                                } else {
                                    echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($value['periode']))));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo number_format($value['jumlah_pendapatan']);
                                $total_pendapatan += $value['jumlah_pendapatan'];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo number_format($value['jumlah_kunjungan']);
                                $total_kunjungan += $value['jumlah_kunjungan'];
                                ?>
                            </td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td>
                            <strong>Total</strong>
                        </td>
                        <td>
                            <?php echo number_format($total_pendapatan); ?>
                        </td>
                        <td>
                            <?php echo number_format($total_kunjungan); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>