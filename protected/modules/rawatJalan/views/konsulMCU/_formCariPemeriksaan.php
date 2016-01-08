<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::hiddenField("form_index",null,array('readonly'=>true));?>
    <?php echo CHtml::activeHiddenField($modPaketPelayanan, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPaketPelayanan, 'tipepaket_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPaketPelayanan, 'daftartindakan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPaketPelayanan, 'namatindakan',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPaketPelayanan, 'namatindakan',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistTindakanMcu();",'placeholder'=>'Ketik Nama Tindakan MCU',)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistTindakanMcu();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistTindakanMcuReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pencarian')); ?>
        </div>
    </div>
</div>