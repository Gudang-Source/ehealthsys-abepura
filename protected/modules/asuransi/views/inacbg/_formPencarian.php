<div class="span12">
	<div class="control-group">
		<?php echo CHtml::label('Barcode SEP','',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modSEP, 'barcode_sep',array('class'=>'span3','placeholder'=>'Scan Barcode SEP')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('No. SEP','',array('class'=>'control-label required')); ?>
		<div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
					'model'=>$modSEP,
					'attribute'=>'cari_sep',
					'value'=>$modSEP->nosep,
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteSEP').'",
									   dataType: "json",
									   data: {
										   nosep: request.term,
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'minLength' => 4,
							'focus'=> 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
						   'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setSEP(ui.item.sep_id);
								return false;
							}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogSEP'),
					'htmlOptions'=>array('placeholder'=>'Ketik No. SEP','rel'=>'tooltip','title'=>'Ketik No. SEP',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur'=>"if($(this).val()=='') setSEPBaru(); else setSEP('',this.value)",
						'class'=>''),
				)); 
            ?>
			<?php echo $form->error($modSEP,'nosep'); ?>                        
        </div>
	</div>
</div>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogSEP',
        'options'=>array(
            'title'=>'Pencarian Data SEP',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modDataSEP = new ARSepT('searchDialog');
    $modDataSEP->unsetAttributes();
    $format = new MyFormatter();
    if(isset($_GET['ARSepT'])) {
        $modDataSEP->attributes = $_GET['ARSepT'];
        $modDataSEP->nosep = $_GET['ARSepT']['nosep'];       
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasien-m-grid',
            'dataProvider'=>$modDataSEP->searchDialog(),
            'filter'=>$modDataSEP,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										$(\"#'.CHtml::activeId($modSEP,'cari_sep').'\").val(\"$data->nosep\");
										setSEP(\"$data->sep_id\");
										$(\"#dialogSEP\").dialog(\"close\");
									"))',
				),
				'nosep',
				array(
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglsep)'
				),
				array(
					'header'=>'No. Kartu',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'No. Pendaftaran',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'Tgl. Pendaftaran',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'No. Rekam Medik',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'Nama Pasien',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'NIK',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',
    ));
    $this->endWidget();
    ?>