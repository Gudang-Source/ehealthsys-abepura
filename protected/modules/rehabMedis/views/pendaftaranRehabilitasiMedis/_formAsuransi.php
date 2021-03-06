<div class="control-group">
        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nopeserta')." <span class='required'>*</span>", 'nopeserta', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'nopeserta',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransi').'",
                                                   dataType: "json",
                                                   data: {
                                                       nopeserta: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
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
                                            $(this).val(ui.item.value);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
											setAsuransiLama();
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Peserta','rel'=>'tooltip','title'=>'Ketik No. Peserta',
                                    'onkeyup'=>"setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>'numbers-only'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nopeserta'); ?>                        
             
        </div>
</div>
<?php echo $form->hiddenField($modAsuransiPasien,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
<div class="control-group">
        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nokartuasuransi')." <span class='required'>*</span>", 'nokartuasuransi', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'nokartuasuransi',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteAsuransiKartu').'",
                                                   dataType: "json",
                                                   data: {
                                                       nokartuasuransi: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
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
                                            $(this).val(ui.item.value);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'").val(ui.item.nokartuasuransi);
											$("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
											setAsuransiLama();
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogAsuransi','jsFunction'=>'cekAsuransi()'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Kartu Asuransi','rel'=>'tooltip','title'=>'Ketik No. Peserta',
                                    'onkeyup'=>"; return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                    'class'=>'numbers-only'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nokartuasuransi'); ?>                        
      </div>
</div>
<?php echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(RMPendaftaranT::model()->getKelasPelayanan(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group ">
    <div class="controls">
         <?php echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeyup'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?><label> Telah Dikonfirmasi</label>
        <?php echo $form->error($modAsuransiPasien, 'status_konfirmasi'); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo $form->labelEx($modAsuransiPasien,'tgl_konfirmasi', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'tgl_konfirmasi',
                                'mode'=>'datetime',
                                'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
    </div>
</div>