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
    .border{
        border:1px solid;
    }
    .kertas{
     width:100%;
    }
	.table {
		border: none;
		box-shadow: none;
	}
	.table td {
		padding: 2px;
	}
');
?>  
<?php
if(!$modDetailPemeliharaan){
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
            <?php echo CHtml::encode($modPemeliharaanAset->getAttributeLabel('pemeliharaanaset_no')); ?>
        </td>
		<td>:</td>
		<td width="100%">
			<?php echo isset($modPemeliharaanAset->pemeliharaanaset_no) ? $modPemeliharaanAset->pemeliharaanaset_no : "-"; ?>
		</td>
		<td nowrap>
			Tanggal Pemeliharaan Aset
		</td>
		<td>:</td>
		<td nowrap>
			<?php echo isset($modPemeliharaanAset->pemeliharaanaset_tgl) ? $format->formatDateTimeId($modPemeliharaanAset->pemeliharaanaset_tgl) : "-"; ?>
		</td>
	</tr>
	<tr>
        <td nowrap>
            Keterangan Pemeliharaan Aset
        </td>
		<td>:</td>
		<td><?php echo !empty($modPemeliharaanAset->pemeliharaanaset_ket) ? $modPemakaianBarang->pemeliharaanaset_ket : "-"; ?></td>
    </tr>   
	</table>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th class="border">Kode Barang</th>
            <th class="border">Nama Barang</th>
            <th class="border">Asal Aset</th>
            <th class="border">Kondisi Aset</th>
			<th>Keterangan Aset</th>
        </thead>
        <?php 
			foreach ($modDetailPemeliharaan as $i=>$modAset){ 
        ?>
            <tr>                
                <td class="border"><?php echo $modAset->barang->barang_kode; ?></td>
                <td class="border"><?php echo $modAset->barang->barang_nama; ?></td>
                <td class="border"><?php echo !empty($modAset->asalaset_id)?$modAset->asalaset->asalaset_nama:"-"; ?></td>
                <td class="border"><?php echo is_numeric($modAset->kondisiaset)?LookupM::model()->findByPk($modAset->kondisiaset)->lookup_name:$modAset->kondisiaset; ?></td>
                <td class="border"><?php echo $modAset->keteranganaset; ?></td>
            </tr>
        <?php } ?>
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
        pemeliharaanaset_id = '<?php echo isset($modPemeliharaanAset->pemeliharaanaset_id) ? $modPemeliharaanAset->pemeliharaanaset_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemeliharaanaset_id='+pemeliharaanaset_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
  <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="33%" align="center">
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo !empty($modPemeliharaanAset->pegmengetahui_id)?$modPemeliharaanAset->pegmengetahui->namaLengkap:"-"; ?></div>
                    </td>
                    <td width="33%" align="center">
                        <div>Petugas 1:</div>
                        <div style="margin-top:60px;"><?php echo !empty($modPemeliharaanAset->pegpetugas1_id)?$modPemeliharaanAset->pegpetugas1->namaLengkap:"-"; ?></div>
                        <div></div>
                    </td>
                    <td width="34%" align="center">
                        <div>Petugas 2:</div>
                        <div style="margin-top:60px;"><?php echo !empty($modPemeliharaanAset->pegpetugas2_id)?$modPemeliharaanAset->pegpetugas2->namaLengkap:"-"; ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
