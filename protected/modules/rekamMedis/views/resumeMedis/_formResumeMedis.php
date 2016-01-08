<div class = "span6">
    <div class="control-group">
        <?php echo CHtml::label("1. Ikhtisar Singkat :", '', array('class'=>'control-label')); ?>
        <div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'ikhtisarkliniksingkat','toolbar'=>'mini','height'=>'100px')) ?>
		</div>
	</div>
        <?php echo CHtml::label(" 2. Diagnosis kelainan pada Pemeriksaan Fisik / Laboratorium / Rontgen : ", ''); ?>
    <div class="control-group">
        <?php echo CHtml::label("Pemeriksaan Fisik", '', array('class'=>'control-label')); ?>
        <div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'resume_pemeriksaanfisik','toolbar'=>'mini','height'=>'100px')) ?>
		</div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label("Pemeriksaan Laboratorium", '', array('class'=>'control-label')); ?>
        <div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'resume_pemeriksaanlab','toolbar'=>'mini','height'=>'100px')) ?>
		</div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label("Pemeriksaan Radiologi", '', array('class'=>'control-label')); ?>
        <div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'resume_pemeriksaanrad','toolbar'=>'mini','height'=>'100px')) ?>
		</div>
    </div>
</div>
<div class = "span6">
    <div class="control-group">
            <?php echo CHtml::label('3. Diagnosa Sementara : &nbsp;', '', array('class'=>'control-label')); ?>
        <div class="controls">	
            <div id='diagnosasementara-label'>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::hiddenField('diagnosaawal_id',$modResume->diagnosaawal_id,array('readonly'=>true,'class'=>'span3')); ?>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('4. Pengobatan sementara yang telah diberikan', '', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'terapiperawatan','toolbar'=>'mini','height'=>'100px')) ?>	
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('5. Diagnosa Akhir :', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <div id='diagnosautama-label'></div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
			<?php echo CHtml::hiddenField('diagnosautama_id',$modResume->diagnosautama_id,array('readonly'=>true,'class'=>'span3')); ?>
			<?php echo CHtml::hiddenField('diagnosasekunder1_id',$modResume->diagnosasekunder1_id,array('readonly'=>true,'class'=>'span3')); ?>
			<?php echo CHtml::hiddenField('diagnosasekunder2_id',$modResume->diagnosasekunder2_id,array('readonly'=>true,'class'=>'span3')); ?>
			<?php echo CHtml::hiddenField('diagnosasekunder3_id',$modResume->diagnosasekunder3_id,array('readonly'=>true,'class'=>'span3')); ?>
		</div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('6. Obat yang diberikan saat pulang', '', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'terapisaatpulang','toolbar'=>'mini','height'=>'100px')) ?>	
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('7. Saran', '', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modResume,'attribute'=>'saran_resume','toolbar'=>'mini','height'=>'100px')) ?>	
        </div>
    </div>
</div>
