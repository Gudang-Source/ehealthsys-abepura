<div class="white-container">
    <legend class="rim2">Informasi Penjualan <b>Obat Untuk Pegawai</b></legend>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'search',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modInfoPenjualan,'noresep'),
                'method'=>'get',
        ));
    ?>
    <div class="block-tabel">
        <h6>Tabel Penjualan <b>Obat Untuk Pegawai</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                $.fn.yiiGridView.update('informasipenjualankaryawan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'informasipenjualankaryawan-grid',
            'dataProvider'=>$modInfoPenjualan->searchInfoJualKaryawan(),
    //        'filter'=>$modInfo,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Penjualan /<br/> Tanggal Resep',
                    'type'=>'raw',
                    'value'=>'$data->tglpenjualan." / ".$data->tglresep',
                ),
                array(
                    'header'=>'No. Resep',
                    'type'=>'raw',
                    'value'=>'$data->noresep',
                ),
                array(
                    'header'=>'Jenis Penjualan',
                    'type'=>'raw',
                    'value'=>'$data->jenispenjualan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'type'=>'raw',
                    'value'=>'$data->getNamaPegawai($data->pasienpegawai_id)',
                ),
                array(
                    'header'=>'Nama Dokter Resep',
                    'type'=>'raw',
                    'value'=>'(isset($data->NamaDokter) ? $data->NamaDokter : "-")',
                ),
                array(
                    'header'=>'Umur / <br> Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'"$data->umur"."<br/>"."$data->jeniskelamin"',
                ),
                array(
                    'header'=>'Ubah',
                    'type'=>'raw',
                    'value'=>'(!empty($data->nomorResepSudahBayar) ? "<center>-</center>" : CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl(("InformasiPenjualanKaryawan/ubahPenjualanResep"),array("penjualanresep_id"=>$data->penjualanresep_id)),
                                array("class"=>"", 
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk lihat ubah penjualan",
                                )))',
                ),
                array(
                    'header'=>'Detail Penjualan',
                    'type'=>'raw', 
                    'value'=>'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("PenjualanKaryawan/print",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>1)),
                                array("class"=>"", 
                                      "target"=>"iframePenjualanResep",
                                      "onclick"=>"$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk lihat detail penjualan",
                                ))',
                    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                ),
                array(
                    'header'=>'Batal / Retur Penjualan',
                    'type'=>'raw', 
                    'value'=>'(!empty($data->returresep_id)) ? $data->getStatusPenjualan($data->alasanretur) : 
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
        <div class="row-fluid">
            <div class="span4">
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
                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            )); 
                        ?>
                        <?php $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($modInfoPenjualan->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label(' Sampai Dengan','tgl_akhir', array('class'=>'control-label')) ?>
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
                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($modInfoPenjualan->tgl_akhir); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::label('No. Resep','no_resep',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modInfoPenjualan,'noresep',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter','nama_dokter',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modInfoPenjualan,'pasienpegawai_id', CHtml::listData(DokterV::model()->findAll("pegawai_aktif = true ORDER BY nama_pegawai ASC"),'pegawai_id', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Resep','nama_dokter',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modInfoPenjualan,'pegawai_id', CHtml::listData(DokterV::model()->findAll("pegawai_aktif = true ORDER BY nama_pegawai ASC"),'pegawai_id', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php
                    $content = $this->renderPartial('../tips/informasiPenjualanPegawai',array(),true);
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
    <iframe src="" name="iframePenjualanResep" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end lihat penjualan resep dialog =============================
    ?>

    <?php 
    // Dialog buat Copy Resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogCopyResep',
        'options'=>array(
            'title'=>'Salin Resep',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
        ),
    ));
    ?>
    <iframe src="" name="iframeCopyResep" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end Copy Resep dialog =============================
    ?>
</div>
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

<?php 
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogReturPenjualan',
    'options'=>array(
        'title'=>'Retur Penjualan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
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

<?php 
// Dialog buat retur penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPrintPenjualan',
    'options'=>array(
        'title'=>'Print Struk',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>980,
        'minHeight'=>700,
        'resizable'=>false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('infopenjualanapotik-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReturResep" width="100%" height="700" >
</iframe>
<?php
$this->endWidget();
//========= end retur penjualan resep dialog =============================
?>
<?php $this->renderPartial($this->path_view."_jsFunctionsIndex"); ?>