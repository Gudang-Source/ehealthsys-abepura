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
        <div class="panel-title">Tabel Pendapatan Rumah Sakit Berdasarkan Jasa</div>
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
                            Akun Pendapatan
                        </th>
                        <?php
                        foreach ($dataTable as $key => $value) {
                            ?><th id = "tableLaporan_c0">
                                <?php
                                if ($model->jns_periode == "bulan") {
                                    echo $format->formatMonthForUser(date('Y-m', (strtotime($value->periode))));
                                } else if ($model->jns_periode == "tahun") {
                                    echo date('Y', (strtotime($value->periode)));
                                } else {
                                    echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($value->periode))));
                                }
                                ?>
                            </th>
                        <?php }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Pendapatan Jasa Medis
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                            ?><td>
                                <?php
                                echo number_format($value->jumlah_medis, 0,"",".");
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td>
                           Pendapatan Jasa Paramedis
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                            ?><td>
                                <?php
                                echo number_format($value->jumlah_paramedis, 0,"",".");
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td>
                            <strong>Total</strong>
                        </td>
                        <?php
                        foreach ($dataTable as $key => $value) {
                            ?><td>
                                <?php
                                echo "<strong>" . number_format($value->jumlah_medis + $value->jumlah_paramedis, 0,"",".") . "</strong>";
                                ?>
                            </td>
                        <?php }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>