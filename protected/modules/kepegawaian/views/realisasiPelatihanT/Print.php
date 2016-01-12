<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$format = new MyFormatter();
echo "No. Rencana Pelatihan : <b>".$deskripsi."</b>";
?>
<table class="table">
    <thead>
        <tr style="border:1px solid;">
			<th>No. </th>
			<th>No. Induk Pegawai</th>
			<th>Nama Pegawai</th>
			<th>Jenis Pelatihan</th>
			<th>Nama Pelatihan</th>
			<th>Tanggal <br>Mulai Diklat</th>
			<th>Lama Pelatihan</th>
			<th>Tempat Pelatihan</th>
			<th>No. Keputusan</th>
			<th>Tanggal Penetapan</th>
			<th>Pimpinan</th>
			<th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($details as $i => $detail){
        ?>
        <tr>
            <td><?php echo $i+1; echo ". "; ?></td>
            <td><?php echo $detail->pegawai->nomorindukpegawai; ?></td>
            <td><?php echo $detail->pegawaidiklat_nama; ?></td>
            <td><?php echo $detail->jenisdiklat->jenisdiklat_nama; ?></td>
            <td><?php echo $detail->rencanadiklat->namadiklat; ?></td>
            <td><?php echo $format->formatDateTimeForUser(date("Y-m-d",strtotime($detail->pegawaidiklat_tahun))); ?></td>
            <td><?php echo $detail->pegawaidiklat_lamanya; ?></td>
            <td><?php echo $detail->pegawaidiklat_tempat; ?></td>
            <td><?php echo $detail->nomorkeputusandiklat; ?></td>
            <td><?php echo $format->formatDateTimeForUser(date("Y-m-d",strtotime($detail->tglditetapkandiklat))); ?></td>
            <td><?php echo $detail->pejabatygmemdiklat; ?></td>
            <td><?php echo $detail->pegawaidiklat_keterangan; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
