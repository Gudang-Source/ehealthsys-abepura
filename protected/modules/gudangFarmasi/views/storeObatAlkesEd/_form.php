<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfstoreed-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>
<?php $disabled = isset($_GET['sukses'])?true:false; ?>
<?php $disabled2 = isset($_GET['sukses'])?false:true; ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">
	<legend class="rim">Obat dan Alat Kesehatan</legend>
	<div class="row-fluid">
		<?php $this->renderPartial($this->path_view.'_formInputObat', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails, 'disabled'=>$disabled)); ?>
	</div>
	<div class="block-tabel">
		<h6>Tabel <b>Store Obat Alkes Expired Date</b></h6>
		<table class="items table table-striped table-condensed" id="table-obatalkesED">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama Obat</th>
					<th>Supplier</th>
					<th>Tanggal Kadaluarsa</th>
					<th>Jumlah</th>
					<th>Satuan Kecil</th>
					<?php echo ($disabled)?"":"<th>Batal</th>"; ?>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</fieldset>

<div class="form-actions">
	<?php
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'cekObat();', 'onKeypress'=>'cekObat();','disabled'=>$disabled));
	
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
							$this->createUrl($this->module->id.'/Index'), 
							array('class'=>'btn btn-danger',
								'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
	<?php
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')", 'disabled'=>$disabled2));
			echo "&nbsp;";
	?>
	<?php
		$content = $this->renderPartial('farmasiApotek.views.pemakaianObat.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
