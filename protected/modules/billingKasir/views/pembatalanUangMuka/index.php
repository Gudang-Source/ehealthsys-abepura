<div class="white-container">
    <legend class="rim2">Transaksi Pembatalan <b>Uang Muka</b></legend>
    <?php
        $this->breadcrumbs = array(
            'Pembatalan Uang Muka',
        );
    ?>
    <?php
		if(isset($_GET['sukses'])){
	        Yii::app()->user->setFlash('success',"Uang muka pasien berhasil dibatalkan !");
	    }
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'pembayaran-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#BKPasienM_no_rekam_medik',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event);',
					'onsubmit'=>'return requiredCheck(this);',
                ),
            )
        );
    ?>
    <?php
        $this->renderPartial(
            '_ringkasDataPasien',
            array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien
            )
        );
    ?>

    <?php //echo $form->errorSummary(array($modBatal,$modBuktiKeluar)); ?>
    <fieldset class="box">
        <legend class="rim">Data Pembatalan</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php 
                        echo CHtml::activeHiddenField($modBatal,'bayaruangmuka_id',
                            array(
                                'readonly'=>true,
                                'class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                 'value'=>isset($_GET['idBayarUangMuka']) ? $_GET['idBayarUangMuka'] :null,
                            )
                        ); 
                    ?>
                    <?php 
                        echo CHtml::activeHiddenField($modBatal,'tandabuktibayar_id',
                            array(
                                'readonly'=>true,
                                'class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event);"
                            )
                        ); 
                    ?>
                    <?php //echo $form->textFieldRow($modBatal,'tglpembatalan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php $modBatal->tglpembatalan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatal->tglpembatalan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php 
                            echo $form->labelEx(
                                $modBatal,'tglpembatalan', 
                                array(
                                    'class'=>'control-label'
                                )
                            );
                        ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',
                                        array(
                                            'model'=>$modBatal,
                                            'attribute'=>'tglpembatalan',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array(
                                                'class'=>'dtPicker2-5', 
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                                        )
                                    );
                            ?>
                        </div>
                    </div>
                    <?php
						$modBuktiKeluar->jmlkaskeluar = !empty($modBuktiKeluar->jmlkaskeluar)?MyFormatter::formatNumberForUser($modBuktiKeluar->jmlkaskeluar):0;
                        echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',
                            array(
                                'class'=>'span3 integer req', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);"
                            )
                        ); 
                        echo $form->hiddenField($modBuktiKeluar,'tandabuktikeluar_id',array());
                    ?>
                    <?php 
						$modBuktiKeluar->biayaadministrasi = MyFormatter::formatNumberForUser($modBuktiKeluar->biayaadministrasi);
                        echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',
                            array(
                                'class'=>'span3 integer', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);"
                            )
                        ); 
                    ?>
                    <?php 
                        echo $form->textAreaRow($modBatal,'keterangan_batal',
                            array(
                                'class'=>'span3 req', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);"
                            )
                        ); 
                    ?>
                </td>
                <td>
                    <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php
                        echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',
                            array(
                                'class'=>'span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                'maxlength'=>50
                            )
                        );
                    ?>
                    <?php
                        echo $form->dropDownListRow($modBuktiKeluar,'carabayarkeluar', 
                            LookupM::getItems('carabayarkeluar'),
                            array(
                                'onchange'=>'formCarabayar(this.value)',
                                'class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                                'maxlength'=>50
                            )
                        );
                    ?>
                    <div id="divCaraBayarTransfer" class="hide">
                        <?php
                            echo $form->textFieldRow($modBuktiKeluar,'melalubank',
                                array(
                                    'class'=>'span3', 
                                    'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                    'maxlength'=>100
                                )
                            );
                        ?>
                        <?php 
                            echo $form->textFieldRow($modBuktiKeluar,'denganrekening',
                                array(
                                    'class'=>'span3', 
                                    'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                    'maxlength'=>100
                                )
                            ); 
                        ?>
                        <?php 
                            echo $form->textFieldRow($modBuktiKeluar,'atasnamarekening',
                                array(
                                    'class'=>'span3', 
                                    'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                    'maxlength'=>100
                                )
                            );
                        ?>
                    </div>
                    <?php
                        echo $form->textFieldRow($modBuktiKeluar,'namapenerima',
                            array(
                                'class'=>'span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                'maxlength'=>100
                            )
                        ); 
                    ?>
                </td>
                <td>
                    <?php 
                        echo $form->textAreaRow($modBuktiKeluar,'alamatpenerima',
                            array(
                                'class'=>'span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);"
                            )
                        ); 
                    ?>
                    <?php 
                        echo $form->textFieldRow($modBuktiKeluar,'untukpembayaran',
                            array(
                                'class'=>'span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                'maxlength'=>100
                            )
                        ); 
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <div class="form-actions">
            <?php 
            if($modBuktiKeluar->isNewRecord)
            {
                echo CHtml::htmlButton(
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array(
                        'class'=>'btn btn-primary',
                        'type'=>'submit',
                        'onKeypress'=>'return formSubmit(this,event)',
                        'onClick'=>'onClickSubmit();return false;',
                    )
                );
                
                echo "&nbsp;&nbsp;";
//                echo CHtml::link(
//                    Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')),
//                    '#',
//                    array(
//                        'class'=>'btn btn-info',
//                        'onclick'=>"return false",
//                        'disabled'=>true
//                    )
//                );
//                
//                echo "&nbsp;&nbsp;";
					echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'return refreshForm(this);'));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array(
                        'class'=>'btn btn-primary',
                        'type'=>'submit',
                        'onKeypress'=>'return false',
                        'disabled'=>true
                    )
                );
                
                echo "&nbsp;&nbsp;";
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')),
                    '#',
                    array(
                        'class'=>'btn btn-info',
                        'onclick'=>"printKasir($modBuktiKeluar->tandabuktikeluar_id);return false",
                        'disabled'=>false
                    )
                ); 
                
                echo "&nbsp;&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));
            }
        ?>
			<?php  
