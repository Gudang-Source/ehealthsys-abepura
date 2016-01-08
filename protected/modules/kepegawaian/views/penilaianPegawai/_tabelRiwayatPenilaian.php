
<table class="items table table-striped table-condensed" id="tblInputAnamnesa">
    <thead>
        <tr>
            <th>Tanggal Penilaian</th>
            <th>Periode Penilaian</th>
            <th>Total Score Level</th>
			<th>Rata-rata Level</th>
            <th>Performace Index</th>
            <th>Penilai</th>
            <th>Ubah</th>
        </tr>
    </thead>
    <?php foreach ($tabelPenilaian as $i => $penilaian) { ?>
    <tr>
        <td><?php echo $format->formatDateTimeForUser($penilaian->tglpenilaian); ?></td>
        <td><?php echo $format->formatDateTimeForUser($penilaian->periodepenilaian)."-".$format->formatDateTimeForUser($penilaian->sampaidengan); ?></td>
        <td><?php echo isset($penilaian->jumlahpenilaian)?$penilaian->jumlahpenilaian:"-"; ?></td>
        <td><?php echo isset($penilaian->nilairatapenilaian)?$penilaian->nilairatapenilaian:"-"; ?></td>
        <td><?php echo isset($penilaian->performaceindex)?$penilaian->performaceindex:"-"; ?></td>
        <td><?php echo isset($penilaian->penilainama)?$penilaian->penilainama:"-"; ?></td>
        <td><center>
        <?php
            echo CHtml::link("<i class='icon-pencil'></i>", 
                    array('PenilaianPegawai/index', 'id'=>$penilaian->pegawai_id)); 
        ?>
        </center></td>
    </tr>
    <?php } ?>
</table>