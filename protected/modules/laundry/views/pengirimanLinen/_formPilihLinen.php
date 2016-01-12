<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Kode Linen', 'kodeinventaris', array('class'=>'control-label')); ?>
			<div class="controls">
			<?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'kodelinen',
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteLinen').'",
									   dataType: "json",
									   data: {
										   kodelinen: request.term,
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'focus'=> 'js:function( event, ui ) {
								$(this).val("");
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								$(this).val(ui.item.value);
								$("#linen_id").val(ui.item.linen_id);
								$("#kodelinen").val(ui.item.kodelinen);
								$("#namalinen").val(ui.item.namalinen);
								return false;
							}',
					),
					'htmlOptions'=>array(
						'placeholder'=>'Ketikan Kode Linen',
						'onkeypress'=>'if(this.value === "") $("#linen_id").val("");',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'class'=>'span3',
					),
					'tombolDialog'=>array('idDialog'=>'dialogLinen'),
				)); 
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Nama Linen', 'namalinen', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('linen_id'); ?>
			<?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'namalinen',
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteLinen').'",
									   dataType: "json",
									   data: {
										   namalinen: request.term,
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'focus'=> 'js:function( event, ui ) {
								$(this).val("");
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								$(this).val(ui.item.value);
								$("#linen_id").val(ui.item.linen_id);
								$("#kodelinen").val(ui.item.kodelinen);
								$("#namalinen").val(ui.item.namalinen);
								return false;
							}',
					),
					'htmlOptions'=>array(
						'placeholder'=>'Ketikan Nama Linen',
						'onkeypress'=>'if(this.value === "") $("#linen_id").val("");',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'class'=>'span3',
					),
					'tombolDialog'=>array('idDialog'=>'dialogLinen'),
				)); 
				?>
			</div>
		</div>
	</div>	
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Keterangan','', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('keterangan','',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
						array('onclick'=>'tambahLinen();return false;',
							  'class'=>'btn btn-primary',
							  'onkeyup'=>"tambahLinen();",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk menambahkan resep",)); ?>
				</div> 
		</div>
	</div>
</div>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLinen',
    'options'=>array(
        'title'=>'Linen',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));
$modLinen = new LALinenM('searchDialog');
$modLinen->unsetAttributes();
if(isset($_GET['LALinenM'])){
    $modLinen->attributes = $_GET['LALinenM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modLinen->searchDialog(),
	'filter'=>$modLinen,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
						"id" => "selectObat",
						"onClick" => "
							$(\'#linen_id\').val($data->linen_id);
							$(\'#namalinen\').val(\'$data->namalinen\');
							$(\'#kodelinen\').val(\'$data->kodelinen\');
							$(\'#dialogLinen\').dialog(\'close\');
							tambahLinen();
							return false;"
					))',
		),
		'linen_id',
		'kodelinen',
		'namalinen',
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
