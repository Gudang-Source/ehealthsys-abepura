<fieldset class="box" id="form-produksi">
    <legend class='rim'>Input Gas Medis</legend>
    <div class="control-group ">
        <?php echo CHtml::hiddenField('obatalkes_id'); ?>
        <label class="control-label" for="namaGas">Gas Medis</label>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'namaGasMedis',
                'source' => 'js: function(request, response) {
                   $.ajax({
                       url: "' . $this->createUrl('AutocompleteOA') . '",
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
                        $("#obatalkes_id").val(ui.item.obatalkes_id);
                        return false;
                    }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogGasMedis', 'idTombol' => 'tombolDialogOa'),
                'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes", 'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
    <div class="control-group ">
            <label class="control-label" for="qty">Jumlah</label>
            <div class="controls">
                <?php echo CHtml::textField('qty', '1', array('readonly' => false, 'onblur' => 'return false;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only', 'style'=>'text-align:right;')) ?>
            </div>
        </div>
    <div class="control-group ">
        <label class="control-label" for=""></label>
        <div class="controls">
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahGasMedis();return false;',
                                  'class'=>'btn btn-primary',
                                  'onkeypress'=>"tambahGasMedis(this);return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk menambahkan ke detail produksi gas medis",)); ?>
        </div>
    </div>
</fieldset>
<?php echo $this->renderPartial("subIndex/dialog/_obatalkes", array(), true); ?>