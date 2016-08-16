<center>
  
<?php
if($caraprint=='EXCEL')
{

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'', 'colspan'=>10));      
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
	td {
		vertical-align: top;
	}
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
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
if(!$modRencanaKebBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
//echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
$tglrencana = MyFormatter::formatDateTimeForUser($modRencanaKebBarang->renkebbarang_tgl);
?>
<body class="kertas">
    <table class = "table" style = "box-shadow:none;" >
        <tr>
            <td style="text-align:center;" valign="middle" colspan="2">
                <b><u><h5><?php echo $judul_print.'<br></u>Tanggal : '.
                        $tglrencana; ?></h4></b>
            </td>
        </tr>
        <tr>
            <td><h4>No.  <?php echo $modRencanaKebBarang->renkebbarang_no; ?></h4></td>
            <td></td>
        </tr>
        
    </table>
    <?php 
        $tr = ($caraprint=='PDF')?'<tr>':'<thead>';
        $tr1 = ($caraprint=='PDF')?'</tr>':'</thead>';
    ?>
    <table class = "table" style = "box-shadow:none;" >
        <?php echo $tr; ?>
            <th class="border" style="text-align: center;">No.</th>
            <th class="border" style="text-align: center;">Asal Barang</th>
            <th class="border" width="200" style="text-align: center;">Nama Barang</th>
            <th class="border" style="text-align: center;">Satuan </th>
            <th class="border" style="text-align: center;">Jumlah Permintaan</th>
            <th class="border" width="75" style="text-align: center;">Harga</th>
            <th class="border" style="text-align: center;">Stok Akhir</th>
            <th class="border" style="text-align: center;">Minimal Stok</th>
            <th class="border" style="text-align: center;">Maksimal Stok</th>
            <th class="border" style="text-align: center;" nowrap>Sub Total</th>
        <?php echo $tr1; ?>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modRencanaKebBarangDetail as $i=>$modBarang){ 
			$barang = BarangM::model()->findByPk($modBarang->barang_id);
        ?>
            <tr>
                <td class="border" style="text-align: center;"><?php echo ($i+1)."."; ?></td>
                <td class="border" ><?php echo !empty($modBarang->asal_barang)?$modBarang->asal_barang:'-'; ?></td>
                <td class="border" ><?php echo (!empty($modBarang->barang_id)) ? $barang->barang_nama : ""; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->satuanbarangdet; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->jmlpermintaanbarangdet; ?></td>
                <td class="border" style="text-align: right;"><?php echo "Rp".number_format($modBarang->harga_barangdet,0,"","."); ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->stokakhir_barangdet; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->minstok_barangdet; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->makstok_barangdet; ?></td>
                <td class="border" style="text-align: right;" nowrap><?php 
                    $subtotal = ($modBarang->harga_barangdet * $modBarang->jmlpermintaanbarangdet);
                    $total += $subtotal;
                    echo "Rp".number_format($subtotal,0,"","."); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td class="border" colspan="9" style="text-align: right;"><strong>Total</strong></td>
            <td class="border" style="text-align: right;"><strong><?php echo "Rp".number_format($total,0,"","."); ?></strong></td>
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
        renkebbarang_id = '<?php echo isset($modRencanaKebBarang->renkebbarang_id) ? $modRencanaBarang->renkebbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&rencanakebfarmasi_id='+rencanakebfarmasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui</div>                        
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <?php 
                if($caraprint!='PRINT'){
                ?>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <?php
                }
                ?>
                <tr>
                    <td align="center">
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                    <td>&nbsp;</td>
                    <td align="center">
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegawai_id) ? $modRencanaKebBarang->pegawai->NamaLengkap : "" ?></div>                        
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center"><div>(Petugas Gudang Umum)</div></td>
                </tr>
                
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
