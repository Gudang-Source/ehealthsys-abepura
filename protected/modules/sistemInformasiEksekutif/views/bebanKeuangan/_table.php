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
    $layout = 'max-width:1250px;max-height:400px;overflow-x:scroll;overflow-y:scroll;';
}


if ($model->jns_periode == "bulan") {
    $awal = $model->bln_awal;
    $akhir = $model->bln_akhir;
} elseif ($model->jns_periode == "tahun") {
    $awal = $model->thn_awal;
    $akhir = $model->thn_akhir;
} else {
    $awal = $model->tgl_awal;
    $akhir = $model->tgl_akhir;
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Tabel Beban - Periode <?php echo $awal; ?> sd <?php echo $akhir; ?></div>
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
                            Beban Layanan
                        </th>
                        <th id="tableLaporan_c0">
                            Beban Umum dan Administrasi
                        </th>
                        <th id="tableLaporan_c0">
                            Beban Lainnya
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_layanan = 0;
                    $total_umum = 0;
                    $total_lainnya = 0;

                    foreach ($dataTable as $data) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                if ($model->jns_periode == "bulan") {
                                    echo $format->formatMonthForUser(date('Y-m', (strtotime($data['periode']))));
                                } else if ($model->jns_periode == "tahun") {
                                    echo date('Y', (strtotime($data['periode'])));
                                } else {
                                    echo $format->formatDateTimeForUser(date('Y-m-d', (strtotime($data['periode']))));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($data['jumlah_layanan'])) {
                                    echo number_format($data['jumlah_layanan'], 0);
                                    $total_layanan += $data['jumlah_layanan'];
                                } else {
                                    echo 0;
                                    $total_layanan += 0;
                                }
                                ?>

                            </td>
                            <td>
                                <?php
                                if (isset($data['jumlah_umum'])) {
                                    echo number_format($data['jumlah_umum'], 0);
                                    $total_umum += $data['jumlah_umum'];
                                } else {
                                    echo 0;
                                    $total_layanan += 0;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($data['jumlah_lainnya'])) {
                                    echo number_format($data['jumlah_lainnya'], 0);
                                    $total_lainnya += $data['jumlah_lainnya'];
                                } else {
                                    echo 0;
                                    $total_layanan += 0;
                                }
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
                            <?php
                            echo "<strong>" . number_format($total_layanan, 0) . "</strong>";
                            ?>
                        </td>
                        <td>
                            <?php
                            echo "<strong>" . number_format($total_umum, 0) . "</strong>";
                            ?>
                        </td>
                        <td>
                            <?php
                            echo "<strong>" . number_format($total_lainnya, 0) . "</strong>";
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>