<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <fieldset class="box">
        <legend class="rim">Berdasarkan Tanggal Penjualan</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class = 'control-label'>Tanggal Penjualan</div>
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
							//LNG-2011
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                    
                </td>
                <td>
                    <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
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
							//LNG-2011
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->dropDownListRow($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'),array('empty'=>'-- Pilih --', 'autofocus'=>true)); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
            array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
        </div>
    </fieldset>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
?>


<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPenjualanObat', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>