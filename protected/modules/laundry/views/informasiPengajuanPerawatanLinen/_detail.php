<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<style>
    .border{
        border:1px solid #000;
    }    
    
    thead th{
        background:none;
        color:#000;    
    }
</style>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Perawatan', 'tglpengperawatanlinen', array('class' => 'control-label')); echo " :";?>
			<?php echo isset($model->tglpengperawatanlinen) ? $format->formatDateTimeId($model->tglpengperawatanlinen) : "-";  ?>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('No. Pengajuan Perawatan', 'pengperawatanlinen_no', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->pengperawatanlinen_no) ? $model->pengperawatanlinen_no : "-";  ?>
		</div>
	</div>
	<div class="span6">
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->ruangan_nama) ? $model->ruangan->ruangan_nama : "-";  ?>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Keterangan', 'keterangan_pengperawatanlinen', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->keterangan_pengperawatanlinen) ? $model->keterangan_pengperawatanlinen : "-";  ?>
		</div>
	</div>
</div>	
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead >
            <th class="border">Nama Linen</th>
            <th class="border">Jenis Perawatan</th>
            <th class="border">Keterangan</th>
        </thead>
        <?php 
			foreach ($modDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td class="border"><?php echo $modLinen->linen->namalinen; ?></td>
                <td class="border"><?php echo $modLinen->jenisperawatan; ?></td>
                <td class="border"><?php echo $modLinen->keterangan_pengperawatan; ?></td>
            </tr>
        <?php } ?>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengajukan<br></div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawai->nama_pegawai) ? $model->pegawai->nama_pegawai : "-"; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegawaiMengajukan->nama_pegawai) ? $model->pegawaiMengajukan->nama_pegawai : "-"; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/PengajuanPerawatanT/Print');
?>
<script type="text/javascript">
function print(caraPrint)
{
    var pengperawatanlinen_id = '<?php echo isset($model->pengperawatanlinen_id) ? $model->pengperawatanlinen_id : null; ?>';
    window.open('<?php echo $url; ?>&pengperawatanlinen_id='+pengperawatanlinen_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>