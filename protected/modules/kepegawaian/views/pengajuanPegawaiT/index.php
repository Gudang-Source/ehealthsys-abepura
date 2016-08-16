<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengpegawai-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'nopengajuan'),
));
$this->widget('bootstrap.widgets.BootAlert'); 
?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data Berhasil disimpan !");
}
?>
<?php echo $form->errorSummary(array($model,$modPengpegdet)); ?>
<div class="white-container">
    <legend class="rim2">Rencana Penerimaan <b>Pegawai</b></legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>    
    <div class="row-fluid">
        <div class='span4'>
            <div class="control-group">
                <?php echo $form->labelEx($model,'tglpengajuan',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php   
                        $model->tglpengajuan = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
                        
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpengajuan',
                                                'mode'=>'date',
                                                'options'=> array(
                                                     'dateFormat'=>Params::DATE_FORMAT,
                                                    'showOn' => false,
                                                    'maxDate' => 'd',
                                                    'yearRange'=> "-150:+0",
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                ),
                    )); ?>
                    <?php echo $form->error($model, 'tglpengajuan'); ?>
                </div>
            </div>
        </div>
        <div class='span4'>
            <div class="control-group">
                    <label class="control-label"><?php echo $form->labelEx($model,'nopengajuan'); ?></label>
                    <div class="controls">
                        <?php echo $form->textField($model,'nopengajuan_awal',array('readonly'=>true, 'class'=>'span2')); ?>
                        <?php echo $form->textField($model,'nopengajuan',array('readonly'=>(!$model->isNewRecord), 'style'=>'width:70px;', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
            </div>
        </div>
        <div class='span4'>
            <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>2, 'cols'=>30, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php 
        if (isset($modPengpegdets)){
            echo $form->errorSummary($modPengpegdets); 
        }
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Penerimaan Pegawai</b></h6>
        <table class="items table table-striped table-condensed" id="tblInputPengcal">
            <?php //if(empty($_GET['id'])) { ?> <thead>
                <tr>
                    <th>No. Urut</th>
                    <th>Jumlah Orang <font color="red">*</font></th>
                    <th>Untuk Keperluan</th>
                    <th>Keterangan</th>
                    <th>Disetujui <font color="red">*</font></th>
                    <th></th>
                </tr>
            </thead>

            <?php //} ?>
            <?php
            if(isset($_GET['i']))
                $id = $_GET['id'];
            else
                $id = 0;
            echo $this->renderPartial('_addPengcal',array('modPengpegdet'=>$modPengpegdet,'modPengpegdets'=>$modPengpegdets,'id'=>$id,),true); ?>

        </table>
        <table>
            <tr>
                <td>
                    <?php //if(!empty($_GET['id'])){ echo "Yang Mengajukan : ".$model->namayangmengajukan; } else{ ?>
                    <?php echo Chtml::label('Yang Mengajukan <font style = "color:red">*</font>','mengajukan_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model,'mengajukan_id'); ?>
                        <?php echo CHtml::activeTextField($model,'mengajukanNama',array('readonly'=>TRUE)); ?>
                        <?php //echo CHtml::hiddenField('ygmengajukan_id'); ?>
                            <div style="float:left;">
                                <?php
                                /*    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model,
                                        'attribute'=>'mengajukanNama',
                                        'sourceUrl'=>  Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/PegawaiUntukKP'),
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength'=>2,
                                            'select'=>'js:function( event, ui ) {
                                                    $("#KPPengajuanPegawaiT_mengajukan_id").val(ui.item.pegawai_id);
                                                        }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMengajukan'),
                                        'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 required hurufs-only','style'=>'float:left;')
                                    ));*/
                                ?>
                            </div>
                    </div>
                    <?php //} ?>
                </td>
                <td>
                     <?php //if(!empty($_GET['id'])){ echo "Yang Mengetahui : ".$model->namayangmengetahui; } else{ ?>
                     <?php echo Chtml::label('Mengetahui <font style = "color:red">*</font>','mengetahui', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model,'mengetahui_id');?>
                            <div style="float:left;">
                                <?php
                                    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model,
                                        'attribute'=>'mengetahui',
                                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('/ActionAutoComplete/PegawaiRuangan/') . '",
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
                                            'showAnim'=>'fold',
                                            'minLength'=>2,                                           
                                             'select' => 'js:function( event, ui ) {                                                 
                                                $("#'.CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.value);
                                                $("#'.CHtml::activeId($model, 'mengetahui') . '").val(ui.item.namaLengkap);                    
                                                return false;
                                            }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMengetahui'),
                                        'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 required','style'=>'float:left;')
                                    ));
                                ?>
                            </div>
                    </div>
                    <?php //} ?>
               </td>
               <td>                   
                     <?php echo Chtml::label('Menyetujui','menyetujui_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model,'menyetujui_id');?>
                            <div style="float:left;">
                                <?php
                                    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model,
                                        'attribute'=>'menyetujuiNama',
                                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('/ActionAutoComplete/PegawaiRuangan/') . '",
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
                                            'showAnim'=>'fold',
                                            'minLength'=>2,                                           
                                             'select' => 'js:function( event, ui ) {                                                 
                                                $("#'.CHtml::activeId($model, 'menyetujui_id') . '").val(ui.item.value);
                                                $("#'.CHtml::activeId($model, 'menyetujuiNama') . '").val(ui.item.namaLengkap);                    
                                                return false;
                                            }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMenyetujui'),
                                        'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
                                    ));
                                ?>
                            </div>
                    </div>
                    
               </td>
            </tr>
        </table>
    </div>     
    <div class="form-actions">
        <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiForm();', 'onkeypress'=>'validasiPelamar();','disabled'=>$disableSave)); //formSubmit(this,event)        
                    //  jika tanpa validasiPengajuan
                    /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                     * 
                     */
             ?>
        <?php if(!isset($_GET['frame'])){            
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index',array('modul_id'=>Yii::app()->session['modul_id'])) . '";}); return false;'));
        }
        ?>
         
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        ?>
        <?php
            $content = $this->renderPartial('tips/tipsPengajuanPegawai',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawaiYangMengajukan',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPegawai = new KPPegawaiM('search');
$modPegawai->unsetAttributes();
if(isset($_GET['KPPegawaiM'])){
    $modPegawai->attributes = $_GET['KPPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#KPPengajuanPegawaiT_mengajukan_id\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'mengajukanNama').'\").val(\"$data->gelardepan $data->nama_pegawai\");
                            $(\"#dialogPegawaiYangMengajukan\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'gelardepan',
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai',
        'jeniswaktukerja',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawaiYangMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPegawai = new KPPegawairuanganV('search');
$modPegawai->unsetAttributes();
if(isset($_GET['KPPegawairuanganV'])){
    $modPegawai->attributes = $_GET['KPPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengetahui-m-grid',
    'dataProvider'=>$modPegawai->searchPegawaiMenyetujui(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#KPPengajuanPegawaiT_mengetahui_id\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'mengetahui').'\").val(\"$data->gelardepan  $data->nama_pegawai\");
//                            submitPegawai();
                            $(\"#dialogPegawaiYangMengetahui\").dialog(\"close\");
                            return false;"
                ))'
        ),
       array(
           'header' => 'NIP',
           'name' => 'nomorindukpegawai',
           'value' => '$data->nomorindukpegawai',
           'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
       ),
        array(
           'header' => 'Nama',
           'name' => 'nama_pegawai',
           'value' => '$data->namaLengkap',
           'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
       ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                    $jabatan = KPJabatanM::model()->findByPk($data->jabatan_id);
                    
                    if (count($jabatan)>0){
                        echo $jabatan->jabatan_nama;
                    }else{echo "-";}
            },
            'filter' => Chtml::dropDownList('KPPegawairuanganV[jabatan_id]', $modPegawai->jabatan_id, Chtml::listData(KPJabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });'
    . ''
    . '}',
));
        
$this->endWidget();
?>

<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawaiYangMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPegawai = new KPPegawairuanganV('search');
$modPegawai->unsetAttributes();
if(isset($_GET['KPPegawairuanganV'])){
    $modPegawai->attributes = $_GET['KPPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengetahui-m-grid',
    'dataProvider'=>$modPegawai->searchPegawaiMenyetujui(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#KPPengajuanPegawaiT_menyetujui_id\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'menyetujuiNama').'\").val(\"$data->gelardepan  $data->nama_pegawai\");
//                            submitPegawai();
                            $(\"#dialogPegawaiYangMenyetujui\").dialog(\"close\");
                            return false;"
                ))'
        ),
       array(
           'header' => 'NIP',
           'name' => 'nomorindukpegawai',
           'value' => '$data->nomorindukpegawai',
           'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
       ),
        array(
           'header' => 'Nama',
           'name' => 'nama_pegawai',
           'value' => '$data->namaLengkap',
           'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
       ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                    $jabatan = KPJabatanM::model()->findByPk($data->jabatan_id);
                    
                    if (count($jabatan)>0){
                        echo $jabatan->jabatan_nama;
                    }else{echo "-";}
            },
            'filter' => Chtml::dropDownList('KPPegawairuanganV[jabatan_id]', $modPegawai->jabatan_id, Chtml::listData(KPJabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });'
    . ''
    . '}',
));
        
$this->endWidget();
?>
<?php
//$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print', array('id'=>$model->pengpegawai_id));
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=570px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('printCaraPrint',$js,  CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    
function addRowTindakan(obj)
{
    var trAddPengcal=new String(<?php echo CJSON::encode($this->renderPartial('_addPengcal',array('modPengpegdet'=>$modPengpegdet,'removeButton'=>true),true));?>);
    $(obj).parents('table').children('tbody').append(trAddPengcal.replace());
    <?php 
        $attributes = $modPengpegdet->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('KPPengpegawaidetT','$attribute');";
        }
    ?>

    renameInput('KPPengpegawaidetT','jmlorang');
    renameInput('KPPengpegawaidetT','untukkeperluan');
    renameInput('KPPengpegawaidetT','keterangan');
    renameInput('KPPengpegawaidetT','disetujui');

}

function batalTindakan(obj)
{

    myConfirm('Apakah anda yakin akan membatalkan tindakan?','Perhatian!',
    function(r){
        if(r){
           $(obj).parents('tr').detach();
            <?php 
                foreach($attributes as $i=>$attribute){
                    echo "renameInput('KPPengpegawaidetT','$attribute');";
                }
            ?>
            renameInput('KPPengpegawaidetT','jmlorang');
            renameInput('KPPengpegawaidetT','untukkeperluan');
            renameInput('KPPengpegawaidetT','keterangan');
            renameInput('KPPengpegawaidetT','disetujui');
        }
    }); 
}
function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputPengcal tr').length;
    var i = -1;
    $('#tblInputPengcal tr').each(function(){
        if($(this).has('input[name$="[nourut]"]').length){
            i++;
            $("#KPPengpegawaidetT_"+i+"_nourut").val((i+1));
            
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
//        $(this).find('input[name^="occupation["]').attr('name','occupation['+i+']');
//        $(this).find('input[name^="occupation["]').attr('id','occupation_'+i+'');
    });
    
//    if (attributeName == 'occupation'){
//        jQuery('#KPPengpegawaidetT_'+i+'_occupation').autocomplete({'showAnim':'fold','minLength':2,'select':function( event, ui ) {
////                console.log("#KPPengpegawaidetT_"+i+"_occupation");
//        $("#KPPengpegawaidetT_"+i+"_occupation_id").val(ui.item.occupation_id);
//        $("#KPPengpegawaidetT_"+i+"_occupation").val(ui.item.occupation_nama);
//        },'source':'/ehospitaljk/index.php?r=kepegawaian/ActionAutoCompleteKP/OccupationKP'});
//    }
}

//function setDialog(obj){
//    parent = $(obj).parents(".input-append").find("input").attr("id");
//    dialog = "#dialogOccupation";
//    $(dialog).attr("parent-dialogs",parent);
//    $(dialog).dialog("open");
//}

//function setTindakanAuto(params){
//    dialog = "#dialogOccupation";
//    parent = $(dialog).attr("parent-dialogs");
//    obj = $("#"+parent);
////    console.log(params);
//    $(obj).parents('tr').find('input[name$="[occupation_id]"]').val(params[0]);
//    $(obj).parents('tr').find('input[name$="[occupation]"]').val(params[1]);
//    $(dialog).dialog("close");
//    
//}

function cekNumerik(obj)
{
   
  number = obj.value;
  var list = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
  var status = true;
  for (i=0; i<=number.length-1; i++)
  {
     if (number[i] in list) cek = true;
     else cek = false;
     status = status && cek;
  }

  if (status === false)
  {
     myAlert("Input Harus angka");
     obj.value = '';
     return false;
  }
  else
  {
     return true;
  }
}
function validasiForm(event){
    if(requiredCheck($("form"))){
        if(validasiDetail()){
            $('#pengpegawai-t-form').submit();
        }else{
            return false;
        }
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
//    var required = $('.isReq').val('');
    
}

function validasiDetail(){
    var detailReq = document.getElementsByClassName("isDetailReq");
    var jml = detailReq.length;
    var adaKosong = false;
    for(i=0;i<jml;i++){
        if(detailReq[i].value == ""){
            myAlert('Silahkan lengkapi semua Data Pengajuan Pegawai!');
            adaKosong = true;
            break;
        }
    }
    if(adaKosong)
        return false;
    else
        return true;
}

function print(caraPrint)
{
    var pengajuanpegawai_id = '<?php echo isset($model->pengajuanpegawai_t_id) ? $model->pengajuanpegawai_t_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pengajuanpegawai_id='+pengajuanpegawai_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

   // $(document).ready(function () {
    <?php
   // if (isset($model->pengajuanpegawai_t_id)) {
        ?>
                  //  var params = [];
                  //  params = {  instalasi_id:<?php //echo Yii::app()->user->getState("instalasi_id"); ?>, 
                              //  modul_id:<?php //echo Yii::app()->session['modul_id'] ?>, 
                              //  judulnotifikasi: 'Rencana Penerimaan Pegawai', 
                              //  isinotifikasi: 
                              //  '<?php //echo $model->mengajukan->namaLengkap; ?> mengajukan Rencana Penerimaan Pegawai   \n\
                          //      sebanyak <?php //echo $model->total; ?> orang'}; 
                   // insert_notifikasi(params);
        <?php
   // }
    ?>
         //   });
</script>