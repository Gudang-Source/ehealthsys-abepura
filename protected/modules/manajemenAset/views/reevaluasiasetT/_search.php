<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'mareevaluasiaset-t-search',
	'type'=>'horizontal',
)); ?>


<table width="100%">
    <tr>
        <td>
			<?php echo CHtml::hiddenField('barang_id'); ?>
			<?php echo CHtml::hiddenField('barang_kode'); ?>
			<label class="control-label" for="namaObat">Nama Aset</label>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'barang_nama',
					'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
															   dataType: "json",
															   data: {
																   term: request.term,
															   },
															   success: function (data) {
																	   response(data);
															   }
														   })
														}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'select' => 'js:function( event, ui ) {
													   $(this).val( ui.item.label);
													   $("#barang_id").val(ui.item.barang_id);
													   $("#barang_kode").val(ui.item.barang_kode);
														return false;
													}',
					),
					'tombolDialog' => array('idDialog' => 'dialogAset', 'idTombol' => 'tombolDialogOa'),
					'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Asset",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
        </td>
        <td>
						<?php echo CHtml::hiddenField('kode_reg'); ?>
						<label class="control-label" for="namaObat">No. Registrasi</label>
						<div class="controls">
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'name' => 'noreg',
								'source' => 'js: function(request, response) {
																	   $.ajax({
																		   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
																		   dataType: "json",
																		   data: {
																			   term: request.term,
																		   },
																		   success: function (data) {
																				   response(data);
																		   }
																	   })
																	}',
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'select' => 'js:function( event, ui ) {
																   $(this).val( ui.item.label);
																   $("#kode_reg").val(ui.item.kode_reg);
																  
																	return false;
																}',
								),
								'tombolDialog' => array('idDialog' => 'dialogNoreg', 'idTombol' => 'tombolDialogOa'),
								'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Berdasarkan No. Registrasi",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
							));
							?>
        </td>
        <td>
	            <?php echo $form->dropDownListRow($model, 'jenis_aset', CHtml::listData(BarangV::model()->findAll(), 'barang_type', 'barang_type'), array('empty'=>'-- Pilih --', 'class' => 'span3')); ?>	
        </td>
    </tr>
</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
