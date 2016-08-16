<style>
    .border{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php  echo $this->renderPartial('_headerPrint');  ?>
<table  class = "table" style = "box-shadow:none;">
    <tr><th style = "text-align:center;" colspan="2"><h4><?php echo $judulLaporan; ?></h4></th></tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaanbahan')); ?>:</b>
            <?php echo CHtml::encode($modTerima->nopenerimaanbahan); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterimabahan')); ?>:</b>
            <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb(CHtml::encode($modTerima->tglterimabahan))))); ?>
             
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

<table class = "table" style = "box-shadow:none;">
    <thead>
        <tr>
        <th class = "border">No.Urut</th>
        <th  class = "border">Golongan</th>
        <th  class = "border">Jenis</th>
        <th  class = "border">Kelompok</th>
        <th  class = "border">Nama</th>
       <!-- <th>Jumlah Persediaan</th>-->
        <!--<th>Satuan</th>-->
        <th  class = "border">Harga Netto</th>
        <th  class = "border">Harga Jual</th>
        <th  class = "border">Tanggal Kadaluarsa</th>
        <th  class = "border">Jumlah</th>
        <th  class = "border">Sub Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalSubTotal= "";
    $no=1;
        foreach($modDetailTerima AS $tampilData):
            $subTotal = $tampilData->qty_terima*$tampilData->harganettobhn;//<td style='text-align: right;'>".$tampilData->bahanmakanan->jmlpersediaan."</td>   
    echo "<tr>
            <td  class = 'border'>".$tampilData->nourutbahan."</td>
            <td class = 'border'>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td class = 'border'>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td class = 'border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class = 'border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>                           
            <td class = 'border' style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->harganettobhn)."</td>   
            <td class = 'border' style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->bahanmakanan->hargajualbahan)."</td>   
            <td class = 'border'>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td class = 'border' style='text-align: right;'>".number_format($tampilData->qty_terima,0,"",".").' '.$tampilData->satuanbahan."</td>   
            <td class = 'border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($subTotal)."</td>     
            
                      
         </tr>";  
        $no++;
        
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
     
    ?>
         <?php
        echo "<tr>
            <td class = 'border' colspan='9' style='text-align:right;'> <b>Total Harga Netto</b></td>
           
            <td class = 'border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($totalSubTotal)."</td>
         </tr>";   
        ?>
   
    </tbody>
    
       
</table>


    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" style="text-align:center;">
                       
                        <div>Petugas Penerima</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modTerima->penerima->pegawai->namaLengkap) ? $modTerima->penerima->pegawai->namaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>

