<legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan Tanggal Stock Opname</legend>
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
    <table width="100%">
        <tr>
            <td>
                <?php $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
                <?php $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <div class = 'control-label'>Tanggal Stock Opname</div>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
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
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal); ?>
                    <?php $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </td>
            <td>
                 <?php echo $form->dropDownListRow($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(),'jenisobatalkes_id','jenisobatalkes_nama'),array('empty'=>'-- Pilih --')); ?>
            </td>
        </tr>
    </table>   
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
    </div>
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
<script type="text/javascript">
$(document).ready(function(){
    $('input[name="FALaporanfarmasikopnameV[tgl_awal]"]').focus();
})
</script>