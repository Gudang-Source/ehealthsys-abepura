<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'search-laporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        #checkBoxList{
            width:650px;
        }
        #checkBoxList label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <table width="100%">
        <tr>
            <td width="35%">
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Tanggal</legend>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
                    <?php $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php echo CHtml::label('Tanggal Penjualan', 'tgl_awal', array('class'=>'control-label')); ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
    //                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                    <?php echo CHtml::label('Sampai dengan', ' tgl_akhir', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
    //                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal); ?>
                        <?php $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </fieldset>
            </td>
            <td> 
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Jenis Penjualan</legend>
                    <div class="control-group">
                        <div class="controls">
                            <div id="checkBoxList">
                                <?php echo CHtml::checkBox('pilihSemua', true, array('onclick'=>'checkAll();')) ?> <label><b>Pilih Semua</b></label><br /><br />
                                <?php echo $form->checkBoxList($model, 'jenispenjualan', LookupM::getItems('jenispenjualan')); ?><br>
                            </div>

                        </div>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()'));
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        myConfirm("Apakah anda ingin me-refresh halaman?","Perhatian!",
        function(r){
            if(r){
                window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPendapatanTransaksi', array('modul_id'=>Yii::app()->session['modul_id'])).'";
            }
        }); 

    }', CClientScript::POS_HEAD); ?>
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
    checkAll();
</script>