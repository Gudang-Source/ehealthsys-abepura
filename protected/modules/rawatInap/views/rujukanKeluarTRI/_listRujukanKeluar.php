<table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Dirujuk</th>
            <th>No. Pendaftaran</th>
            <th>Rumah Sakit Tujuan</th>
            <th>Dirujuk ke Bagian</th>
            <th>Dokter Tujuan</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <?php foreach ($modRiwayatRujukanKeluar as $i => $rujukan) { ?>
    <tr>
        <td><?php echo $rujukan->tgldirujuk ?></td>
        <td><?php echo $rujukan->pendaftaran->no_pendaftaran ?></td>
        <td><?php echo $rujukan->rujukankeluar->rumahsakitrujukan ?></td>
        <td><?php echo $rujukan->dirujukkebagian ?></td>
        <td><?php echo $rujukan->kepadayth ?></td>
        <td><?php echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailRujukan('.$rujukan->pasiendirujukkeluar_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail rujukan')); ?></td>
        <td>
            <a onclick="printRujukan('PRINT',<?php echo $rujukan->rujukankeluar_id; ?>);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-print"></i></a>
        </td>
    </tr>
    <?php } ?>
</table>
