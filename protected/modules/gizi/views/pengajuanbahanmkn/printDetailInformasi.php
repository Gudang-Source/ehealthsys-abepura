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
<table width="100%" style = "box-shadow:none;" >
    <tr><th style = "text-align:center;" colspan="5"><h4><?php echo $judulLaporan; ?></h4><br></th></tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('nopengajuan')); ?></b>                                                                           
        </td>
        <td>: <?php echo CHtml::encode($modPengajuan->nopengajuan); ?></td>
        <td>&nbsp;</td>
        <td><b>Pegawai Mengajukan</b></td>
        <td>: <?php echo CHtml::encode($modPengajuan->mengajukan->namaLengkap); ?></td>
    <tr>
    </tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('tglpengajuanbahan')); ?></b>            
        </td>
        <td>
            : <?php echo CHtml::encode($modPengajuan->tglpengajuanbahan); ?>
        </td>
        <td>&nbsp;</td>
        <td><b>Pegawai Mengetahui</b></td>
        <td>: <?php echo !empty($modPengajuan->idpegawai_mengetahui)?$modPengajuan->mengetahui->namaLengkap:'-'; ?></td>
    </tr>   
    </tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('supplier_id')); ?></b>            
        </td>
        <td>
            : <?php echo CHtml::encode($modPengajuan->supplier->supplier_nama); ?>
        </td>
        <td>&nbsp;</td>
        <td><b>Status Persetujuan</b></td>
        <td>: <?php echo ($modPengajuan->status_persetujuan == FALSE)?"BELUM DISETUJUI":"SUDAH DISETUJUI"; ?></td>
    </tr>  
</table>
<br>
<table id="tableObatAlkes" class="table" style = "box-shadow:none;">
    <thead>
    
        <th  class = "border">No. Urut</th>
        <th  class = "border">Golongan</th>
        <th  class = "border">Jenis</th>
        <th  class = "border">Kelompok</th>
        <th  class = "border">Nama</th>
        <!--<th  class = "border">Jumlah Persediaan</th>
        <th  class = "border">Satuan</th>-->
        <th  class = "border">Harga Netto</th>
        <th  class = "border">Harga Jual</th>
        <th class = "border">Tanggal Kadaluarsa</th>
        <th  class = "border">Jumlah</th>
        <th  class = "border">Sub Total</th>
    
    </thead>
    <tbody>
    <?php
    $no=1;
    $subTotal = 0;
    $totalSubTotal = 0;
        foreach($modDetailPengajuan AS $tampilData):
            $subTotal = $tampilData->qty_pengajuan*$tampilData->harganettobhn;
    echo "<tr>
            <td  class = 'border'>".$tampilData->nourutbahan."</td>
            <td  class = 'border'>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td class = 'border'>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td class = 'border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class = 'border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>                              
            <td class = 'border'  style = 'text-align:right;'>".number_format($tampilData->harganettobhn,0,"",".")."</td>   
            <td class = 'border'  style = 'text-align:right;'>".number_format($tampilData->bahanmakanan->hargajualbahan,0,"",".")."</td>   
            <td class = 'border' >".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td class = 'border' style = 'text-align:right;'>".number_format($tampilData->qty_pengajuan,0,"",".").' '.$tampilData->satuanbahan."</td>   
            <td class = 'border' style = 'text-align:right;'>".number_format($subTotal,0,"",".")."</td>     
            
                      
         </tr>";  
        $no++;
       
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
     
    ?>
    </tbody>
    <tfoot>
        <?php
        echo "<tr>
            <td  class = 'border' colspan='9' style='text-align:right;'><b> Total Harga Netto</b></td>
           
            <td  class = 'border' style = 'text-align:right;'><b>".number_format($totalSubTotal,0,"",".")."</b></td>
         </tr>";   
        ?>
    </tfoot>
</table>
    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="30%" align="center">
                        <div><br>Petugas Mengajukan</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modPengajuan->idpegawai_mengajukan) ? $modPengajuan->mengajukan->namaLengkap : "&nbsp;" ?></div>
                        <hr style = "padding:0px;margin:0px;border:1px solid #555;">
                        <div>
                            <?php echo isset($modPengajuan->idpegawai_mengajukan) ? 'NIP. '.$modPengajuan->mengajukan->nomorindukpegawai : "&nbsp;" ?>                            
                        </div>
                    </td>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="45%" style="text-align:right;">
                       
                        <div>
                            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br>
                            Petugas Mengetahui</div>
                       
                        <div style="margin-top:60px;">                            
                            <?php echo isset($modPengajuan->idpegawai_mengetahui) ? $modPengajuan->mengetahui->namaLengkap : "&nbsp;" ?>                            
                        </div>
                        <hr style = "padding:0px;margin:0px;border:1px solid #555;height:1px;">
                        <div>
                            <?php echo isset($modPengajuan->idpegawai_mengetahui) ? 'NIP. '.$modPengajuan->mengetahui->nomorindukpegawai : "&nbsp;" ?>                            
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>


    
