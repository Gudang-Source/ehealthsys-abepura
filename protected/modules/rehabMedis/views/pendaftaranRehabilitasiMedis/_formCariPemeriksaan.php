<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRm, 'jenistindakanrm_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanRm, 'jenistindakanrm_nama',CHtml::listData(JenistindakanrmM::model()->findAll(array(
                    'condition'=>'jenistindakanrm_aktif = true',
                    'order'=>'jenistindakanrm_nama asc',
                )),'jenistindakanrm_nama','jenistindakanrm_nama'),array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::Label('Tindakan Rehab Medis', 'tindakanrm_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRm, 'tindakanrm_nama',array('class'=>'span3 custom-only','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanRehab();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanRehabReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>