$content = $this->renderPartial('tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>  
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array()); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dlgConfirmasi',
            'options'=>array(
                'title'=>'Konfirmasi Pembatalan',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>900,
                'height'=>400,
                'resizable'=>false,
            ),
        )
    );
?>
<div id="detail_confirmasi">
    <div id="content_confirm">
        <fieldset>
            <legend class="rim">Info Pasien</legend>
            <table id="info_pasien_temp" class="table table-bordered table-condensed">
                <tr>
                    <td width="150">No. Pendaftaran</td>
                    <td width="250" tag="no_pendaftaran"></td>
                    <td width="150">Nama</td>
                    <td tag="nama_pasien"></td>
                </tr>
                <tr>
                    <td>Instalasi</td>
                    <td tag="instalasi_nama"></td>
                    <td>No. Rekam Medis</td>
                    <td tag="no_rekam_medik"></td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td tag="ruangan_nama"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend class="rim">Detail Pembatalan</legend>
            <table id="info_pembayaran" class="table table-bordered table-condensed">
                <tr>
                    <td width="150">Nama Penerima</td>
                    <td width="250" tag="namapenerima"></td>
                    <td width="150">No. Kas</td>
                    <td tag="nokaskeluar"></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td tag="untukpembayaran"></td>
                    <td>Keterangan</td>
                    <td tag="keterangan_batal"></td>
                </tr>
                <tr>
                    <td>Jumlah Kas</td>
                    <td tag="jmlkaskeluar"></td>
                    <td>Biaya Administrasi</td>
                    <td tag="biayaadministrasi">&nbsp;</td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class="form-actions">
            <?php
                echo CHtml::link(
                    'Teruskan',
                    '#',
                    array(
                        'class'=>'btn btn-primary',
                        'onClick'=>'simpanProses();return false;'
                        
                    )
                );
            ?>
            <?php
                echo CHtml::link(
                    'Kembali', 
                    '#',
                    array(
                        'class'=>'btn btn-danger',
                        'onClick'=>'$("#dlgConfirmasi").dialog("close");$("#pembayaran-form").find("input[name$=\'[biayaadministrasi]\']").focus();return false;'
                    )
                );
            ?>
    </div>
</div>
<?php
    $this->endWidget();
?>
