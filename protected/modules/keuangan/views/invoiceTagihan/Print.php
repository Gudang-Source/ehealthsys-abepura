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
');
?>  
<?php
if(!$modInvoiceTagDetail){
    echo "Detail Tagihan tidak ditemukan"; exit;
}
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<body class="kertas">
    <table class='table'>
        <tr>
			<td>
				<b>Tanggal Invoice : </b>
				<?php echo isset($modInvoiceTagihan->invoicetagihan_tgl) ? $format->formatDateTimeId($modInvoiceTagihan->invoicetagihan_tgl) : "-"; ?>
				<br />
				<b>No. Invoice : </b>
				<?php echo isset($modInvoiceTagihan->invoicetagihan_no) ? $modInvoiceTagihan->invoicetagihan_no : "-"; ?>
				<br />
				<b>Dari : </b>
				<?php echo isset($modInvoiceTagihan->namapenagih) ? $modInvoiceTagihan->namapenagih : "-"; ?>
				<br />
			</td>
			<td>
				<b>Perihal : </b>
				<?php echo isset($modInvoiceTagihan->perihal_tagihan) ? $modInvoiceTagihan->perihal_tagihan : "-"; ?>
				<br />
				<b>Total Tagihan : </b>
				<?php echo isset($modInvoiceTagihan->total_tagihan) ? $format->formatUang($modInvoiceTagihan->total_tagihan) : "-"; ?>
				<br />
			</td>
		</tr>
    </table><br/><br>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <th>Uraian</th>
            <th>Total</th>
            <th>Keterangan</th>
        </thead>
        <?php 
			foreach ($modInvoiceTagDetail as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo !empty($detail['uraian_tagdetail'])?$detail['uraian_tagdetail']:null;  ?></td>
                <td><?php echo !empty($detail['total_tagdetail'])? $detail['total_tagdetail']:null; ?></td>
				<td><?php echo !empty($detail['ket_tagdetail'])?$detail['ket_tagdetail']:null; ?></td>
            </tr>
        <?php } ?>
    </table>
	<br><br>
	<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead class="border">
            <th>Uraian Disposisi</th>
            <th>Total Disposisi</th>
            <th>Keterangan Disposisi</th>
        </thead>
        <?php 
			foreach ($modInvoiceDisposisi as $j=>$disposisi){ 
        ?>
            <tr>
                <td><?php echo !empty($disposisi['uraian_disposisi'])?$disposisi['uraian_disposisi']:null;  ?></td>
                <td><?php echo !empty($disposisi['total_disposisi'])? $disposisi['total_disposisi']:null; ?></td>
				<td><?php echo !empty($disposisi['ket_disposisi'])?$disposisi['ket_disposisi']:null; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
