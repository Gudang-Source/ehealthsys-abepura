<div class="white-container">
    <legend class="rim2">Informasi <b>Pemakaian Obat Ruangan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
            <?php 
            Yii::app()->clientScript->registerScript('cariPasien', "
            $('#pemakaianbahan-form').submit(function(){
                    $.fn.yiiGridView.update('pemakaianbahan-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
    ");?>
    <?php
    
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pemakaianbahan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'method'=>'get',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));
    
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class='block-tabel'>
        <h6>Tabel <b>Pemakaian Obat Ruangan</b></h6>
            <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'pemakaianbahan-grid',
                    'dataProvider'=>$model->searchPemakaian(),
            //        'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                            'name'=>'tglpemakaianobat',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianobat)',
                        ),
                        array(
                            'name'=>'nopemakaian_obat',
                        ),
                        array(
                            'header'=>'Pegawai',
                            'name'=>'pegawai.pegawai_nama',
                            'type'=>'raw',
                            'value'=>'$data->pegawai->namaLengkap',
                        ),
                        array(
                            'name'=>'untukkeperluan_obat',
                        ),
                        array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link(
                                        '<i class="icon-form-detail"></i>', 
                                        $this->createUrl('detail', array('id'=>$data->pemakaianobat_id)),
                                        array(
                                            'target'=>'iframeDetail',
                                            'onclick'=>'$("#dialogDetail").dialog("open");',
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk melihat detail pemakaian obat",
                                        ));
                            },
                            'htmlOptions'=>array('style'=>'text-align: center'),
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
            ?>
        
        
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-search icon-white"></i> <?php echo 'Pencarian Pemakaian Obat'; ?></legend>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php //$model->tglAwal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglAwal, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo CHtml::label('Tanggal Awal','tglAwal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglAwal = MyFormatter::formatDateTimeForUser($model->tglAwal); ?>
                            <?php
                                $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglAwal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            //
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker3 shadee', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                )); ?>                            
                        </div>
                    </div>
                    <div class="control-group">
                        <?php //$model->tglAkhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglAkhir, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo CHtml::label('Tanggal Akhir','tglAkhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglAkhir = MyFormatter::formatDateTimeForUser($model->tglAkhir); ?>
                            <?php
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglAkhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3 shadee', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $model->tglAkhir = MyFormatter::formatDateTimeForDb($model->tglAkhir); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Pemakaian Obat','nopemakaian_obat', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <div class="controls">
                                <?php echo $form->textField($model, 'nopemakaian_obat', array('class'=>'span3 angkahuruf-only')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Pegawai','pegawai_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'pegawai_id', 
                                        CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                                            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                            'pegawai_aktif'=>true,
                                        ), array(
                                            'order'=>'nama_pegawai',
                                        )), 'pegawai_id', 'namaLengkap')
                                        , array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;')); ?>
            <?php
            $content = $this->renderPartial($this->path_view.'tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    
</div>

<?php
// Dialog buat nambah data propinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetail',
    'options'=>array(
        'title'=>'Pemakaian Obat Ruangan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="450" >
</iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>
