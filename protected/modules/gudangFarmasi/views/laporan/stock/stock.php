<div class="white-container">
    <legend class="rim2"> Laporan <b>Stock</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php
            $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FrameStock&id=1');
            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#search-laporan').submit(function(){
                    $.fn.yiiGridView.update('laporan-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
        ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'type'=>'horizontal',
                'id'=>'search-laporan',
                'focus'=>'#'.CHtml::activeId($model,'obatalkes_nama'),
        )); ?>
        <table width="100%">
<!--            <tr>
                <td>
                        <div class="control-group">
                           <?php //echo CHtml::label('Periode','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
    //                                    $this->widget('MyDateTimePicker',array(
    //                                                    'model'=>$model,
    //                                                    'attribute'=>'tgl_awal',
    //                                                    'mode'=>'datetime',
    //                                                    'options'=> array(
    //                                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                        'maxDate' => 'd',
    //                                                    ),
    //                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
    //                                    )); 
                                ?>
                            </div>
                        </div>
                </td>
                <td>
                        <div class="control-group">
                           <?php // echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
    //                                    $this->widget('MyDateTimePicker',array(
    //                                                    'model'=>$model,
    //                                                    'attribute'=>'tgl_akhir',
    //                                                    'mode'=>'datetime',
    //                                                    'options'=> array(
    //                                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                        'maxDate' => 'd',
    //                                                    ),
    //                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
    //                                    )); 
                                ?>
                            </div>
                        </div>
                </td>
            </tr>-->
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                </td>
                <td colspan="2">
                    <?php echo $form->textFieldRow($model, 'obatalkes_nama',array('placeholder'=>'Nama Obat Alkes','class'=>'span3')); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'obatalkes_kode',array('placeholder'=>'Kode Obat Alkes','class'=>'span3')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="controls">
                        <?php echo CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_in]', true, array('value' => 0));?>
                        <?php echo CHtml::label('Stok In 0', 'qtystok_in');?>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_out]', true, array('value' => 0));?>
                        <?php echo CHtml::label('Stok Out 0', 'qtystok_out');?>
                    </div>
                </td>            
            </tr>
        </table>
        <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

                    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/laporan/stock'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        </div>
        <?php
        $this->endWidget();
        ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Stock</b></h6>
        <?php $this->renderPartial('stock/_tableStock',array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintStock');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>