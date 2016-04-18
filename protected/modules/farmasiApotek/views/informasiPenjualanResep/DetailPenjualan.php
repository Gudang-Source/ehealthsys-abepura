<table>
    <tr>
        <td>Tgl. Penjualan</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglpenjualan);?></td>
        <td></td>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->no_rekam_medik;?></td>
    </tr> 
    <tr>
        <td>Tgl. Resep</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglresep);?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->nama_pasien;?></td>
    </tr>
    <tr>
         <td><?php echo ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS) ? 'No. Nota' : "No. Resep";?></td>
        <td>:</td>
        <td><?php 
                    echo $modReseptur->noresep;
             ?></td>
        <td></td>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo  ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP OR  $modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP_LUAR) ? '-' : $modReseptur->pegawai->nama_pegawai;?></td>
    </tr>
</table>
<hr/>
<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead>
    
        <th>No.Urut</th>
        <th>Sumber Dana</th>
        <th><span hidden>Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br/></span>  Nama Obat</th>
        <th hidden>Satuan Kecil</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Discount</th>
        <th>SubTotal</th>
        <th>Status Bayar</th>
    
    </thead>
    <?php
    $no=1;
    $subtotals = 0;
    $totalSubTotal = 0;
        foreach($detailreseptur AS $tampilData):
            $subTotal = (($tampilData['qty_oa']*$tampilData['hargasatuan_oa']));
            $discount = ((($tampilData['hargasatuan_oa']*$tampilData['qty_oa'])*($tampilData['discount']/100)));
            if($tampilData['oasudahbayar_id'] != null){
                 $status = 'Sudah Lunas';
            }else{
                 $status = 'Belum Lunas';
            }
    echo "<tr>
            <td>".$no."</td>
            <td>".$tampilData->obatalkes->sumberdana->sumberdana_nama."</td>  
            <td>".//$tampilData->obatalkes->obatalkes_kategori."<br>".
            $tampilData->obatalkes->obatalkes_nama."</td>   
            <td hidden>".$tampilData->obatalkes->satuankecil->satuankecil_nama."</td>   
            <td style='text-align: right;'>".$tampilData['qty_oa']." ".$tampilData->obatalkes->satuankecil->satuankecil_nama."</td>
            <td style='text-align: right;'>".number_format($tampilData['hargasatuan_oa'],0,"",".")."</td> 
            <td style='text-align: right;'>".$discount."</td> 
            <td style='text-align: right;'>".number_format($subTotal-$discount,0,"",".")."</td>
            <td>".$status."</td>
            
                      
         </tr>";  
        $no++;
       
        $subtotals += ceil($subTotal-$discount);
//        $discounts +=$discount;
        $totalSubTotal=$totalSubTotal+$subTotal-$discount;
        
        endforeach;  
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Biaya Administrasi</td>
           
            <td style='text-align: right;'>".number_format($modReseptur->biayaadministrasi,0,"",".")."</td>
            <td></td>
         </tr>";   
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Biaya Service</td>
           
            <td style='text-align: right;'>".number_format($modReseptur->totaltarifservice,0,"",".")."</td>
            <td></td>
         </tr>";   
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Biaya Konseling</td>
           
            <td style='text-align: right;'>".number_format($modReseptur->biayakonseling,0,"",".")."</td>
            <td></td>
         </tr>";  
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Jasa Dokter Resep</td>
           
            <td style='text-align: right;'>".number_format($modReseptur->jasadokterresep,0,"",".")."</td>
            <td></td>
         </tr>";  
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Discount</td>
           
            <td style='text-align: right;'>".number_format($modReseptur->discount,0,"",".")."</td>
            <td></td>
         </tr>";  
     //     echo "<tr>
//            <td colspan='7' style='text-align:right;'> Total</td>
//           
//            <td>".number_format((($totalSubTotal) - ($totalSubTotal * ($modReseptur->discount/100))) + $modReseptur->biayaadministrasi+$modReseptur->biayakonseling+$modReseptur->totaltarifservice+$modReseptur->jasadokterresep)."</td>
//            <td></td>
//         </tr>"; 
    $total = $subtotals+$modReseptur->biayaadministrasi+$modReseptur->totaltarifservice+$modReseptur->biayakonseling;//+$modReseptur->jasadokterresep << SDH TERMASUK DLM HARGA OBAT
     echo "<tr>
            <td colspan='6' style='text-align:right;'> Total</td>
           
            <td style='text-align: right;'>".number_format($total,0,"",".")."</td>
            <td></td>
         </tr>";  
    ?>
    
</table>