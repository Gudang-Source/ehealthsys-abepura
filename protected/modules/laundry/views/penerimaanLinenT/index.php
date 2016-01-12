<div class="white-container">
    <legend class="rim2">Transaksi <b>Penerimaan Linen</b></legend>
    <?php
    $this->breadcrumbs=array(
            'LApenerimaanlinen Ts'=>array('index'),
            'Create',
    );

    ?>
    <?php 
        if(!empty($_GET['sukses'])){   
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Penerimaan Linen berhasil disimpan !"); $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php } ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'lapenerimaanlinen-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this)'),
		'focus'=>'#',
	)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Penerimaan</legend>
		<?php echo $this->renderPartial($this->path_view.'_formPenerimaan', array(
            'model'=>$model, 'form'=>$form, 'format'=>$format)); ?>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Linen</legend>
		<?php $this->renderPartial($this->path_view.'_tabelLinen', array('model'=>$model, 'form'=>$form, 'modPengajuanDetail'=>$modPengajuanDetail, 'form'=>$form)); ?>		
	</fieldset>	
<!-- RND-8869	
	<fieldset class="box">
		<legend class="rim">Linen</legend>
		<?php // $this->renderPartial($this->path_view.'_formLinen', array('model'=>$model, 'form'=>$form,)); ?>		
	</fieldset>

	<?php // echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

	<table class="table table-striped table-condensed" id="table-linen">
		<thead>
			<tr>
				<th>No. </th>
				<th>No. Register Linen</th>
				<th>Nama Barang</th>
				<th>Jenis Perawatan</th>
				<th>Keterangan</th>
				<th>Batal</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>-->
    <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['sukses'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','disabled'=>$disableSave)); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php	$content = $this->renderPartial($this->path_view.'tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function print(caraPrint)
{
    var penerimaanlinen_id = '<?php echo isset($_GET['penerimaanlinen_id']) ? $_GET['penerimaanlinen_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaanlinen_id='+penerimaanlinen_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>