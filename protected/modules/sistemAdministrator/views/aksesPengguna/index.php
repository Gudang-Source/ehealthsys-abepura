<?php
$this->breadcrumbs=array(
	'saaksespengguna Ks',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title"> Akses Pemakai </div>  
        </div>
        <div class='panel-body'>
			<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_view',
			)); ?>

			<div class="row-fluid">
				<div class="form-actions">
					<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
					<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
							$this->createUrl($this->id.'/admin'), 
							array('class'=>'btn btn-danger',
								  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));  ?>
					<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Akses Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
					<?php $this->widget('UserTips',array('type'=>'list'));?>
				</div>
			</div>
		</div>
	</div>
</div>


