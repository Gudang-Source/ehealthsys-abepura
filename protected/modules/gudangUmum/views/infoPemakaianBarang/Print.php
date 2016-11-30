<center>
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
   .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }
    
    .table{
        box-shadow:none;
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
if(!$modPemakaianBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
?>
<body class="kertas">
	<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianBarang->getAttributeLabel('nopemakaianbrg')); ?> </b>
        </td>
        <td>
            : <?php echo isset($modPemakaianBarang->nopemakaianbrg) ? $modPemakaianBarang->nopemakaianbrg : "-"; ?>
        </td>
        <td>&nbsp;</td>
        <td>
            <b>Ruangan </b>
        </td>
        <td>
            : <?php echo isset($modPemakaianBarang->ruangan->ruangan_nama) ? $modPemakaianBarang->ruangan->ruangan_nama : "-"; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Tanggal Pemakaian Barang </b>
        </td>
        <td>
            : <?php echo isset($modPemakaianBarang->tglpemakaianbrg) ? $format->formatDateTimeForUser($modPemakaianBarang->tglpemakaianbrg) : "-"; ?>            
        </td>
        <td>
            &nbsp;
        </td>
        <td>                        
            <b>Untuk Keperluan </b>
        </td>
        <td>
            : <?php echo isset($modPemakaianBarang->untukkeperluan) ? $modPemakaianBarang->untukkeperluan : "-"; ?>
        </td>
    </tr>   
	</table>
    
	
    <table class ="table border" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Tipe Barang</th>
            <th>Nama Barang</th>
            <th>Merk / No. Seri</th>
            <th>Ukuran / Bahan Barang</th>
            <!--<th>Satuan</th>-->
            <th>Jumlah Pakai</th>
            <th>Harga Netto</th>
            <th>Harga Satuan</th>
        </thead>
        <?php 
			$total_harganetto = 0;
			$total_hargajual = 0;
			$total_jmlpakai = 0;
                        $no = 1;
			foreach ($modPemakaianBarangDetail as $i=>$modBarang){ 
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->barang->barang_kode; ?></td>
                <td><?php echo $modBarang->barang->barang_type; ?></td>
                <td><?php echo $modBarang->barang->barang_nama; ?></td>
                <td><?php echo $modBarang->barang->barang_merk." <br/> / ".$modBarang->barang->barang_noseri; ?></td>
                <td><?php echo $modBarang->barang->barang_ukuran." <br/> / ".$modBarang->barang->barang_bahan; ?></td>
                <td><?php echo number_format($modBarang->jmlpakai,0,"",".")." ".$modBarang->satuanpakai; ?></td>
                <!--<td><?php //echo $modBarang->satuanpakai; ?></td>-->
				<!--<td style="text-align:center;"><?php //echo ($modBarang->jmlpakai); ?></td>-->
                <td style="text-align:right;"><?php echo number_format($modBarang->harganetto,0,"","."); ?></td>
				<td style="text-align:right;"><?php echo number_format($modBarang->hargajual,0,"","."); ?></td>
				<?php
					$total_harganetto += $modBarang->harganetto;
					$total_hargajual += $modBarang->hargajual;
					$total_jmlpakai += $modBarang->jmlpakai;
				?>
            </tr>
        <?php $no++;} ?>
        <tr>
            <td colspan="6" align="center"><strong>Total</strong></td>
            <td style="text-align: center;"><?php echo number_format($total_jmlpakai,0,"","."); ?></td>
            <td style="text-align: right;"><?php echo number_format($total_harganetto,0,"","."); ?></td>
            <td style="text-align: right;"><?php echo number_format($total_hargajual,0,"","."); ?></td>
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
        pemakaianbarang_id = '<?php echo isset($modPemakaianBarang->pemakaianbarang_id) ? $modPemakaianBarang->pemakaianbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemakaianbarang_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemakaianBarang->pegawai->namaLengkap ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
