<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaan')); ?>:</b>
            <?php echo CHtml::encode($modTerima->nopenerimaan); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterima')); ?>:</b>
            <?php echo CHtml::encode($modTerima->tglterima); ?>
             <br/>
             
        </td>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('peg_penerima_id')); ?>:</b>
            <?php echo CHtml::encode($modTerima->penerima->nama_pegawai); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('ruanganpenerima_id')); ?>:</b>
            <?php echo CHtml::encode($modTerima->ruangan->ruangan_nama); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($modTerima->create_time); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Terima</th>
        <th>Satuan</th>
        <th>Ukuran<br/>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailTerima AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $detail->hargabeli; ?></td>
                <td><?php echo $detail->hargasatuan; ?></td>
                <td><?php echo $detail->jmlterima; ?></td>
                <td><?php echo $detail->satuanbeli; ?></td>
                <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
    ?>
    </tbody>
</table>