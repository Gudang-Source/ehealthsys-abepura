<?php $modLaporanlembarresep = new FALaporanlembarresepV; ?>
<?php $model = FALaporanlembarresepV::model()->findAll(FALaporanlembarresepV::model()->criteriaLaporan()); ?>
<div class="grid-view" id="laporan-grid">
    <div class="summary">Menampilkan <?php echo COUNT($model) ?> Hasil</div>
    <table class="table table-striped table-condensed">
        <thead>
            <tr>
                <th>Unit / Ruangan</th>
                <?php echo FALaporanlembarresepV::model()->getKolomCarabayarItems(); ?>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tr='';
                foreach ($model as $value)
                {
                    $tr = '<tr>';
                    $tr .= "<td>$value->instalasiasal_nama / $value->ruanganasal_nama</td>";
                    $tr .= FALaporanlembarresepV::model()->getCaraBayarValue('value', $value->instalasiasal_nama, $value->ruanganasal_nama, $tgl_awal, $tgl_akhir);
                    $tr .= FALaporanlembarresepV::model()->getCaraBayarValue('totalkeseluruhan', $value->instalasiasal_nama, $value->ruanganasal_nama, $tgl_awal, $tgl_akhir);
                    $tr .= '</tr>';
                    echo $tr;
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php echo FALaporanlembarresepV::model()->getCaraBayarTotal($tgl_awal, $tgl_akhir); ?>
            </tr>
        </tfoot>
    </table>
</div>