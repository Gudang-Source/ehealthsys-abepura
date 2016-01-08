
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjkasuspenyakitdiagnosa-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#diagnosa',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
                <?php
                    if (isset($modDetails)) {
                        echo $form->errorSummary($modDetails);
                    } else {
                        echo $form->errorSummary($model);
                    }
                ?>
                <?php
                    if (isset($_GET['id'])){
                        $diagnosa_id = $_GET['id'];
                        $data = DiagnosaM::model()->findByPK($diagnosa_id);
                    } else {
                        $diagnosa_id = null;
                        $data = null;
                    }
                    // if (isset($_GET['id'])) {
                    //     $diagnosa_id = $_GET['id'];
                    //     $data = DiagnosaM::model()->findByPK($diagnosa_id);
                    //     $edit = true;
                    // } else {
                    //     $edit = false;
                    // }
                ?>
        
                <?php echo CHtml::label('Diagnosa','',array('class'=>'control-label required')); ?>
                <div class="controls">
                                <?php echo CHtml::hiddenField('diagnosa_id',$diagnosa_id,array('readonly'=>true)) ?>
                                <?php $this->widget('MyJuiAutoComplete', array(
                                                       'name'=>'diagnosa',
                                                       'value'=>(isset($_GET['id']) ? $data->diagnosa_nama : null),
                                                        'source'=>'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/Diagnosa').'",
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
                                                                   'minLength' => 2,
                                                                   'focus'=> 'js:function( event, ui )
                                                                       {
                                                                        $(this).val(ui.item.label);
                                                                        return false;
                                                                        }',
                                                                   'select'=>'js:function( event, ui ) {
                                                                       $(\'#diagnosa_id\').val(ui.item.value);
                                                                       $(\'#diagnosa\').val(ui.item.label);
                                                                        return false;
                                                                    }',
                                                        ),
                                                        'htmlOptions'=>array(
                                                            //'readonly'=>$edit,
                                                            'placeholder'=>'Diagnosa',
                                                            'size'=>13,
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                        ),
                                                        'tombolDialog'=>array('idDialog'=>'dialogDiagnosa'.(isset($edit) ? $edit : ""),),
                                                )); ?>
                </div>
                <?php echo CHtml::label('Obat Alkes','',array('class'=>'control-label')); ?>
                <div class="controls">
                                <?php echo CHtml::hiddenField('obatalkes_id','',array('readonly'=>true)) ?>
                                <?php $this->widget('MyJuiAutoComplete', array(
                                                       'name'=>'obatalkes', 
                                                        'source'=>'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/ObatAlkes').'",
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
                                                                   'minLength' => 2,
                                                                   'focus'=> 'js:function( event, ui )
                                                                       {
                                                                        $(this).val(ui.item.label);
                                                                        return false;
                                                                        }',
                                                                   'select'=>'js:function( event, ui ) {
                                                                       $(\'#obatalkes_id\').val(ui.item.value);
                                                                       $(\'#obatalkes\').val("");
                                                                       submitDiagnosaobat();
                                                                        return false;
                                                                    }',
                                                        ),
                                                        'htmlOptions'=>array(
                                                            'readonly'=>false,
                                                            'placeholder'=>'Obat Alkes',
                                                            'size'=>13,
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                        ),
                                                        'tombolDialog'=>array('idDialog'=>'dialogObatalkes'),
                                                )); ?>
                </div>
        <table id="tabelDiagnosaobat" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Kode Diagnosa</th>
                    <th>Diagnosa</th>
                    <th>Obat Alkes</th>
                    <th><?php if (isset($_GET['id'])) {$status = 'Hapus';} else {$status = 'Batal';} echo $status ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $modDiagnosaobat = DiagnosaobatM::model()->findAllByAttributes(array('diagnosa_id'=>$diagnosa_id));
                    foreach ($modDiagnosaobat as $value)
                    {
                        $hapus = Yii::app()->createUrl('farmasiApotek/diagnosaobatM/Delete',array('id'=>"$value->diagnosa_id",'obatalkes'=>"$value->obatalkes_id"));
                        $tr = '<tr>';
                        $tr .= '<td>' .$value->diagnosa->diagnosa_kode. '</td>';
                        $tr .= '<td>' .$value->diagnosa->diagnosa_nama .'</td>';
                        $tr .= '<td>' .$value->obatalkes->obatalkes_nama.'&nbsp;'.'</td>';
                        $tr .= '<td>'.CHtml::link("<i class='icon-form-sampah'></i>",$hapus).'</td>';
                        $tr .= '</tr>';
                        echo $tr;
                    }
                ?>
                <?php
                    if (count($modDetails) > 0)
                    {
                        foreach ($modDetails as $i=>$row) {
                            $moddiagnosa = DiagnosaM::model()->findByPK($row->diagnosa_id);
                            $modobatalkes = ObatalkesM::model()->findByPK($row->obatalkes_id);
                                $tr = "<tr>";
                                $tr .= "<td>"
                                            .$moddiagnosa->diagnosa_kode
                                            .CHtml::activehiddenField($model,'[]diagnosa_id',array('readonly'=>true,'value'=>$row->diagnosa_id,'class'=>'diagnosa'))
                                            .CHtml::activehiddenField($model,'[]obatalkes_id',array('readonly'=>true,'value'=>$row->obatalkes_id))
                                            ."</td>";
                                $tr .= "<td>".$moddiagnosa->diagnosa_nama."</td>";
                                $tr .= "<td>".$modobatalkes->obatalkes_nama."</td>";
                                $tr .= "<td>".CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'remove(this);'))."</td>";
                                $tr .= "</tr>";
                                echo $tr;
                        }
                    }
                ?>
            </tbody>
        </table>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/diagnosaobatM/admin'), 
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Diagnosa Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('diagnosaobatM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('farmasiApotek.views.tips.tipsaddedit3',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>
<?php $this->endWidget(); ?>
        
<!-- ============================== Widget Dialog Diagnosa ==================================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogDiagnosa',
        'options'=>array(
            'title'=>'Pencarian Diagnosa',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modDiagnosa = new DiagnosaM;
    $modDiagnosa->unsetAttributes();
    if (isset($_GET['DiagnosaM'])) {
        $modDiagnosa->attributes = $_GET['DiagnosaM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'diagnosa-grid',
        'dataProvider'=>$modDiagnosa->search(),
        'filter'=>$modDiagnosa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#diagnosa_id\").val($data->diagnosa_id);
                                                              \$(\"#diagnosa\").val(\"$data->diagnosa_nama\");
                                                              \$(\"#dialogDiagnosa\").dialog(\"close\");"
                                ))',
            ),
            array(
                'header'=>'Kode Diagnosa',
                'value'=>'$data->diagnosa_kode',
            ),
            array(
                'header'=>'Diagnosa',
                'value'=>'$data->diagnosa_nama',
            ),
            array(
                'header'=>'Nama Lainnya',
                'value'=>'$data->diagnosa_namalainnya',
            ),
            array(
                'header'=>'imunisasi',
                'type'=>'raw',
                'value'=>'($data->diagnosa_imunisasi==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!-- ============================== endWidget Dialog Diagnosa ==================================== -->

<!-- ============================== Widget Dialog ObatAlkes ==================================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogObatalkes',
        'options'=>array(
            'title'=>'Pencarian Obat Alkes',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modObatalkes = new ObatalkesM;
    $modObatalkes->unsetAttributes();
    if (isset($_GET['DiagnosaM'])) {
        $modObatalkes->attributes = $_GET['DiagnosaM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'diagnosa-grid',
        'dataProvider'=>$modObatalkes->searchObatFarmasi(),
        'filter'=>$modObatalkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectObatalkes",
                                        "onClick" => "\$(\"#obatalkes_id\").val($data->obatalkes_id);
                                                              \$(\"#obatalkes\").val(\"\");
                                                              \$(\"#dialogObatalkes\").dialog(\"close\");
                                                              submitDiagnosaobat();"
                                ))',
            ),
            array(
                'header'=>'Kode Obat',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Jenis',
                'value'=>'(isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
            ),
            array(
                'header'=>'Kategori',
                'value'=>'$data->obatalkes_kategori',
            ),
            array(
                'header'=>'Golongan',
                'value'=>'$data->obatalkes_golongan',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!-- ============================== endWidget Dialog ObatAlkes ==================================== -->
<?php
$urlGetDiagnosaobat = $this->createUrl('Kasuspenyakitdiagnosa');
$jscript = <<< JS
function submitDiagnosaobat()
{
    diagnosa_id = $('#diagnosa_id').val();
    obatalkes_id = $('#obatalkes_id').val();

    if(diagnosa_id == ''){
        myAlert('Silahkan Pilih Diagnosa Terlebih Dahulu');
    }else{
        $.post("${urlGetDiagnosaobat}", {diagnosa_id:diagnosa_id, obatalkes_id:obatalkes_id,},
        function(data){
            $('#tabelDiagnosaobat tbody').append(data.tr);
            renameInput();
        }, "json");
    }   
}

function renameInput(){
    nourut = 0;
    $('.diagnosa').each(function(){
        $(this).parents('tr').find('[name*="DiagnosaobatM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('DiagnosaobatM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','FADiagnosaobatM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}

JS;

Yii::app()->clientScript->registerScript('diagnosaobat',$jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
  function hapusBaris(obj)
    {
      $(obj).parent().parent('tr').detach();
    }
</script>