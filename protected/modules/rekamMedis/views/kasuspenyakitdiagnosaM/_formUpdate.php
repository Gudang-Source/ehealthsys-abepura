
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rikasuspenyakitdiagnosa-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

                <?php if (isset($modDetails)){
                    echo $form->errorSummary($modDetails);
                } else {
                    echo $form->errorSummary($model);
                } ?>
                    <?php
                        $instalasi_id = Yii::app()->user->instalasi_id;
                        $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
                        echo CHtml::hiddenField('instalasi_id',$instalasi_id);
                        echo $form->textFieldRow($model,'instalasi_nama',array('value'=>$modInstalasi->instalasi_nama,'readonly'=>true,'class'=>'span2'));
                    ?>
                    <?php
                        $ruanganid = Yii::app()->user->ruangan_id;
                        $modruangan = RuanganM::model()->findByPK($ruanganid);
                        echo CHtml::hiddenField('ruanganid',$ruanganid,array('readonly'=>true));
                        echo $form->textFieldRow($model,'ruangan_nama',array('value'=>$modruangan->ruangan_nama,'readonly'=>true,'class'=>'span2',));
                    ?>
                <div>
                        <?php echo CHtml::label('Kasus Penyakit','',array('class'=>'control-label required')); ?>
                        <div class="controls">
                                        <?php echo $form->hiddenField($model,'jeniskasuspenyakit_id', array('readonly'=>true)) ?>
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'kasuspenyakit', 
                                                                'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/JenisKasusPenyakit').'",
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
                                                                               $(\'#KasuspenyakitdiagnosaM_jeniskasuspenyakit_id\').val(ui.item.value);
                                                                               $(\'#kasuspenyakit\').val(ui.item.jeniskasuspenyakit_nama);
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Kasus Penyakit',
                                                                    'size'=>13,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogkasuspenyakit'),
                                                        )); ?>
                        </div>
                        <?php echo CHtml::label('Diagnosa','',array('class'=>'control-label required')); ?>
                        <div class="controls">
                                        <?php echo $form->hiddenField($model,'diagnosa_id', array('readonly'=>true)) ?>
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'diagnosa', 
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
                                                                               $(\'#KasuspenyakitdiagnosaM_diagnosa_id\').val(ui.item.value);
                                                                               $(\'#kasuspenyakit\').val("");
                                                                               submitKasuspenyakitdiagnosa();
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Diagnosa',
                                                                    'size'=>13,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogkasuspenyakitdiagnosa'),
                                                        )); ?>
                        </div>
        <table id="tabelKasuspenyakitdiagnosa" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>Jenis Kasus Penyakit</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Hapus<br/>/ Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $jenispenyakit_id = $_GET['id'];
                    $modKasuspenyakitdiagnosa = KasuspenyakitdiagnosaM::model()->findAllByAttributes(array('jeniskasuspenyakit_id'=>$jenispenyakit_id));
                    foreach ($modKasuspenyakitdiagnosa as $value)
                    {
                        $hapus = Yii::app()->createUrl('rawatInap/kasuspenyakitdiagnosaM/Delete',array('jeniskasuspenyakit_id'=>"$value->jeniskasuspenyakit_id",'diagnosa_id'=>"$value->diagnosa_id"));
                        $tr .= '<tr>';
                        $tr .= '<td>' .$value->jeniskasuspenyakit->jeniskasuspenyakit_nama. '</td>';
                        $tr .= '<td>' .$value->diagnosa->diagnosa_nama .'</td>';
                        $tr .= '<td>' .$value->diagnosa->diagnosa_namalainnya.'&nbsp;'.'</td>';
                    $tr .= '<td>'.CHtml::link("<i class='icon-trash'></i>",$hapus).'</td>';
                        $tr .= '</tr>';
                    }
                    echo $tr;
                ?>
            </tbody>
        </table>


	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                     array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)','onClick'=>'return formSubmit(this,event)')); ?>
                                               <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                    Yii::app()->createUrl($this->module->id.'/'.kasuspenyakitdiagnosaM.'/admin'), 
                                                                    array('class'=>'btn btn-danger',
                                                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	</div>

<?php $this->endWidget(); ?>
<!-- ============================== Widget Dialog Jenis Kasus Penyakit =============================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogkasuspenyakit',
        'options'=>array(
            'title'=>'Pencarian Kasus Penyakit',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modJeniskasuspenyakit = new JeniskasuspenyakitM;
    $modJeniskasuspenyakit->unsetAttributes();
    if (isset($_GET['JeniskasuspenyakitM'])) {
        $modJeniskasuspenyakit->attributes = $_GET['JeniskasuspenyakitM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'jeniskasuspenyakit-grid',
        'dataProvider'=>$modJeniskasuspenyakit->search(),
        'filter'=>$modJeniskasuspenyakit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#KasuspenyakitdiagnosaM_jeniskasuspenyakit_id\").val($data->jeniskasuspenyakit_id);
                                                              \$(\"#kasuspenyakit\").val(\"$data->jeniskasuspenyakit_nama\");
                                                              \$(\"#dialogkasuspenyakit\").dialog(\"close\");"
                                ))',
            ),
            array(
                'header'=>'Nama Kasus',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
            array(
                'header'=>'Nama Lainnya',
                'value'=>'$data->jeniskasuspenyakit_namalainnya',
            ),
            array(
                'header'=>'Urutan',
                'value'=>'$data->jeniskasuspenyakit_urutan',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!-- ======================== endWidget dialogkasuspenyakit ===================================== -->

<!-- ============================== Widget Dialog Diagnosa ==================================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogkasuspenyakitdiagnosa',
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
                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#KasuspenyakitdiagnosaM_diagnosa_id\").val($data->diagnosa_id);
                                                              \$(\"#diagnosa\").val(\"\");
                                                              \$(\"#dialogkasuspenyakitdiagnosa\").dialog(\"close\");
                                                              submitKasuspenyakitdiagnosa();"
                                ))',
            ),
            array(
                'header'=>'Nama Diagnosa',
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
<!-- ======================== endWidget dialogkasuspenyakit ===================================== -->
<?php
$urlGetKasuspenyakitdiagnosa = $this->createUrl('KasuspenyakitdiagnosaM');
?>
        
<?php
$jscript = <<< JS
function submitKasuspenyakitdiagnosa()
{
    jeniskasuspenyakit_id = $('#KasuspenyakitdiagnosaM_jeniskasuspenyakit_id').val();
    diagnosa_id = $('#KasuspenyakitdiagnosaM_diagnosa_id').val();

    if(jeniskasuspenyakit_id==''){
        myAlert('Silahkan Pilih Jenis Kasus Penyakit Terlebih Dahulu');
    }else{
        $.post("${urlGetKasuspenyakitdiagnosa}", {jeniskasuspenyakit_id:jeniskasuspenyakit_id, diagnosa_id: diagnosa_id,},
        function(data){
            $('#tabelKasuspenyakitdiagnosa tbody').append(data.tr);
            renameInput();
        }, "json");
    }
}

function renameInput(){
    nourut = 0;
    $('.jenispenyakit').each(function(){
        $(this).parents('tr').find('[name*="KasuspenyakitdiagnosaM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('KasuspenyakitdiagnosaM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','KasuspenyakitdiagnosaM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}
JS;

Yii::app()->clientScript->registerScript('kasuspenyakitdiagnosa',$jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
  function hapusBaris(obj)
    {
      $(obj).parent().parent('tr').detach();
    }
</script>