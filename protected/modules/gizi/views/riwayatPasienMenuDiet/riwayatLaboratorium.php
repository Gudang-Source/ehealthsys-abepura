<table id="tblListPemeriksaanLab" class="table table-bordered table-condensed" >
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Laboratorium</th>
            <th>No. Permintaan</th>
            <th>Jenis Pemeriksaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Hasil Pemeriksaan</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) { 
	$modPermintaan = GZPermintaankepenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
	?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> </td>
        <td><?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama).'<br/>';
            } ?></td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->pemeriksaanlab_nama).'<br/>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br/>';
            } ?>
        </td>
	<td>
            <?php
		if(!empty($modhasil->detailhasilpemeriksaanlab_id)){
		    foreach ($modhasil as $h => $hasil){
			echo $hasil->hasilpemeriksaan.'<br/>';
		    }
		}else{
		    echo "<i>Belum Diperiksa</i>";
		}
	    ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
    
</table>