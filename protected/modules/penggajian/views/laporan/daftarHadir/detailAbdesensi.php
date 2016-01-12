<fieldset>
    <legend class="rim">Detail Informasi Pasien</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'frmpresensi-t',
        'type'=>'horizontal',
    )
);
Yii::app()->clientScript->registerScript('search', "
    $('#frmpresensi-t').submit(function(){
            $.fn.yiiGridView.update('lapegawai-d-grid', {
                data: $(this).serialize()
            });
            return false;
    });
");

?>
    
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($modPegawai,'nama_pegawai',array('readonly'=>true, 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'nofingerprint',array('readonly'=>true,'class'=>'span3')); ?>
            <?php echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'unit_perusahaan',array('readonly'=>true,'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($modPegawai,'kelompokpegawai_id',array('readonly'=>true,'value'=>$modPegawai->kelompokpegawai->kelompokpegawai_nama, 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'value'=>$modPegawai->jabatan->jabatan_nama, 'class'=>'span3')); ?>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?> 
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi_akhir',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?>
                </div>
            </div>            
            
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), "#", array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")){return false;}else{window.location.reload();}')); ?>
</div>
<?php $this->endWidget(); ?>
</fieldset>
<br>
<?php
      $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'lapegawai-d-grid',
            'dataProvider'=>$model->detailPresensi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$row+1',
                    'htmlOptions'=>array('style'=>'text-align: center; width:20px'),
                ),
//                array(
//                    'header'=>'<center>Masuk</center>',
//                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->tglpresensi),true)',
//                ),
                array(
                   'header'=>'Tanggal',
                   'type'=>'raw',
                   'value'=>'date("d/m/Y", strtotime($data->datepresensi))',
                ),
                array(
                    'header'=>'<center>Masuk</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
            ),
            'afterAjaxUpdate'=>'
                function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',
        )
  );
      
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl(
        $module.'/'.$controller.'/printDetailLaporanPresensi',
        array(
            'id'=>$modPegawai->pegawai_id
        )
    );
    
$js = <<< JSCRIPT
function print(caraPrint)
{
    var urlDate = "&tglpresensi=" + $("#frmpresensi-t").find('input[name$="[tglpresensi]"]').val() + "&" + "tglpresensi_akhir=" + $("#frmpresensi-t").find('input[name$="[tglpresensi_akhir]"]').val();
    window.open("${urlPrint}&caraPrint="+caraPrint+urlDate,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
