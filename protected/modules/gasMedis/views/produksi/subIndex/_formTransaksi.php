<fieldset class="box" id="form-produksi">
    <legend class='rim'>Data Produksi</legend>
    <div class="span6">
        <div class="control-group ">
            <?php echo $form->labelEx($produksi,'tgl_produksi', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $produksi->tgl_produksi = (!empty($produksi->tgl_produksi) ? MyFormatter::formatDateTimeForUser($produksi->tgl_produksi) : MyFormatter::formatDateTimeForUser(date('Y-m-d')));
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$produksi,
                        'attribute'=>'tgl_produksi',
                        'mode'=>'date',

                        'options'=> array(
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                            'dateFormat'=>Params::DATE_FORMAT,
                        ),
                        'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup'=>"return $(this).focusNextInputField(event)"),
                    )); 
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($produksi, "no_produksi", array('class'=>'span3', 'readonly'=>true)); ?>
    </div>
    <div class="span6">
        <div class="control-group">
        <?php echo $form->labelEx($produksi, 'petugasgasmedis_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($produksi, 'petugasgasmedis_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$produksi,
                'attribute' => 'petugasgasmedis_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                        $(this).val( ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        $("#'.Chtml::activeId($produksi, 'petugasgasmedis_id') . '").val(ui.item.pegawai_id); 
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Ketikan Petugas Gas Medis',
                    'class'=>'petugasgasmedis_nama',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($produksi, 'petugasgasmedis_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas'),
            ));
            ?>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($produksi, 'mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($produksi, 'mengetahui_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$produksi,
                    'attribute' => 'mengetahui_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#'.Chtml::activeId($produksi, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan Petugas Gas Medis',
                        'class'=>'mengetahui_id',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($produksi, 'mengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
</fieldset>

<?php echo $this->renderPartial('subIndex/dialog/_pegawai', array("idDialog"=>"dialogPetugas", "idTab"=>"petugasgasmedis-grid"), true); ?>
<?php echo $this->renderPartial('subIndex/dialog/_pegawai', array("idDialog"=>"dialogMengetahui", "idTab"=>"mengetahui-grid"), true); ?>