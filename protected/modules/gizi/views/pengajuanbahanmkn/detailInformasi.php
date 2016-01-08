<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('nopengajuan')); ?>:</b>
            <?php echo CHtml::encode($modPengajuan->nopengajuan); ?>
            <br />
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('tglpengajuanbahan')); ?>:</b>
            <?php echo CHtml::encode($modPengajuan->tglpengajuanbahan); ?>
             <br/>
             
        </td>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php echo CHtml::encode($modPengajuan->ruangan->ruangan_nama); ?>
            <br />
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($modPengajuan->create_time); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
    
        <th>No. Urut</th>
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
    
    </thead>
    <tbody>
    <?php
    $no=1;
    $subTotal = 0;
    $totalSubTotal = 0;
        foreach($modDetailPengajuan AS $tampilData):
            $subTotal = $tampilData->qty_pengajuan*$tampilData->harganettobhn;
    echo "<tr>
            <td>".$tampilData->nourutbahan."</td>
            <td>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td>".$tampilData->bahanmakanan->namabahanmakanan."</td>   
            <td>".$tampilData->bahanmakanan->jmlpersediaan."</td>   
            <td>".$tampilData->satuanbahan."</td>   
            <td>".$tampilData->harganettobhn."</td>   
            <td>".$tampilData->bahanmakanan->hargajualbahan."</td>   
            <td>".$tampilData->bahanmakanan->tglkadaluarsabahan."</td>   
            <td>".$tampilData->qty_pengajuan."</td>   
            <td>".$subTotal."</td>     
            
                      
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
           
            <td>".$totalSubTotal."</td>
         </tr>";   
        ?>
    </tfoot>
</table>