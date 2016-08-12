<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaanbahan')); ?>:</b>
            <?php echo CHtml::encode($modTerima->nopenerimaanbahan); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterimabahan')); ?>:</b>
            <?php echo CHtml::encode($modTerima->tglterimabahan); ?>

             
        </td>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php echo CHtml::encode($modTerima->ruangan->ruangan_nama); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($modTerima->create_time); ?>

        </td>
    </tr>   
</table>

<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Jenis</th>
        <th>Kelompok</th>
        <th>Nama</th>
        <th>Jumlah Persediaan</th>
        <th>Satuan</th>
        <th>Harga Netto</th>
        <th>Harga Jual</th>
        <th>Tanggal Kadaluarsa</th>
        <th>Jumlah</th>
        <th>Sub Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalSubTotal= "";
    $no=1;
        foreach($modDetailTerima AS $tampilData):
            $subTotal = $tampilData->qty_terima*$tampilData->harganettobhn;
    echo "<tr>
            <td>".$tampilData->nourutbahan."</td>
            <td>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td>".$tampilData->bahanmakanan->namabahanmakanan."</td>   
            <td style='text-align: right;'>".$tampilData->bahanmakanan->jmlpersediaan."</td>   
            <td>".$tampilData->satuanbahan."</td>   
            <td style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->harganettobhn)."</td>   
            <td style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->bahanmakanan->hargajualbahan)."</td>   
            <td>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td style='text-align: right;'>".number_format($tampilData->qty_terima,0,"",".")."</td>   
            <td style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($subTotal)."</td>     
            
                      
         </tr>";  
        $no++;
        
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
     
    ?>
    </tbody>
    <tfoot>
        <?php
        echo "<tr>
            <td colspan='11' style='text-align:right;'> Total Harga Netto</td>
           
            <td style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($totalSubTotal)."</td>
         </tr>";   
        ?>
    </tfoot>
</table>