<!--
Data dibawah masih belum valid dikarenakan data di tabel penyusutanaset_v belum ada dan belum ada format yang ditentukan
-->
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
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
if(!$modPenyusutanAsetDetail){
    echo "Data tidak ditemukan"; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
?>
<body>
	<table style='width:100%'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPenyusutanAset->getAttributeLabel('no_penyusutan')); ?>:</b>
            <?php echo CHtml::encode($modPenyusutanAset->no_penyusutan); ?>
            <br />
            <b><?php echo CHtml::encode($modPenyusutanAset->getAttributeLabel('tgl_penyusutan')); ?>:</b>
            <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modPenyusutanAset->tgl_penyusutan)); ?>
             <br/>
        </td>
        <td>
            <b><?php //echo CHtml::encode($modPenyusutanAset->getAttributeLabel('ruangan_id')); ?></b>
            <?php //echo CHtml::encode($modPenyusutanAset->ruangan->ruangan_nama); ?>
            <br />
            <b><?php //echo CHtml::encode($modPenyusutanAset->getAttributeLabel('untukkeperluan')); ?></b>
            <?php //echo CHtml::encode($modPenyusutanAset->untukkeperluan); ?>
            <br />
        </td>
    </tr>   
</table>
    <p>&nbsp;</p>
<table id="tableObatAlkes" style="width:100%">
    <thead>
        <th class = "border">No. Urut</th>
        <th class = "border">Periode</th>
        <th class = "border">Saldo</th>
        <th class = "border">Persentase</th>
      <!--  <th>Catatan</th>-->
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modPenyusutanAsetDetail AS $detail): ?>
            <tr>   
                <td class = "border" style = "text-align:center;"><?php echo $no; ?></td>
                <td class = "border"><?php echo MyFormatter::formatDateTimeForUser($detail->penyusutanaset_periode); ?></td>
                <td class = "border" style = "text-align:right;"><?php echo number_format($detail->penyusutanaset_saldo,0,"",'.'); ?></td>
                <td class = "border" style = "text-align:right;"><?php echo $detail->penyusutanaset_persentase; ?></td>                
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
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
        pemakaianbarang_id = '<?php echo isset($modPenyusutanAset->penyusutanaset_id) ? $modPenyusutanAset->penyusutanaset_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penyusutanaset_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                    <!--    <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php //echo Yii::app()->user->getState('nama_pegawai'); ?></div> -->
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
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
