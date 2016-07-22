<?php /*
$this->breadcrumbs=array(
	'Sabagiantubuh Ms',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<div class="row-fluid">
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
				$this->createUrl($this->id.'/admin'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bagian Tubuh',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'list'));?>
    </div>
</div>
<?php
 * 
 */
?>
<div class="white-container">
    <legend class="rim2">Anatomi <b>Tubuh Manusia</b></legend>
    <?php $this->renderPartial($this->path_view.'_tab',array()); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
</div>