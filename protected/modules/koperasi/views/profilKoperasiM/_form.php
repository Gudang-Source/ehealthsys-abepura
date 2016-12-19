
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'adprofil-s-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adprofil-s-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>
<div class='row-fluid'>
    <div class='span8'>
        <fieldset class="box">
            <legend class="rim">Identitas Koperasi</legend>
            <table width='100%'>
                <tr>
                    <td>
                        <?php echo $form->textFieldRow($model,'nama_profil',array('class'=>'span3','maxlength'=>200, 'size'=>50)); ?>
                        <?php echo $form->textAreaRow($model,'alamat_profil',array('rows'=>3, 'cols'=>10, 'class'=>'span4')); ?>
                        <?php echo $form->dropDownListRow($model,'propinsi_profil', Chtml::listData(PropinsiM::model()->findAll(" propinsi_aktif = TRUE ORDER BY propinsi_nama ASC "), 'propinsi_nama', 'propinsi_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>

                        <?php //echo $form->textFieldRow($model,'kota_kab_profil',array('class'=>'span3','maxlength'=>200, 'size'=>50)); ?>
                        <?php echo $form->dropDownListRow($model,'kota_kab_profil', Chtml::listData(KabupatenM::model()->findAll(" kabupaten_aktif = TRUE ORDER BY kabupaten_nama ASC "), 'kabupaten_nama', 'kabupaten_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>

                        <?php echo $form->textFieldRow($model,'longitude',array('class'=>'span3','maxlength'=>100)); ?>

                        <?php echo $form->textFieldRow($model,'latitude',array('class'=>'span3','maxlength'=>100)); ?>
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model,'telp_profil',array('class'=>'span3','maxlength'=>50, 'size'=>50)); ?>

                        <?php echo $form->textFieldRow($model,'fax_profil',array('class'=>'span3','maxlength'=>50, 'size'=>50)); ?>

                        <?php echo $form->textFieldRow($model,'email_profil',array('class'=>'span3','maxlength'=>100, 'size'=>50)); ?>

                        <?php echo $form->textFieldRow($model,'waktu_layanan',array('class'=>'span3','maxlength'=>100, 'size'=>50)); ?>
                    </td>
                </tr>

            </table>                                                                       
        </fieldset>
    </div>
    <div class="span4">
    <fieldset class="box">
            <legend class="rim">Alamat / Lokasi Koperasi</legend>
           &nbsp;
    </fieldset>
</div>
</div>

   
<div class="span6"  style='padding: 10px;'>
    <fieldset class="box">
            <legend class="rim">lain - Lain</legend>
     <?php echo $form->textAreaRow($model,'visi_profil',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'misi_profil',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	

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
    
        <div class="control-group">
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
            <div class="controls">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage1') ?>

            </div>
        </div>
        <div class="control-group">
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
            <div class="controls">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage2') ?>

            </div>
        </div>
        <div class="control-group">
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
            <div class="controls">
                <?php echo CHtml::activeFileField($model, 'path_valuesimage3') ?>

            </div>
        </div>
	
    </fieldset>
</div>

	 <div class="span6"  style='padding: 10px;'>
        &nbsp;
    </div>

   
<div class="span12">
    <div class="form-group">
	<div class="col-sm-offset-3 col-sm-5">
	<?php //$this->widget('bootstrap.widgets.TbButton', array(
		//	'buttonType'=>'submit',
		//	'type'=>'primary',
		//	'label'=>$model->isNewRecord ? 'Buat' : 'Simpan',
		//	'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
		//)); ?>
            <?php //if ($model->isNewRecord) echo CHtml::submitButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>'btn btn-primary')); ?>
  <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create',array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
   
    ?>           
 <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
   <?php
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang'
        );
   
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
</div>
