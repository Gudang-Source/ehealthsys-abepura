<?php if(!isset($_GET['caraPrint'])) $class = "table table-bordered table-condensed"; else $class = "table table-striped table-bordered table-condensed"; ?>
<table>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nofaktur')); ?>:</b>
            <?php echo CHtml::encode($modFakturPembelian->nofaktur); ?>
            <br />
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglfaktur')); ?>:</b>
            <?php echo CHtml::encode($modFakturPembelian->tglfaktur); ?>
            <br />
        </td>
        <td>
            <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('totharganetto')); ?>:</b>
            <?php echo "Rp. ".CHtml::encode(number_format($modFakturPembelian->totharganetto)); ?>
            <br />
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('jmldiscount')); ?>:</b>
            <?php echo CHtml::encode($modFakturPembelian->jmldiscount); ?>
            <br />
        </td>
    </tr>   
</table>
<hr/>
<table id="tableObatAlkes" class="<?php echo $class; ?>">
    <thead>
    <tr>
        <th>No.Urut</th>
        <th>Sumber Dana</th>
        <th>Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br/>Nama Obat</th>
        <th>Satuan Kecil/<br/>Satuan Besar<br/></th>
        <th>Jumlah Diterima</th>
        <th>Harga Netto</th>
        <th>Harga PPN</th>
        <th>Harga PPH</th>
        <th>Jumlah Diskon</th>
        <th>Harga Satuan</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $no=1;
        $totalJumlahDiterima = 0;
        $totalNetto = 0;
        $totalPPN = 0;
        $totalPPH = 0;
        $totalJumlahDiskon = 0;
        $totalHargaSatuan = 0;
        $hargappn = 0;
        $hargapph = 0;
        $hargappnfaktur = 0;
        $hargapphfaktur = 0;
        if (isset($modFakturPembelianDetails)){
            if (count($modFakturPembelianDetails) > 0){
                foreach($modFakturPembelianDetails AS $tampilData):
                    if($tampilData['persenppnfaktur'] <= 0){
                        $hargappnfaktur = 0;
                    }else{
                        $hargappn = $tampilData['harganettofaktur'] * ($tampilData['persenppnfaktur'] / 100);
                        $hargappnfaktur = $tampilData['harganettofaktur'] + $hargappn;
                    }
                    if($tampilData['persenpphfaktur'] <= 0){
                        $hargapphfaktur = 0;
                    }else{
                        $hargapph = $tampilData['harganettofaktur'] * ($tampilData['persenpphfaktur'] / 100);
                        $hargapphfaktur = $tampilData['harganettofaktur'] + $hargapph;
                    }
                    
                    echo "<tr>
                            <td>".$no."</td>
                            <td>".$tampilData->sumberdana['sumberdana_nama']."</td>  
                            <td>".$tampilData->obatalkes['obatalkes_kategori']."<br>".$tampilData->obatalkes['obatalkes_nama']."</td>   
                            <td>".$tampilData->satuankecil['satuankecil_nama']."<br>".$tampilData->satuanbesar['satuanbesar_nama']."</td>   
                            <td>".$tampilData['jmlterima']."</td>
                            <td>".number_format($tampilData['harganettofaktur'])."</td>     
                            <td>".number_format($hargappnfaktur)."</td>     
                            <td>".number_format($hargapphfaktur)."</td> 
                            <td>".number_format($tampilData['jmldiscount'])."</td>        
                            <td>".number_format($tampilData['hargasatuan'])."</td>      
                         </tr>";  
                        $no++;
                        $totalJumlahDiterima+=$tampilData['jmlterima'];
                        $totalNetto+=$tampilData['harganettofaktur'];
                        $totalPPN+=$hargappnfaktur;
                        $totalPPH+=$hargapphfaktur;
                        $totalJumlahDiskon+=$tampilData['jmldiscount'];
                        $totalHargaSatuan+=$tampilData['hargasatuan'];
                endforeach;
            }
        }
        
    echo "</tbody><tfoot><tr>
            <td colspan='4'> Total</td>
            <td>".number_format($totalJumlahDiterima)."</td>
            <td>".number_format($totalNetto)."</td>
            <td>".number_format($totalPPN)."</td>
            <td>".number_format($totalPPH)."</td>
            <td>".number_format($totalJumlahDiskon)."</td>
            <td>".number_format($totalHargaSatuan)."</td>
         </tr></tfoot>";    
    ?>
</table>
<?php 
if(!isset($_GET['caraPrint'])){
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
}  
?> 
<?php if(isset($_GET['caraPrint'])){  ?>
<table width="100%">
    <tr> 
		<td>&nbsp;</td>
        <td align="center" width="30%"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".date('d M Y'); ?></td>
    </tr>
    <tr>
		<td class="tandatangan">Penerima Faktur</td>
		<td class="tandatangan">Petugas Keuangan</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan" ><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
</table><br/><br/>
            <div style="font-size: 9pt;">&nbsp;&nbsp;&nbsp;Print Date : 
    <?php echo date('d M Y H:i:s'); ?></div>
</td></tr></table>
<?php } ?>
<script>
function print(caraPrint)
{
    var pembelianbarang_id = '<?php echo isset($modFakturPembelian->fakturpembelian_id) ? $modFakturPembelian->fakturpembelian_id : null ?>';
    window.open('<?php echo $this->createUrl('detailsFaktur'); ?>&idFakturPembelian='+pembelianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}	
</script>