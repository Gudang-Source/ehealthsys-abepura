
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakomponen-tarif-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAKomponenTarifM_komponentarif_nama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
            <?php //echo $form->dropDownListRow($model, 'kelompokkomponentarif_id', 
                  //  CHtml::listData(SAKelompokkomponentarifM::model()->findAll('kelompokkomponentarif_aktif = true order by kelompokkomponentarif_nama'), 'kelompokkomponentarif_id', 'kelompokkomponentarif_nama'),
                  //  array('empty'=>'-- Pilh --', 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'komponentarif_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'komponentarif_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'komponentarif_urutan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'komponentarif_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

        <?php  echo $form->labelEx($model,'Instalasi',array('class'=>'control-label required'));  ?>
            <div class="control-group">
                <div class="controls">

                     <?php 
                            $arrKomponenTarifInstalasi = array();
                             foreach($modKomponenTarifInstalasi as $jenisKomponenTarifInstalasi){
                                $arrKomponenTarifInstalasi[] = $jenisKomponenTarifInstalasi['komponentarif_id'];
                            } 
                           $this->widget('application.extensions.emultiselect.EMultiSelect',
                                         array('sortable'=>true, 'searchable'=>true)
                                    );
                            echo CHtml::dropDownList(
                            'instalasi_id[]',
                            $arrKomponenTarifInstalasi,
                            CHtml::listData(SAInstalasiM::model()->findAll(array('order'=>'instalasi_nama')), 'instalasi_id', 'instalasi_nama'),
                            array('multiple'=>'multiple','key'=>'instalasi_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                    );
                      ?>

                 </div>
            </div>
        <fieldset class="box">
            <legend class="rim">Persentase Kelompok Komponen Tarif</legend>
            <table class="table table-bordered table-condensed" id="detail-kelompok">
                <thead>
                    <tr>
                        <th>Kelompok Komponen Tarif</th>
                        <th>Persentase</th>
                        <th style="text-align: center"><?php echo CHtml::link('<i class="icon-plus icon-white"></i> Tambah', '#', array(
                            'onclick'=>'tambahKelompok();return false;',
                        )); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $kel = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                        'komponentarif_id'=>$model->komponentarif_id,
                    ));
                    foreach ($kel as $item) {
                        echo $this->renderPartial('_rowKelKomponen', array('kel'=>$item->kelompokkomponentarif_id, 'persen'=>$item->persentase));
                    }
                    ?>
                </tbody>
            </table>
        </fieldset>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                                    array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Komponen Tarif', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions', array(), true); ?>
