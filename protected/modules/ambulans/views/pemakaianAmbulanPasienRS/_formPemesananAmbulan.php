<div class = "span4">
    <div class="control-group ">
        <?php echo CHtml::activeLabel($modPemakaian, 'norekammedis', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian,'norekammedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'noidentitas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($modPemakaian,'namapasien',array('class'=>'span3 reqPasien', 'onchange'=>'clearDataPasien();' ,'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

    <?php echo CHtml::activeHiddenField($modPemakaian,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pesanambulans_t',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

    <?php echo $form->textFieldRow($modPemakaian,'tempattujuan',array('class'=>'span3 reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <?php echo $form->textAreaRow($modPemakaian,'alamattujuan',array('class'=>'span3 reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="control-group ">
		<?php echo CHtml::activeLabel($modPemakaian, 'longitude', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($modPemakaian,'longitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
					array(
//						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
						  'class'=>'btn btn-primary',
						  'rel'=>"tooltip",
						  'id'=>'yw1',
						  'title'=>"Klik untuk mencari Longitude & Latitude",)); ?>
		</div>
	</div>
    <?php echo $form->textFieldRow($modPemakaian,'latitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($modPemakaian,'kelurahan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPemakaian,'rt_rw', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian,'rt',array('class'=>'span1 numbers-only reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?> /
           <?php echo $form->textField($modPemakaian,'rw',array('class'=>'span1 numbers-only reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?>
            <?php echo $form->error($modPemakaian, 'rt_rw'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'nomobile',array('class'=>'span3 numbers-only reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($modPemakaian,'notelepon',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
</div>
<div class = "span4">
    <div class="control-group ">
<?php echo $form->labelEx($modPemakaian,'supir_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'supir_nama',
                                'value'=>$modPemakaian->supir_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteNamaSupir').'",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_supir_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogSupir'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Supir','rel'=>'tooltip','title'=>'"Ketik Nama Supir" / klik icon untuk mencari data supir', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                               'onblur'=> 'if(this.value===""){ $("#'.CHtml::activeId($modPemakaian, 'supir_id').'").val(""); }'
                                    ),
                            )); 
            ?>
            <?php echo $form->error($modPemakaian,'supir_id'); ?>                        
            <?php echo $form->hiddenField($modPemakaian,'supir_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div> 
    <div class="control-group ">
<?php echo $form->labelEx($modPemakaian,'pelaksana_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'pelaksana_nama',
                                'value'=>$modPemakaian->pelaksana_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteNamaSupir').'",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_pelaksana_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPelaksana'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Pelaksana','rel'=>'tooltip','title'=>'"Ketik Nama Pelaksana" / klik icon untuk mencari data pelaksana', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                     'onblur'=>'if(this.value === ""){ $("#'.CHtml::activeId($modPemakaian, 'pelaksana_id').'").val(""); }'   
                                    ),
                            )); 
            ?>
            <?php echo $form->error($modPemakaian,'pelaksana_id'); ?>                        
            <?php echo $form->hiddenField($modPemakaian,'pelaksana_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group ">
<?php echo $form->labelEx($modPemakaian,'paramedis1_id', array('class'=>'control-label')) ?>
        <div class="controls">
             <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'paramedis1_nama',
                                'value'=>$modPemakaian->paramedis1_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteParamedis').'",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#AMPemakaianambulansT_paramedis1_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogParamedis1'),
                                'htmlOptions'=>array('placeholder'=>'Ketik nama paramedis 1','rel'=>'tooltip','title'=>'Ketik nama paramedis / klik icon untuk mencari data paramedis',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                    'onblur'=>'if(this.value===""){ $("#'.CHtml::activeId($modPemakaian, 'paramedis1_id').'").val(""); }',
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian,'paramedis1_id'); ?>                        
            <?php echo $form->hiddenField($modPemakaian,'paramedis1_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group ">
<?php echo $form->labelEx($modPemakaian,'paramedis2_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'paramedis2_nama',
                                'value'=>$modPemakaian->paramedis2_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteParamedis').'",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_paramedis2_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogParamedis2'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Paramedis 2','rel'=>'tooltip','title'=>'"Ketik Nama Paramedis 2", untuk mencari nama paramedis 2', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    'onblur'=>'if(this.value === "") { $("#'.CHtml::activeId($modPemakaian, 'paramedis2_id').'").val(""); } '
                                    ),
                            )); 
            ?>
            <?php echo $form->error($modPemakaian,'paramedis2_id'); ?>                        
            <?php echo $form->hiddenField($modPemakaian,'paramedis2_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Pemakaian Ambulans', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans); ?>
            <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$modPemakaian,
                    'attribute'=>'tglpemakaianambulans',
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        //'minDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Kembali Ambulans', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$modPemakaian,
                    'attribute'=>'tglkembaliambulans',
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        'minDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>false,'class'=>'dtPicker2-5'),
                )); 
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian,'namapj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>                
</div>
<div class = "span4">
    <?php echo $form->dropDownListRow($modPemakaian,'hubunganpj', LookupM::getItems('hubungankeluarga'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
    <?php echo $form->textAreaRow($modPemakaian,'alamatpj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($modPemakaian,'untukkeperluan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group ">
        <?php echo CHtml::activeLabel($modPemakaian, 'Ruangan <span style=color:red>*</span>', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::dropDownList('instalasi', $instalasi, CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                                            array('empty' =>'-- Instalasi --',
                                                'ajax'=>array('type'=>'POST',
                                                'url'=>  CController::createUrl('dynamicRuangan'),
                                                'update'=>'#AMPemakaianambulansT_ruangan_id',),'class'=>'span2')); ?>
            <?php echo CHtml::activeDropDownList($modPemakaian, 'ruangan_id',  CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi),'ruangan_id','ruangan_nama'),array('empty' =>'-- Ruangan --','class'=>'span2')); ?>
        </div>
    </div>
    <fieldset class="box2">
        <legend class="rim">Kendaraan</legend>
        <div class="control-group ">
            <?php echo $form->labelEx($modPemakaian, 'mobilambulans_id', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPemakaian,
                                'attribute'=>'mobilambulans_nama',
                                'value'=>$modPemakaian->mobilambulans_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKendaraan').'",
                                                   dataType: "json",
                                                   data: {
                                                       mobilambulans_kode: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 1,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#AMPemakaianambulansT_mobilambulans_id").val(ui.item.mobilambulans_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKendaraan'),
                                'htmlOptions'=>array('placeholder'=>'Ketik kode kendaraan','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'Ketik kode kendaraan / klik icon untuk mencari data kendaraan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                    'onblur'=>'if(this.value === "") { $("#'.CHtml::activeId($modPemakaian,'mobilambulans_id').'").val("") }',
                                    ),
                            ));
            
            ?>
            <?php echo $form->error($modPemakaian,'mobilambulans_id'); ?>                        
            <?php echo $form->hiddenField($modPemakaian,'mobilambulans_id',array('readonly'=>true,'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            </div>
      
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPemakaian, 'kmawal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPemakaian,'kmawal',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($modPemakaian, 'kmawal'); ?> s/d <span style="font-size:11px;"><?php echo $modPemakaian->getAttributeLabel('kmakhir'); ?></span>
                <?php echo $form->textField($modPemakaian,'kmakhir',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($modPemakaian, 'kmakhir'); ?>
            </div>
        </div>    
        <?php echo $form->textFieldRow($modPemakaian,'jmlbbmliter',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
    </fieldset>
</div>
<?php 
	$this->widget('ext.LocationPicker2.CoordinatePicker', array(
		'model' => $modPemakaian,
		'latitudeAttribute' => 'latitude',
		'longitudeAttribute' => 'longitude',
		//optional settings
		'editZoom' => 12,
		'pickZoom' => 7,
		'defaultLatitude' => $latitude,
		'defaultLongitude' => $longitude,
	));
?>