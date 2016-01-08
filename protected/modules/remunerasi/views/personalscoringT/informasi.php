<div class="white-container">
    <legend class="rim2">Informasi <b>Personal Scoring</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Personalscoring Ts'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search-t-form').submit(function(){
            $.fn.yiiGridView.update('personalscoring-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Personal Scoring</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'personalscoring-t-grid',
            'itemsCssClass'=>'table table-striped table-condensed',
            'dataProvider'=>$model->searchInformasi(),
            'columns'=>array(
                    'pegawai.nama_pegawai',
                    array(
                    'header'=>'tglscoring',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglscoring)',
                    ),
                    'periodescoring',
                    'sampaidengan',
                    array(
                        'header'=>'Detail',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("PersonalscoringT/detail",array("id"=>$data->personalscoring_id)),
                            array("class"=>"", 
                                "target"=>"detail",
                                  "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk melihat details",
                            ))',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
    //                    'value'=>'CHtml::link(\'<i class="icon-eye-open"></i>\',Yii::app()->createUrl(\'remunerasi/PersonalscoringT/detail&id=\'.$data->personalscoring_id))',
                    ),
            ),
        )); ?>
    </div>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'type'=>'horizontal',
            'id'=>'search-t-form',
            'method'=>'get',
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'tglscoring',array('class'=>'control-label')); ?>
                        <div class="controls">
                          <?php $model->tglscoring = $format->formatDateTimeForUser($model->tglscoring); ?>
                          <?php   $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglscoring',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2'),
                            )); ?>
                            <?php $model->tglscoring = $format->formatDateTimeForDb($model->tglscoring); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'periodescoring',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $model->periodescoring = $format->formatDateTimeForUser($model->periodescoring); ?>
                          <?php   $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'periodescoring',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2'),
                            )); ?>
                            <?php $model->periodescoring = $format->formatDateTimeForDb($model->periodescoring); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'sampaidengan',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $model->sampaidengan = $format->formatDateTimeForUser($model->sampaidengan); ?>
                            <?php   $this->widget('MyDateTimePicker',array(
                                      'model'=>$model,
                                      'attribute'=>'sampaidengan',
                                      'mode'=>'date',
                                      'options'=> array(
                                          'dateFormat'=>Params::DATE_FORMAT,
                                          'maxDate' => 'd',
                                      ),
                                      'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2'),
                              )); ?>
                            <?php $model->sampaidengan = $format->formatDateTimeForDb($model->sampaidengan); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'nama_pegawai'); ?>
                                    <?php echo $form->dropDownListRow($model,'jabatan',CHtml::listData($model->getJabatanItems(),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                    <?php echo $form->dropDownListRow($model,'pendidikan',CHtml::listData($model->getPendidikanItems(),'pendidikan_id','pendidikan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                </td>
            </tr>
        </table>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>&nbsp;
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),Yii::app()->createUrl($this->module->id.'/personalscoringT/informasi'), array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        <?php 
           $content = $this->renderPartial('../tips/informasi',array(),true);
           $this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetail',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Details Personal Scoring',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="detail" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>