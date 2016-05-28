<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <th>Bidang</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Sub Sub Kelompok</th>
            <th>Barang</th>
            <th>Harga Satuan</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Satuan</th>
            <th>Jumlah Dalam Kemasan</th>
            <th>Kondisi Barang</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $this->renderPartial('_rowBarang', array('modDetails' => $modDetails), true); ?>
    </tbody>
</table>

