<style>
    #checkBoxList{
        width:100%;
    }
    #checkBoxList label.checkbox{
        width: 170px;
        display:inline-block;
        margin-right:10px;
    }
    
    #checkBoxList label.checkbox label{
        padding-left:10px;
    }

    #checkBoxList2{
        width:100%;
    }
    #checkBoxList2 label.checkbox{
        width: 170px;
        display:inline-block;
        margin-right:10px;
    }
    
    #checkBoxList2 label.checkbox label{
        padding-left:10px;
    }
    
    #checkBoxList3{
        width:100%;
    }
    #checkBoxList3 label.checkbox{
        width: 170px;
        display:inline-block;
        margin-right:10px;
    }
    
    #checkBoxList3 label.checkbox label{
        padding-left:10px;
    }
</style>

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
            <tr>
                <td colspan="2"> 
                    <div id='searching'>
                    <fieldset>            
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'jenisoa',
                            'slide'=>true,
                            'content'=>array(
                            'content1'=>array(
                                'header'=>'Berdasarkan Jenis Obat Alkes',
                                'isi'=>'                                                 
                                            <table id = "checkBoxList">
                                            <tr>                                                
                                                <td>'.CHtml::hiddenField('filter', 'jenis').CHtml::checkBox('pilihSemua', false, array('onclick'=>'checkAll();')).' Pilih Semua</td>
                                            </tr>
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->ItemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>								
			</div>
                    </fieldset>					
                </td>
                
                
            </tr>
            <tr>
                <td> 
                    <div id='searching'>
                    <fieldset>            
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kategorioa',
                            'slide'=>true,
                            'content'=>array(
                            'content2'=>array(
                                'header'=>'Berdasarkan Kategori Obat Alkes',
                                'isi'=>'                                                 
                                            <table id = "checkBoxList2">
                                            <tr>                                                
                                                <td>'.CHtml::hiddenField('filter', 'kategori').CHtml::checkBox('pilihSemua2', false, array('onclick'=>'checkAll2();')).' Pilih Semua</td>
                                            </tr>
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>false,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>								
			</div>
                    </fieldset>					
                </td>
                <td>                    
                    <div id='searching'>
                    <fieldset>            
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'golonganoa',
                            'slide'=>true,
                            'content'=>array(
                            'content3'=>array(
                                'header'=>'Berdasarkan Golongan Obat Alkes',
                                'isi'=>'                                                 
                                            <table id = "checkBoxList3">
                                            <tr>                                                
                                                <td>'.CHtml::hiddenField('filter', 'golongan').CHtml::checkBox('pilihSemua3', false, array('onclick'=>'checkAll3();')).' Pilih Semua</td>
                                            </tr>
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>false,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>								
			</div>
                    </fieldset>					                                    
                </td>
               
            </tr>
            <tr>
                 <td>                    
                    <div id='searching'>
                    <fieldset>            
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'stok',
                            'slide'=>true,
                            'content'=>array(
                            'content4'=>array(
                                'header'=>'Berdasarkan Stok',
                                'isi'=>'                                                 
                                            <table id = "stok">
                                            <tr>
                                                <td>'.CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_in]', false, array()).' Stok Masuk 0</td>
                                                <td>'.CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_out]', false, array()).' Stok Keluar 0</td>
                                            </tr>                                            
                                            </table>',            
                                'active'=>false,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>								
			</div>
                    </fieldset>					                                    
                </td>
            </tr>
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
                    <?php //echo $form->dropDownListRow($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                </td>
                <td colspan="2">
                    <?php //echo $form->textFieldRow($model, 'obatalkes_nama',array('placeholder'=>'Nama Obat Alkes','class'=>'span3')); ?>
                </td>
                <td>
                    <?php //echo $form->textFieldRow($model, 'obatalkes_kode',array('placeholder'=>'Kode Obat Alkes','class'=>'span3')); ?>
                </td>
            </tr>
            <tr>
                     
            </tr>
        </table>
        <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

                    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/laporan/stock'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
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
<script>
    function checkAll(){
        if($('#pilihSemua').is(':checked')){
            $('#checkBoxList').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#checkBoxList').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    
    function checkAll2(){
        if($('#pilihSemua2').is(':checked')){
            $('#checkBoxList2').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#checkBoxList2').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    
    function checkAll3(){
        if($('#pilihSemua3').is(':checked')){
            $('#checkBoxList3').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#checkBoxList3').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    
    $(document).ready(function(){
        checkAll();
    checkAll3();
    });
    
</script>