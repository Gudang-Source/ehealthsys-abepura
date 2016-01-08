<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRehab, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRehab, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRehab, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRehab, 'jenistindakanrm_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRehab, 'jenistindakanrm_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRehab, 'tindakanrm_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRehab, 'tindakanrm_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanRehab();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanRehabReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>