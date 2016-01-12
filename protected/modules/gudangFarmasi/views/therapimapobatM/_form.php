<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gftherapimapobat-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#therapiobat_nama',
)); ?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group ">
				<?php echo CHtml::label('Kelas Terapi <span class="required">*</span>','', array('class'=>'control-label')) ?>
				<div class="controls">
				<?php 
					$therapiobat_nama = (isset($model->therapiobat->therapiobat_nama) ? $model->therapiobat->therapiobat_nama : "");
					echo CHtml::hiddenField('therapiobat_id',$model->therapiobat_id,array('readOnly'=>true));
					
					$this->widget('MyJuiAutoComplete',array(
								'name'=>'therapiobat_nama',
								'value'=>$therapiobat_nama,
								'source'=>'js: function(request, response) {
												   $.ajax({
													   url: "'.$this->createUrl('AutocompleteKelasTerapi').'",
													   dataType: "json",
													   data: {
														   term: request.term,
													   },
													   success: function (data) {
															   response(data);
													   }
												   })
												}',
								'options'=>array(
								'minLength' => 2,
								 'focus'=> 'js:function( event, ui ) {
									  $(this).val( "");
									  return false;
								 }',
								'select'=>'js:function( event, ui ) {
									 $(this).val(ui.item.obatalkes_nama);
									 $("#therapiobat_id").val(ui.item.therapiobat_id);
									 setTherapiMapObat(ui.item.therapiobat_id);
									 return false;
								 }',
								),
								'htmlOptions'=>array(
									'class'=>'span2',
									'onkeypress'=>"if(event.keyCode == 13 ){tambahTerapi();}",
									'placeholder'=>'Ketikan Kelas Terapi',
								),
								'tombolDialog'=>array('idDialog'=>'dialogTherapiObat'),
								'htmlOptions'=>array('placeholder'=>'Ketik Nama Terapi','rel'=>'tooltip','title'=>'Ketik Nama Terapi','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
				));?>   
				</div>
			</div>
        </div>        
	</div>
	<div class="block-tabel">
            <h6>Data Kelas <b>Terapi Obat</b></h6>
            <?php 
                $modObatAlkes=new GFObatalkesM('searchPilih');
                $modObatAlkes->unsetAttributes();  // clear any default values
                if(isset($_GET['GFObatalkesM'])){
                        $modObatAlkes->attributes=$_GET['GFObatalkesM'];
                }
                $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'gfobatalkes-m-grid',
                        'dataProvider'=>$modObatAlkes->searchPilih(),
//				'filter'=>$modObatAlkes,
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                        'columns'=>array(
                                array(
                                        'header'=>'Pilih',
                                        'type'=>'raw',
                                        'value'=>'CHtml::link("<i class=\'icon-form-check\'></i>","javascript:void(0);",array("onclick"=>"pilihObatAlkes(this);", "class"=>"btn-small", "title"=>"Klik untuk <br>memilih obat", "rel"=>"tooltip")).
                                                        CHtml::activeHiddenField($data,"obatalkes_id",array("readonly"=>true));
                                                        ',
                                ),
                                array(
                                        'header'=>'No.',
                                        'value' => '($this->grid->dataProvider->pagination) ? 
                                                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                        : ($row+1)',
                                        'type'=>'raw',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),

                                array(
                                        'name'=>'jenisobatalkes_id',
                                        'type'=>'raw',
                                        'value'=>'isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "-"',
                                        'filter'=>(isset($modObatAlkes->jenisobatalkes_id) ? CHtml::listData(JenisobatalkesM::model()->findAll(array('order'=>'jenisobatalkes_nama'),'jenisobatalkes_aktif = true'),'jenisobatalkes_id','jenisobatalkes_nama') : false ),
                                ),
                                'obatalkes_kode',
                                'obatalkes_nama'
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
            ?>
	</div>
	<div class="block-tabel">
            <h6>Tabel Kelas <b>Terapi Obat</b></h6>
            <table id="tablekelasterapi" class="items table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Obat</th>
                        <th>Kelas Terapi</th>
                        <th width="10%">Geser</th>
                        <th width="10%">Hapus</th>
                    </tr>
                <thead>
                <tbody>
                </tbody>
            </table>
	</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	
	<?php echo CHtml::link(Yii::t('mds', '{icon} Mapping Kelas Terapi Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
			$this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
	<?php
		$content = $this->renderPartial('gudangFarmasi.views.tips.tipsaddrow',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
	?>
</div>
<?php $this->endWidget(); ?>

	
<?php 
//========= Dialog buat cari Terapi Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTherapiObat',
    'options'=>array(
        'title'=>'Pilih Kelas Terapi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modTherapiObat = new GFTherapiObatM('searchDialog');
$modTherapiObat->unsetAttributes();
if(isset($_GET['GFTherapiObatM'])) {
    $modTherapiObat->attributes = $_GET['GFTherapiObatM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'therapiObat-m-grid',
	'dataProvider'=>$modTherapiObat->searchDialog(),
	'filter'=>$modTherapiObat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
					array(
						'header'=>'Pilih',
						'type'=>'raw',
						'value'=>'CHtml::Link("<i class=\'icon-form-check\'></i>","javascript:void(0);",
								array(  "class"=>"btn-small", 
										"onclick" => "$(\"#therapiobat_id\").val(\"$data->therapiobat_id\");
													  $(\"#therapiobat_nama\").val(\"$data->therapiobat_nama\");
													  setTherapiMapObat(\"$data->therapiobat_id\");
													  $(\"#dialogTherapiObat\").dialog(\"close\");
											",
										"title"=>"Klik untuk <br>memilih kelas terapi",
										"rel"=>"tooltip"));',
					),
					array(
					'header'=>'Kelas Terapi',
					'name'=>'therapiobat_nama',
					'type'=>'raw',
					),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model)); ?>