<div class="white-container">
    <legend class="rim2">Transaksi Penyimpanan Dokumen <b>Rekam Medis Baru</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('ppdokumenpasienrmbaru-v-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class='hide'>
        <?php 
            $warnadokrm_id = 1;
            $this->widget('ext.colorpicker.ColorPicker', 
            array(
                'name'=>'Dokumen[warnadokrm_id][]',
                'value'=>WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id),// string hexa decimal contoh 000000 atau 0000ff
                'height'=>'30px', // tinggi
                'width'=>'83px',        
                //'swatch'=>true, // default false jika ingin swatch
                'colors'=>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                'colorOptions'=>array(
                    'transparency'=> true,
                   ),
                )
            );
        ?>
    </div>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form cari-lanjut2" style="display:none;">
        <?php 
		$this->renderPartial('_searchPenyimpanan',array(
            'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Penyimpanan <b>Dokumen Rekam Medis</b></h6>-->
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'ppdokrekammedis-m-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
        )); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'ppdokumenpasienrmbaru-v-grid',
            'dataProvider'=>$model->searchPenyimpanan(),
            //'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=> 'Pilih',
                    'type'=>'raw',
                    'value'=>'
                        CHtml::hiddenField(\'Dokumen[dokrekammedis_id][]\', $data->dokrekammedis_id).
                        CHtml::checkBox(\'cekList[]\', \'\', array(\'onclick\'=>\'setUrutan()\', \'class\'=>\'cekList\'));
                        ',
                ),
                array(
                    'header'=> 'Lokasi Rak',
                    'type'=>'raw',
                    'value'=>'
                        CHtml::dropDownList(\'Dokumen[lokasirak_id][]\',\'\',Chtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif=true\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih --\',\'class\'=>\'span2 lokasiRak\'));'
                ),
                array(
                    'header'=> 'Sub Rak',
                    'type'=>'raw',
                    'value'=>'
                        CHtml::dropDownList(\'Dokumen[subrak_id][]\',\'\',Chtml::listData(SubrakM::model()->findAll(\'subrak_aktif=true\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih --\', \'class\'=>\'span2 subRak\'));'
                ),
                //'lokasirak_id',
                //'subrak_id',
                //'warnadokrm_id',
        //        array(
        //            'header'=>'Warna Dokumen RK',
        //            'type'=>'raw',
        //            'value'=>"$ex",
        //        ),
                array(
                    'header'=>'Warna Dokumen RK',
                    'type'=>'raw',
                    'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->dokrekammedis->warnadokrm_id), true)',
                ),
                //'pasien_id',
                'pasien.no_rekam_medik',
                'pendaftaran.tgl_pendaftaran',
                'pendaftaran.no_pendaftaran',
                'pasien.nama_pasien',
                'pasien.tanggal_lahir',
                'pasien.jeniskelamin',
                //'alamat_pasien',
                //'instalasi_nama',
                'pendaftaran.instalasi.instalasi_nama',
                'pendaftaran.ruangan.ruangan_nama',
                //'tgl_rekam_medik',
                //'nama_pasien',
        //        'nama_bin',
        //        'jeniskelamin',
                /*

                'alamat_pasien',
                'tempat_lahir',
                'ruangan_id',
                'ruangan_nama',

                ////'pendaftaran_id',
                array(
                                'name'=>'pendaftaran_id',
                                'value'=>'$data->pendaftaran_id',
                                'filter'=>false,
                        ),

                'no_urutantri',
                'instalasi_id',
                'instalasi_nama',
                'statuspasien',
                */
        //        array(
        //                        'header'=>Yii::t('zii','View'),
        //            'class'=>'bootstrap.widgets.BootButtonColumn',
        //                        'template'=>'{view}',
        //        ),
        //        array(
        //                        'header'=>Yii::t('zii','Update'),
        //            'class'=>'bootstrap.widgets.BootButtonColumn',
        //                        'template'=>'{update}',
        //                        'buttons'=>array(
        //                            'update' => array (
        //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
        //                                        ),
        //                         ),
        //        ),
        //        array(
        //                        'header'=>Yii::t('zii','Delete'),
        //            'class'=>'bootstrap.widgets.BootButtonColumn',
        //                        'template'=>'{remove} {delete}',
        //                        'buttons'=>array(
        //                                        'remove' => array (
        //                                                'label'=>"<i class='icon-remove'></i>",
        //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
        //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendaftaran_id"))',
        //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
        //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
        //                                        ),
        //                                        'delete'=> array(
        //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
        //                                        ),
        //                        )
        //        ),
            ),
                'afterAjaxUpdate'=>'function(id, data){
                                var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                                jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                        }',
        )); ?> 


	
       
	<?php echo $form->errorSummary($modDokRekamMedis); ?>

            
            <?php //echo $form->textFieldRow($modDokRekamMedis,'nodokumenrm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->dropDownListRow($modDokRekamMedis,'statusrekammedis', LookupM::getItems('statusrekammedis') ,array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            <?php //echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'subrak_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglrekammedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'nomortertier',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php //echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->textFieldRow($model,'tgl_in_aktif',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'tglpemusnahan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
            <?php echo CHtml::htmlButton($modDokRekamMedis->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php //echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
    //                        Yii::app()->createUrl($this->module->id.'/'.dokrekammedis.'/admin'), 
    //                        array('class'=>'btn btn-danger',
    //                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	
            <?php 
                            //RND-5538 tombol print di comment sementara karena tidak ada fungsinya
//					 if((!$model->isNewRecord) AND ((Yii::app()->user->getState('printkartulsng')==TRUE) OR (Yii::app()->user->getState('printkartulsng')==TRUE)))
//                        {
                          
            ?>
<!--                            <script>
                                print(<?php //echo $model->pendaftaran_id ?>);
                            </script>-->
            <?php 
//					echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pendaftaran_id');return false",'disabled'=>FALSE  )); 
//                       }else{
//                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
//                       } 
            ?>

            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/Penyimpanan'), 
                array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Penyimpanan').'";} ); return false;'));  ?>
            <?php 
            $content = $this->renderPartial('../tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	

        </div>
    <!--</div>-->
    <?php $this->endWidget(); ?>
</div>
<script>
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
           $(this).attr('name','cekList['+noUrut+']');
           noUrut++;
        });
    }
    
    $(document).ready(function(){
        $('form#ppdokrekammedis-m-form').submit(function(){
            var jumlah = 0;
            var lokasiRak = 0;
            var subRak = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
                if ($(this).parents('tr').find('.lokasiRak').val() != ''){
                    lokasiRak++;
                }
                if ($(this).parents('tr').find('.subRak').val() != ''){
                    subRak++;
                }
            });
            if (jumlah < 1){
                myAlert('Pilih Dokumen yang akan dikirim');
                return false;
            }
            else if (lokasiRak < 1){
                myAlert('Isi Lokasi Rak pada dokumen yang dipilih');
                return false;
            }
            else if (subRak < 1){
                myAlert('Isi Sub Rak pada dokumen yang dipilih');
                return false;
            }
        });
    });
</script>