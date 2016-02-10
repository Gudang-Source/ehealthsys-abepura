 <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satarif-tindakan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#kategoritindakan',
)); ?>
<fieldset class="box">
    <legend class='rim'>Pilih Tindakan dan Tarif</legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row-fluid" id="form">
        <div class="span4">
            <?php echo $form->dropDownListRow($model,'perdatarif_id',  CHtml::listData($model->PerdaTarifItems, 'perdatarif_id', 'perdanama_sk'),array('class'=>'span3 perdatarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()')); ?>
            <div class="control-group">
                <label class="control-label" >Jenis Tarif</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jenistarif_id',  CHtml::listData($model->JenisTarifItems, 'jenistarif_id', 'jenistarif_nama'),array('class'=>'span3 jenistarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" >Kelas Pelayanan</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'kelaspelayanan_id', CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3 kelaspelayanan_id','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()')); ?>
                </div>
            </div>
            
        </div>
        <div class="span4">
            <div class="control-group">
                <label class="control-label" >Nama Tindakan</label>
                <div class="controls">
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                        'name'=>'daftartindakan',
                                        'value'=>isset($model->daftartindakan->daftartindakan_nama)?$model->daftartindakan->daftartindakan_nama:'',
                                        'source'=>'js: function(request, response) {
                                                       $.ajax({
                                                           url: "'.$this->createUrl('AutocompleteDaftarTindakan').'",
                                                           dataType: "json",
                                                           data: {
                                                               daftartindakan: request.term,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                                   setTarifDet();
                                                           }
                                                       })
                                                    }',
                                         'options'=>array(
                                               'minLength' => 4,
                                                'focus'=> 'js:function( event, ui ) {
                                                     $(this).val("");
                                                     return false;
                                                 }',
                                               'select'=>'js:function( event, ui ) {
                                                    $(this).val( ui.item.value);
                                                    $(".daftartindakan_id").val(ui.item.daftartindakan_id);
                                                    return false;
                                                }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogdaftartindakan'),
                                        'htmlOptions'=>array('placeholder'=>'Ketik Nama Tindakan','rel'=>'tooltip','title'=>'Ketik Nama Tindakan Untuk Mencari Daftar Tindakan',
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                    )); 
                    ?>
                    <?php echo $form->error($model,'daftartindakan_id'); ?>                        
                    <?php echo $form->hiddenField($model,'daftartindakan_id',array('class'=>'daftartindakan_id')); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'komponentarif_id',  CHtml::listData($model->getKomponenTarif(false), 'komponentarif_id', 'komponentarif_nama'),array('class'=>'span3 komponentarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
			<?php // echo $form->hiddenField($model,'komponentarif_id',array('value'=>  Params::KOMPONENTARIF_ID_TOTAL)); ?>
            <div class="control-group">
                <label class="control-label" >Harga Tindakan</label>
                <div class="controls">
                    <?php echo CHtml::textfield('harga_tariftindakan','',array('value'=>0,'class'=>'span 2 integer harga_tariftindakan', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    <?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeypress'=>"tambahTarifTindakan()",'onclick'=>"tambahTarifTindakan()",'id'=>'row1-plus')); ?>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <?php echo $form->labelex($model,'Cyto',array('class'=>"control-label required")) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'persencyto_tind',array('value'=>0,'class'=>'span1 persencyto_tind', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelex($model,'Diskon',array('class'=>"control-label required")) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'persendiskon_tind',array('value'=>0,'class'=>'span1 persendiskon_tind', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                </div>
            </div>


            <div class="control-group">
                <?php echo $form->labelex($model,'Diskon',array('class'=>"control-label required")) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'hargadiskon_tind',array('value'=>0,'class'=>'span1 hargadiskon_tind', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Rupiah
                </div>
            </div>
        </div>
    </div>
</fieldset>
<div class="block-tabel" id="divDaftartindakan">
    <h6>Tabel <b>Tarif Tindakan</b></h6>
    <table class="items table table-striped table-bordered table-condensed" id="table-tariftindakan">
    <thead>
        <th>No.Urut</th>
        <th>Perda Tarif <span class="required">*</span></th>
        <th>Jenis Tarif <span class="required">*</span></th>
        <th>Kelas Pelayanan <span class="required">*</span></th>
        <th>Nama Tindakan <span class="required">*</span></th>
        <th>Komponen Tarif <span class="required">*</span></th>
        <th>Harga Tindakan <span class="required">*</span></th>
        <th>Diskon <span class="required">*</span></th>
        <th>Cyto <span class="required">*</span></th>
        <th>Batal</th>
    </thead>
        <tbody>
            <?php
                if(count($modDetails)>0){
                    foreach ($lists as $i => $detail) {
                        if ($detail->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL) continue;
                        echo $this->renderPartial('_rowDetail',array('model'=>$detail));
                    }  
                }
            ?>
        </tbody>
    </table>
</div>  
    <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
           <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    '', 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')).'&nbsp;'; ?>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tarif Tindakan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>    

<?php $this->endWidget(); ?>


<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogdaftartindakan',
        'options'=>array(
            'title'=>'Pencarian Daftar Tindakan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));
   
$modDaftarTindakan = new DaftartindakanM('search');
$modDaftarTindakan->unsetAttributes();
if(isset($_GET['DaftartindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['DaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftartindakan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$modDaftarTindakan->search(),
    'filter'=>$modDaftarTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                    array(
                                            "class"=>"btn-small",
                                            "id" => "selectbarang",
                                            "onClick" => "\$(\"#form .daftartindakan_id\").val($data->daftartindakan_id);
                                                                  \$(\"#form #daftartindakan\").val(\"$data->daftartindakan_nama\");
                                                                  setTarifDet();
                                                                  \$(\"#dialogdaftartindakan\").dialog(\"close\");"
                                                                    
                                     )
                     )',
                ),
                'daftartindakan_nama',
                array(
                    'header'=>'Kelompok Tindakan',
                    'name'=>'kelompoktindakan_nama',
                    'value'=>'isset($data->kelompoktindakan->kelompoktindakan_nama)?$data->kelompoktindakan->kelompoktindakan_nama:" - "',
                ),
                array(
                    'header'=>'Kategori Tindakan',
                    'name'=>'kategoritindakan_nama',
                    'value'=>'isset($data->kategoritindakan->kategoritindakan_nama)?$data->kategoritindakan->kategoritindakan_nama:" - "',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>

<script type="text/javascript">
    tr = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetail', array('model'=>$modDetails), true)); ?>);
    function tambahTarifTindakan(){
        daftartindakan = $('#form #daftartindakan').val();;
        daftartindakan_id = $('#form .daftartindakan_id').val();
        komponentarif_id = $('#form .komponentarif_id').val();
        kelaspelayanan_id = $('#form .kelaspelayanan_id').val();
        perdatarif_id = $('#form .perdatarif_id').val();
        jenistarif_id = $('#form .jenistarif_id').val();
        harga_tariftindakan = $('#form .harga_tariftindakan').val();
        persendiskon_tind = $('#form .persendiskon_tind').val();
        hargadiskon_tind = $('#form .hargadiskon_tind').val();
        persencyto_tind = $('#form .persencyto_tind').val();
        if(komponentarif_id==''){
            komponentarif_nama =  '';
        }else{
            komponentarif_nama =  $('#form .komponentarif_id option:selected').html();
        }
        if(kelaspelayanan_id==''){
            kelaspelayanan_nama =  '';
        }else{
            kelaspelayanan_nama =  $('#form .kelaspelayanan_id option:selected').html();
        }
        if(jenistarif_id==''){
            jenistarif_nama =  '';
        }else{
            jenistarif_nama =  $('#form .jenistarif_id option:selected').html();
        }
        if(perdatarif_id==''){
            perdanama_sk =  '';
        }else{
            perdanama_sk =  $('#form .perdatarif_id option:selected').html();
        }
        
        //validasi
        i=0;
        $('#table-tariftindakan tr').each(function(){
            current_id = $(this).find('.komponentarif_id').val();
            if(current_id==komponentarif_id){
                i++;
            }
        });

        if(i>0){
            myAlert('Tarif sudah ada di tabel!');
            return false;
        }

        $('#table-tariftindakan').children('tbody').append(tr.replace());
        renameInputRow($('#table-tariftindakan'));

        $('#table-tariftindakan tr:last').find('.daftartindakan_id').val(daftartindakan_id);
        $('#table-tariftindakan tr:last').find('.komponentarif_id').val(komponentarif_id);
        $('#table-tariftindakan tr:last').find('.perdatarif_id').val(perdatarif_id);
        $('#table-tariftindakan tr:last').find('.kelaspelayanan_id').val(kelaspelayanan_id);
        $('#table-tariftindakan tr:last').find('.jenistarif_id').val(jenistarif_id);

        $('#table-tariftindakan tr:last').find('.harga_tariftindakan').val(accounting.unformat(harga_tariftindakan));
        $('#table-tariftindakan tr:last').find('.persendiskon_tind').val(persendiskon_tind);
        $('#table-tariftindakan tr:last').find('.persencyto_tind').val(persencyto_tind);
        $('#table-tariftindakan tr:last').find('.hargadiskon_tind').val(hargadiskon_tind);

        $('#table-tariftindakan tr:last #daftartindakan_nama').html(daftartindakan);
        $('#table-tariftindakan tr:last #komponentarif_nama').html(komponentarif_nama);
        $('#table-tariftindakan tr:last #kelaspelayanan_nama').html(kelaspelayanan_nama);
        $('#table-tariftindakan tr:last #jenistarif_nama').html(jenistarif_nama);
        $('#table-tariftindakan tr:last #perdanama_sk').html(perdanama_sk);
        $('#table-tariftindakan tr:last #harga_tariftindakan').html(harga_tariftindakan);
        $('#table-tariftindakan tr:last #persendiskon_tind').html(persendiskon_tind);
        $('#table-tariftindakan tr:last #persencyto_tind').html(persencyto_tind);
    }

    function hapus(obj){
        tariftindakan_id = $(obj).parents('tr').find('.tariftindakan_id').val();

        if(tariftindakan_id==''){
            $(obj).parents('tr').detach();
            renameInputRow($('#table-tariftindakan'));
        }else{
            myConfirm("Apakah anda ingin menghapus data ini?","Perhatian!",function(r){
                if(r){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl("hapusDetailTarif") ?>',
                        data: {tariftindakan_id : tariftindakan_id},//
                        dataType: "json",
                        success:function(data){
                            if(data.status=1){
                                $(obj).parents('tr').detach();
                                renameInputRow($('#table-tariftindakan'));
                            }else{
                                myAlert('Tidak dapat dihapus!');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });
                }
            });

        }
    }

    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
        });
    }

    function setTarifDet(){
        isCreate = <?php echo $isCreate?"true":"false"; ?>;
        daftartindakan_id = $('#form .daftartindakan_id').val();
        kelaspelayanan_id = $('#form .kelaspelayanan_id').val();
        perdatarif_id = $('#form .perdatarif_id').val();
        jenistarif_id = $('#form .jenistarif_id').val();
        
        console.log(isCreate);

        
        if(daftartindakan_id!=''&&kelaspelayanan_id!=''&&perdatarif_id!=''&&jenistarif_id!=''){
            $("#table-tariftindakan").addClass("animation-loading");
            $('#table-tariftindakan > tbody').html("");
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl("setTarifDet") ?>',
                data: {perdatarif_id : perdatarif_id, jenistarif_id : jenistarif_id, kelaspelayanan_id : kelaspelayanan_id, daftartindakan_id : daftartindakan_id, isCreate: isCreate},//
                dataType: "json",
                success:function(data){
                    if (data.error == 1) {
                        myAlert("Tindakan sudah memiliki tarif");
                        $(".daftartindakan_id, #daftartindakan").val("");
                    } else {
                        $('#table-tariftindakan > tbody').append(data.form);
                        jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({"placement":"bottom"});
                        renameInputRow($("#table-tariftindakan"));
                    }
                    $("#table-tariftindakan").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
    }   
    
    $(document).ready(function() {
        renameInputRow($('#table-tariftindakan'));
    });


</script>