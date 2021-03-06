
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjkasuspenyakitdiagnosa-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#pegawai',
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
                        <?php echo CHtml::label('Nama Pegawai','',array('class'=>'control-label required')); ?>
                        <div class="controls">
                                        <?php echo $form->hiddenField($model,'pegawai_id', array('readonly'=>true)) ?>
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'pegawai_id', 
                                                                'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/Pegawai').'",
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
                                                                               $(\'#RuanganpegawaiM_pegawai_id\').val(ui.item.value);
                                                                               $(\'#pegawai\').val("");
                                                                               submitruanganpegawai();
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Nama Pegawai',
                                                                    'size'=>13,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogpegawai'),
                                                        )); ?>
                        </div>
        <table id="tabelKasuspenyakitdiagnosa" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>Nama Instalasi</th>
                    <th>Nama Ruangan</th>
                    <th>Nama Lain</th>
                    <th>Pegawai</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (count($modDetails) > 0)
                    {
                        foreach ($modDetails as $i=>$row)
                        {
                            $modinstalasi = InstalasiM::model()->findByPK($row->instalasi_id);
                            $modruangan = RuanganM::model()->findByPK($row->ruangan_id);
                            $modpegawai = PegawaiM::model()->findByPK($row->pegawai_id);
                                $tr = "<tr>";
                                $tr .= "<td>"
                                            .$modinstalasi->instalasi_nama
                                            .CHtml::hiddenField('ruangan_id[]',$row->ruangan_id,array('readonly'=>true))
                                            .CHtml::hiddenField('pegawai_id[]',$row->pegawai_id,array('readonly'=>true))
                                            ."</td>";
                                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                                $tr .= "<td>".$modruangan->ruangan_namalainnya."</td>";
                                $tr .= "<td>".$modpegawai->NamaLengkap."</td>";
                                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'remove(this);'))."</td>";
                                $tr .= "</tr>";
                                echo $tr;
                        }
                    }
                ?>
            </tbody>
        </table>


	<div class="form-actions">
            <?php 
                                    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/ruanganpegawaiM/admin'), 
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ruangan Pegawai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('ruanganpegawaiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('farmasiApotek.views.tips.tipsaddedit3',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>
<!-- ============================== Widget Dialog Jenis Kasus Penyakit =============================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogpegawai',
        'options'=>array(
            'title'=>'Pencarian Data Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modPegawai = new PegawaiM;
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPegawai->attributes = $_GET['PegawaiM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pegawai-grid',
        'dataProvider'=>$modPegawai->search(),
        'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "onClick" => "\$(\"#RuanganpegawaiM_pegawai_id\").val($data->pegawai_id);
                                                              \$(\"#pegawai\").val(\"\");
                                                              \$(\"#dialogpegawai\").dialog(\"close\")
                                                              submitruanganpegawai();"
                                ))',
            ),
//                array(
//                    'header'=>'NIP',
////                    'type'=>'raw',
//                    'value'=>'$data->nomorindukpegawai',
//                    
//                ),
            'nomorindukpegawai',
            array(
                    'header'=>'Gelar Depan',
//                    'type'=>'raw',
                    'value'=>'$data->NamaDepanGelar',
                ),
                
                'nama_pegawai',
            array(
                    'header'=>'Gelar Belakang',
                   'type'=>'raw',
                    'value'=>'$data->NamaGelar',
                ),
//                array(
//                    'header'=>'No. Kartu PNS',
//                    'value'=>'$data->no_kartupegawainegerisipil',
//                ),
            array(
                    'header'=>'Jenis Kelamin',
                'type'=>'raw',
                    'value'=>'$data->jeniskelamin',
                ),
            array(
                    'header'=>'Kelompok Pegawai',
                   'type'=>'raw',
                    'value'=>'$data->NamaKelompok',
                ),
//        	array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->pegawai_aktif',
//                ), 
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!-- ======================== endWidget dialogkasuspenyakit ===================================== -->
<?php
$urlGetRuanganpegawai = Yii::app()->createUrl('actionAjax/Ruanganpegawai');
?>
        
<?php
$jscript = <<< JS
function submitruanganpegawai()
{
    instalasi_id = $('#instalasi_id').val();
    ruanganid = $('#ruanganid').val();
    pegawai_id = $('#RuanganpegawaiM_pegawai_id').val();

    if(pegawai_id==''){
        myAlert('Silahkan Pilih Pegawai Terlebih dahulu');
    }else{
        $.post("${urlGetRuanganpegawai}", {instalasi_id:instalasi_id, ruanganid:ruanganid, pegawai_id:pegawai_id},
        function(data){
            $('#tabelKasuspenyakitdiagnosa').append(data.tr);
        }, "json");
    }   
}
JS;

Yii::app()->clientScript->registerScript('ruanganpegawai',$jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
  function hapusBaris(obj)
    {
      $(obj).parent().parent('tr').detach();
    }
</script>