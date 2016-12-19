<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'adprofil-s-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adprofil-s-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->textFieldRow($model,'nama_profil',array('class'=>'span5','maxlength'=>200, 'size'=>50)); ?>

    <?php echo $form->textAreaRow($model,'alamat_profil',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'propinsi_profil',array('class'=>'span5','maxlength'=>200, 'size'=>50)); ?>

	<?php echo $form->textFieldRow($model,'kota_kab_profil',array('class'=>'span5','maxlength'=>200, 'size'=>50)); ?>

	<?php echo $form->textFieldRow($model,'telp_profil',array('class'=>'span5','maxlength'=>50, 'size'=>50)); ?>

	<?php echo $form->textFieldRow($model,'fax_profil',array('class'=>'span5','maxlength'=>50, 'size'=>50)); ?>

	<?php echo $form->textFieldRow($model,'email_profil',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>

    <?php echo $form->textAreaRow($model,'visi_profil',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'misi_profil',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'waktu_layanan',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>

    <?php echo $form->textAreaRow($model,'textinfo1',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'textinfo2',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'textinfo3',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'textinfo4',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        
    <?php echo $form->textAreaRow($model,'valuestext1',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        
    <?php echo $form->textAreaRow($model,'valuestext2',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        
    <?php echo $form->textAreaRow($model,'valuestext3',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        
    <?php echo $form->textFieldRow($model,'sloganwebsite1',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>

    <?php echo $form->textFieldRow($model,'sloganwebsite2',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>
        
    <?php echo $form->textFieldRow($model,'onlinesupport1',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>
        
    <?php echo $form->textFieldRow($model,'onlinesupport2',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>
        
    <?php echo $form->textFieldRow($model,'onlinemarketing1',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>
        
    <?php echo $form->textFieldRow($model,'onlinemarketing2',array('class'=>'span5','maxlength'=>100, 'size'=>50)); ?>
    
        <div class="form-group">
        <?php if ((!$model->isNewRecord) && (!empty($model->path_valuesimage1))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "<img src='".Params::urlProfilKoperasiRSDirectory().$model->path_valuesimage1."' class='preview_picture' width='300px' height='300px' align='right'>";
                echo "</div></div>";
        }else if((!$model->isNewRecord) && (empty($model->path_valuesimage1))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "Gambar belum diset";
                echo "</div></div>";
        }
        ?>
            <?php echo $form->labelEx($model, 'path_valuesimage1',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-6">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage1') ?>

            </div>
        </div>
        <div class="form-group">
        <?php if ((!$model->isNewRecord) && (!empty($model->path_valuesimage2))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "<img src='".Params::urlProfilKoperasiRSDirectory().$model->path_valuesimage2."' class='preview_picture' width='300px' height='300px' align='right'>";
                echo "</div></div>";
        }else if((!$model->isNewRecord) && (empty($model->path_valuesimage2))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "Gambar belum diset";
                echo "</div></div>";
        }
        ?>
            <?php echo $form->labelEx($model, 'path_valuesimage2',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-6">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage2') ?>

            </div>
        </div>
        <div class="form-group">
        <?php if ((!$model->isNewRecord) && (!empty($model->path_valuesimage3))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "<img src='".Params::urlProfilKoperasiRSDirectory().$model->path_valuesimage3."' class='preview_picture' width='300px' height='300px' align='right'>";
                echo "</div></div>";
        }else if((!$model->isNewRecord) && (empty($model->path_valuesimage3))){
            echo "<div class='form-group'>
            <div class='col-sm-6'>";
                echo "Gambar belum diset";
                echo "</div></div>";
        }
        ?>
            <?php echo $form->labelEx($model, 'path_valuesimage3',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-6">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage3') ?>

            </div>
        </div>

	<?php echo $form->textFieldRow($model,'longitude',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'latitude',array('class'=>'span5','maxlength'=>100)); ?>

<div class="form-group">
	<div class="col-sm-offset-3 col-sm-5">
	<?php //$this->widget('bootstrap.widgets.TbButton', array(
		//	'buttonType'=>'submit',
		//	'type'=>'primary',
		//	'label'=>$model->isNewRecord ? 'Buat' : 'Simpan',
		//	'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
		//)); ?>
            <?php if ($model->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
<?php echo $model->isNewRecord ? '&nbsp;&nbsp;'.CHtml::ResetButton('Reset', array('class' => 'btn btn-default')) : ''; ?><?php echo Chtml::link('Kembali',$this->createUrl('/admin/ProfilS/admin'), array('class' => 'btn btn-link')); ?>	</div>
</div>
<?php $this->endWidget(); ?>
