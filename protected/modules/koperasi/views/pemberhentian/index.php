<div class="white-container">
<style>
	.num {
		text-align: right;
	}
	.input-group-addon{
		cursor: pointer;	
	}
</style>

<?php
/* @var $this PemberhentianController */

$this->breadcrumbs=array(
	'Pemberhentian',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pemberhentian-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2">Permintaan Pemberhentian Anggota</legend>

<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body">
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Anggota </span></legend>
				<div class="row-fluid">
					<?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'anggota'=>$anggota, 'berhenti'=>$berhenti)); ?>
                                </div>
                        </fieldset>
				
			
                         <fieldset class="box" id="form-detail">
				<legend class="rim"><span class='judul'>Detail </span></legend>
				<div class="row-fluid">
                                        <?php echo $this->renderPartial('subview/_detail', array('form'=>$form, 'anggota'=>$anggota, 'berhenti'=>$berhenti)); ?>
                                </div>
			</fieldset>
                       
                        <fieldset class="box" id="form-detail">
				<legend class="rim"><span class='judul'>Permintaan Pemberhentian </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_berhenti', array('form'=>$form, 'berhenti'=>$berhenti)); ?>
                                </div>
                        </fieldset>
			<?php echo $this->renderPartial('subview/_js', array()); ?>
			<?php //echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
                         <?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
			<!-- submit/batal -->
		</div>
		<div class="panel-footer">
		<?php /* $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Simpan',
			'visible'=>$berhenti->isNewRecord,
			'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false;',),
		));*/ ?>
                    <?php //if ($berhenti->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
		<?php //echo $berhenti->isNewRecord?null:CHtml::link('Print', $this->createUrl('print',array('id'=>$berhenti->pemintaanberhenti_id)),array('class' => 'btn btn-green')); ?>
		<?php //echo CHtml::link('Ulang', $this->createUrl('index'),array('class' => 'btn btn-default')); ?>
                    
                     <?php
                                        if ($berhenti->isNewRecord) {
                                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                                            }else{
                                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
                                            }
                                    ?>
                                   <?php
                                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'));
                                    ?>
                                    <?php
                                            if(isset($_GET['sukses'])){
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), $this->createUrl('print',array('id'=>$berhenti->pemintaanberhenti_id)), array('target'=>'_blank','class' => 'btn btn-info','disabled'=>false));                                                   
                                            }else{
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '', array('target'=>'_blank','class' => 'btn btn-info','disabled'=>true));                                                    
                                            }
                                    ?>

                                    <?php
                                        $tips = array(
                                            '0' => 'autocomplete-search',
                                            '1' => 'tanggal',
                                            '2' => 'simpan',
                                            '3' => 'ulang',
                                            '4' => 'print',
                                            '5' => 'status_print'
                                        );
                                        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                                    ?>
                    
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>


<?php if(!empty($_GET['NoAnggota'])){
	echo '<script type="text/javascript">'
   , 'loadAnggotaAjax("'.$_GET['NoAnggota'].'");'
   , '</script>'
;}
 ?>

</div>