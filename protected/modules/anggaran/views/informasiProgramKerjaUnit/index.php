<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'action'=>Yii::app()->createUrl($this->route),
            'id'=>'infoprogramkerjaunit-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'noren_penerimaan'),
                    'method'=>'get',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));
    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#infoprogramkerjaunit-form').submit(function(){
            $.fn.yiiGridView.update('infoprogramkerjaunit-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");?>
<div class="white-container">
<legend class="rim2">Informasi <b>Program Kerja Unit</b></legend>
<?php 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
}

$this->widget('bootstrap.widgets.BootAlert'); 
?>
    <div class="block-tabel">
        <h6>Tabel <b>Program Kerja Unit</b></h6>
        <div class="table-responsive">
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'infoprogramkerjaunit-grid',
                'dataProvider'=>$model->search(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
							array(
								'header'=>'No.',
								'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
								'type'=>'raw',
								'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
							),
							array(
								'name'=>'Periode',
								'type'=>'raw',
								'value'=>'$data->deskripsiperiode',
								'htmlOptions'=>array('style'=>'width:180px')
							),
							array(
								'name'=>'Unit',
								'type'=>'raw',
								'value'=>'$data->namaunitkerja',
								'htmlOptions'=>array('style'=>'width:100px')
							),
							array(
								'name'=>'Kode Program',
								'type'=>'raw',
								'value'=>'$data->programkerja_kode',
								'htmlOptions'=>array('style'=>'width:100px')
							),
							array(
								'name'=>'Kode Sub Program',
								'type'=>'raw',
								'value'=>'$data->subprogramkerja_kode',
								'htmlOptions'=>array('style'=>'width:100px')
							),
							array(
								'name'=>'Kode Kegiatan',
								'type'=>'raw',
								'value'=>'$data->kegiatanprogram_kode',
								'htmlOptions'=>array('style'=>'width:100px')
							),
							array(
								'name'=>'Kode Sub Kegiatan',
								'type'=>'raw',
								'value'=>'$data->subkegiatanprogram_kode',
								'htmlOptions'=>array('style'=>'width:100px')
							),
							array(
								'name'=>'Program Kerja',
								'type'=>'raw',
								'value'=>'$data->programkerja_nama',
							),
                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
        </div>
    </div>
	<fieldset class="box">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
        <div class="row-fluid">
			<div class="span4">
				<div class="control-group ">
				<?php echo $form->labelEx($model,'Periode Anggaran', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'periodeAnggaran();')); ?>
					</div>
				</div>
			</div>
                        <div class="span4">
                               <div class="control-group ">
				<?php echo $form->labelEx($model,'Unit Kerja', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAll(), 'unitkerja_id', 'namaunitkerja'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'periodeAnggaran();')); ?>
					</div>
				</div> 
                        </div>
			<div class="span4">
				<div class="control-group ">
				<?php echo $form->labelEx($model,'Program Kerja', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'programkerja_nama',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
					</div>
				</div>
			</div>
		</div>
    </fieldset>
      
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang pencarian ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
        <?php  
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	

    </div>	
	
<?php
$this->endWidget();
?>
</div>
