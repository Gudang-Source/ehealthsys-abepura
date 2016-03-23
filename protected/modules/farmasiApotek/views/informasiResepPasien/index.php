<div class="white-container">
    <legend class="rim2">Informasi Resep <b>Pasien RS</b></legend>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'search',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modInfoPenjualan,'no_rekam_medik'),
                'method'=>'get',
        ));
    ?>
    <div class="block-tabel">
        <h6>Tabel Resep <b>Pasien RS</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'informasipenjualanresep-grid',
            'dataProvider'=>$modInfoPenjualan->searchInfoResepPasien(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Penjualan /<br/> Tanggal Resep',
                    'type'=>'raw',
                    'value'=>'$data->tglpenjualan." / <br>".$data->tglresep',
                ),
                array(
                    'header'=>'No. Resep',
                    'type'=>'raw',
                    'value'=>'$data->noresep',
                ),
                array(
                    'header'=>'Ruangan Asal Obat',
                    'type'=>'raw',
                    'value'=>'$data->namaRuangan',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'"$data->no_rekam_medik"."<br/>"."$data->nama_pasien"',
                ),
                array(
                    'header'=>'Umur / <br> Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'"$data->umur"."<br/>"."$data->jeniskelamin"',
                ),
                array(
                    'header'=>'Alamat',
                    'type'=>'raw',
                    'value'=>'$data->alamat_pasien',
                ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>'($data->jenispenjualan == "PENJUALAN BEBAS" OR $data->nama_pegawai == "Eli Hismiati") ? "-" : $data->NamaDokter',
                ),
                array(
                    'header'=>'Detail Penjualan',
                    'type'=>'raw', 
                    'value'=>'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/detailPenjualan",array("id"=>$data->penjualanresep_id , "pasien_id"=>$data->pasien_id)),
                                array("class"=>"", 
                                      "target"=>"iframePasienResep",
                                      "onclick"=>"$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk lihat detail penjualan",
                                ))',
                    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                ),
//                array(
//                    'header'=>'Retur Penjualan',
//                    'type'=>'raw', 
//                    'value'=>'(!empty($data->NomorResepSudahBayar) ? '
//                    . '"Pasien Sudah Bayar" : (!empty($data->returresep_id) ? "Sudah Diretur" :'
//                    . 'CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
//                                array("class"=>"", 
//                                      "target"=>"iframeReturPenjualan",
//                                      "onclick"=>"cekHakRetur(this);return false;",
//                                      "rel"=>"tooltip",
//                                      "title"=>"Klik untuk Retur Penjualan",
//                                ))))',
//                    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
//                ),
				array(
					'header'=>'Batal / Retur Penjualan',
					'type'=>'raw', 
					'value'=>'(!empty($data->returresep_id)) ? "Sudah Diretur"."<br>".CHtml::Link("<i class=\"icon-form-print\"></i>","#",
						array("class"=>"", 
							  "onclick"=>"printRetur(".$data->returresep_id.",".$data->penjualanresep_id.",\"PRINT\");return false;",
							  "rel"=>"tooltip",
							  "title"=>"Klik untuk mencetak Retur Penjualan",
						)) : 
						(!empty($data->nomorResepSudahBayar) ? 
						"Sudah Lunas": 
						CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
						   array("class"=>"", 
								 "onclick"=>"cekHakBatal(".$data->penjualanresep_id.");return false;",
								 "rel"=>"tooltip",
								 "title"=>"Klik untuk Batal Penjualan Resep",
						   ))."&nbsp;&nbsp;".CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
						   array("class"=>"", 
								 "target"=>"iframeReturPenjualan",
								 "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
								 "rel"=>"tooltip",
								 "title"=>"Klik untuk Retur Penjualan",
					)))',
					'htmlOptions'=>array('style'=>'text-align: left; width:80px'),
				),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Penjualan','tglawal',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $modInfoPenjualan->tgl_awal = $format->formatDateTimeForUser($modInfoPenjualan->tgl_awal); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modInfoPenjualan,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                        //
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($modInfoPenjualan->tgl_awal); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label(' Sampai dengan','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForUser($modInfoPenjualan->tgl_akhir); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modInfoPenjualan,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($modInfoPenjualan->tgl_akhir); ?>
                        </div>
                    </div>                
                </td>
                <td>
                    <?php echo $form->textFieldRow($modInfoPenjualan,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbersOnly','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($modInfoPenjualan,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan Asal Obat','ruanganasalobat',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modInfoPenjualan,'ruanganasalobat', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'), 'ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')),'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div> 
                    <div class="control-group">
                        <?php echo CHtml::label('No. Resep','no_resep',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modInfoPenjualan,'noresep',array('placeholder'=>'Ketik No. Resep','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
                <?php  
                    $content = $this->renderPartial('../tips/informasiPenjualanResep',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

    <?php 
    // Dialog buat lihat penjualan resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogDetailPenjualan',
        'options'=>array(
            'title'=>'Detail Penjualan Resep',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
        ),
    ));
    ?>
    <iframe src="" name="iframePasienResep" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end lihat penjualan resep dialog =============================
    ?>
	<?php 
    // Dialog buat lihat Retur Penjualan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogReturPenjualan',
        'options'=>array(
            'title'=>'Retur Penjualan',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
            'before'
        ),
    ));
    ?>
    <iframe src="" name="iframeReturPenjualan" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end lihat Retur Penjualan Dialog =============================
    ?>
	<script type="text/javascript">
		function printRetur(returresep_id,penjualanresep_id, caraPrint)
		{
			window.open("<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/informasiPenjualanResep/PrintStrukRetur') ?>&returresep_id="+returresep_id+"&penjualanresep_id="+penjualanresep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
		}
	</script>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'logindialog',
        'options'=>array(
            'title'=>'Login',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>400,
            'height'=>190,
            'resizable'=>false,
        ),
    ));?>
    <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'loginform')); ?>
        <div class="control-group ">
            <?php echo CHtml::label('Nama Pemakai','username', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('username', '', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::hiddenField('penjualanresep_id', '', array()); ?> 
                <?php echo CHtml::hiddenField('untukaction', '', array()); ?> 
            </div>
        </div>

        <div class="control-group ">
            <?php echo CHtml::label('Kata Kunci','password', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::passwordField('password', '', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'submitLogin();return false;', 'onkeypress'=>'submitLogin();return false;')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), '#', array('class'=>'btn btn-danger','onclick'=>"$('#logindialog').dialog('close');return false",'disabled'=>false)); ?>
        </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>
	<?php $this->renderPartial($this->path_view.'_jsFunctionsIndex'); ?>
</div>