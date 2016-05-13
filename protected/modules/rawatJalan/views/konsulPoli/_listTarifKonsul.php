<legend class="rim"> Daftar Tindakan Konsultasi Poliklinik</legend>
<table class="items table table-striped table-bordered table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>Ruangan Tujuan</th>
            <th>Nama Tindakan</th>
            <th>Tarif</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        if(count($model) > 0){
        foreach ($model as $i => $konsul) { ?>
        <tr>
            <td><?php echo $ruangan_nama ?></td>
            <td><?php echo $konsul->daftartindakan->daftartindakan_nama ?></td>
            <td><?php echo MyFormatter::formatNumberForPrint($konsul->harga_tariftindakan); ?></td>
        </tr>
    <?php } ?>
    <?php }else{ ?>
        <tr>
            <td colspan="3">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>