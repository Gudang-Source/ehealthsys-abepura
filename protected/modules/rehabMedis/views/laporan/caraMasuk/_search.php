<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
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

    label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
    <fieldset class="box2">
        <legend class="rim">Berdasarkan Kunjungan</legend>
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php //echo CHtml::hiddenField('src', ''); ?>
        <table width="100%" border="0">
            <tr>
                <td>
                    <div class = 'control-label'>Tanggal Kunjungan</div>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'maxDate'=>'d',
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                            'class'=>'dtPicker2',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </td>
                <td>
                    <?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'maxDate'=>'d',
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                            'class'=>'dtPicker2',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <div id='searching'>
        <fieldset class="box2">
            <legend class="rim">Berdasarkan Rujukan</legend>
            <?php echo $form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_nama')); ?>
        </fieldset>
        <fieldset class="box2">
            <legend class="rim">Berdasarkan Asal Instalasi</legend>
            <?php echo $form->checkBoxList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'),'ruangan_id','ruangan_nama')); ?>
        </fieldset>
        <fieldset class="box2">
            <legend class="rim">Opsi Grafik</legend>
            <?php $model->pilihan = 'instalasi'; ?>
            <?php echo $form->radioButtonList($model, 'pilihan', $model->pilihanGrafik()); ?>
        </fieldset>
    </div>   
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
            array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
