<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
    thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #000;
}

');
?>  

<?php
if(!$modPenerimaanBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="6">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Penerimaan Barang</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->noterima; ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>No. Faktur</td>
            <td>:</td>
            <td><?php echo $modFakturPembelian->nofaktur; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Tanggal Penerimaan Barang</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser(date('Y-m-d', strtotime($modPenerimaanBarang->tglterima))); ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>Tanggal Faktur</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser(date('Y-m-d', strtotime($modFakturPembelian->tglfaktur))); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>No. Surat Jalan</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->nosuratjalan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat Jalan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser(date('Y-m-d', strtotime($modPenerimaanBarang->tglsuratjalan))); ?></td>
        </tr>
        <tr>
            <td>Status Penerimaan</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->statuspenerimaan; ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead >
            <tr>
            <th class = "border" style="text-align: center;">No.</th>
            <th class = "border" style="text-align: center;">Asal Barang</th>
            <th class = "border" style="text-align: center;">Kategori / Nama Obat</th>
            <th class = "border" style="text-align: center;">No. Batch</th>
            <th class = "border" style="text-align: center;">Tanggal Kadaluarsa</th>
            <th class = "border" style="text-align: center;">Jumlah Kemasan</th>
            <th class = "border" style="text-align: center;">Jumlah Pembelian</th>
            <th class = "border" style="text-align: center;">Harga Satuan</th>
            <th class = "border" style="text-align: center;">Diskon (%)</th>
            <th class = "border" style="text-align: center;">Diskon Total (Rp.)</th>
            <th class = "border" style="text-align: center;">Sub Total</th>
            </tr>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modPenerimaanBarangDetail as $i=>$modObat){ 
			$modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$modObat->penerimaandetail_id));
        ?>
            <tr>
                <td align="center" class = "border"><?php echo ($i+1)."."; ?></td>
                <td class = "border"><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td class = "border"><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
                <td class = "border"><?php echo (!empty($modStokObatAlkes->nobatch) ? $modStokObatAlkes->nobatch : ""); ?></td>
                <td class = "border"><?php echo $format->formatDateTimeForUser($modObat->tglkadaluarsa); ?></td>
                <td align="center" class = "border"><?php echo (isset($modObat->kemasanbesar) ? $modObat->kemasanbesar : 0 )." ".(isset($modObat->satuankecil_id) ? $modObat->satuankecil->satuankecil_nama : $modObat->satuanbesar->satuanbesar_nama); ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->jmlterima,0,"","."); ?></td>
                <td style="text-align:right;" class = "border">Rp<?php echo number_format($modObat->harganettoper,0,"","."); ?></td>
                <td style="text-align:right;" class = "border"><?php echo $modObat->persendiscount; ?></td>
                <td style="text-align:right;" class = "border"><?php echo number_format($modObat->jmldiscount,0,"","."); ?></td>
                <td style="text-align:right;" class = "border"><?php 
                    $discount = $modObat->jmldiscount;
                    $subtotal = (($modObat->harganettoper * $modObat->jmlpermintaan) - $discount);
                    if($subtotal <=0 ){
                        $subtotal = 0;
                    }
                    $total += $subtotal;
                    echo "Rp".  number_format($subtotal,0,"","."); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td class = "border" colspan="10" style="text-align:right;"><strong>Total</strong></td>
            <td class = "border" style="text-align:right;"><b><?php echo "Rp".number_format($total,0,"","."); ?></b></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        penerimaanbarang_id = '<?php echo isset($modPenerimaanBarang->penerimaanbarang_id) ? $modPenerimaanBarang->penerimaanbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawai->NamaLengkap) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
