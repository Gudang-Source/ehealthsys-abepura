<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRad, 'jenispemeriksaanrad_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRad();",)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRad();",)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanRad();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanRadReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>