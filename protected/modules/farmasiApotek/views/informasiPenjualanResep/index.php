<div class="white-container">
    <legend class="rim2">Informasi Penjualan <b>Resep & Bebas</b></legend>
    <?php
    $this->widget('bootstrap.widgets.BootAlert');

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#search').submit(function(){
             $('#informasipenjualanresep-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'search',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($modInfoPenjualan,'no_rekam_medik'),
            'method'=>'get',
            'htmlOptions'=>array(),
    ));
    ?>
    <div class="block-tabel">
        <h6>Tabel Penjualan <b>Resep & Bebas</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'informasipenjualanresep-grid',
                'dataProvider'=>$modInfoPenjualan->searchInfoJualResep(),
        //        'filter'=>$modInfo,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'name'=>'noantrian',
                        'header'=>'No. Antrian <br>/ Panggil Antrian',
                        'type'=>'raw',
                        'value'=>'(empty($data->noantrian) ? "Tanpa Antrian" : $data->racikanantrian_singkatan."-".$data->noantrian."<br>".(($data->panggilantrian == true) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->penjualanresep_id\",\"$data->antrianfarmasi_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))))',
                    ),
                    array(
                        'header'=>'Tanggal Penjualan/<br/>No Resep',
                        'type'=>'raw',
                        'value'=>'$data->tglpenjualan."/<br/>".$data->noresep',
                    ), /*
                    array(
                        'header'=>'No. Resep',
                        'type'=>'raw',
                        'value'=>'$data->noresep',
                    ), */
                    array(
                        'header'=>'Jenis Penjualan',
                        'type'=>'raw',
                        'value'=>'$data->jenispenjualan',
                    ),
                    array(
                        'header'=>'No. Rekam Medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Jenis Kelamin /<br/>Umur',
                        'type'=>'raw',
                        'value'=>'"$data->jeniskelamin"."<br/>"."$data->umur"',
                    ),
                    array(
                        'header'=>'Jenis Kasus Penyakit',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                            return !empty($p)?(!empty($p->jeniskasuspenyakit_id)?$p->jeniskasuspenyakit->jeniskasuspenyakit_nama:"-"):"-";
                            //return (!empty($p)?$p->jeniskasuspenyakit->jeniskasuspenyakit_nama:"-");
                        }
                    ),
                    array(
                        'header'=>'Cara Bayar/<br/>Penjamin',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                    ),
                    /*
                    array(
                        'header'=>'Alamat',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
                    ), */   
                    array(
                        'header'=>'Dokter/<br/>Ruangan',
                        'type'=>'raw',
                        'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama."/<br>".$data->ruanganasal_nama',
                    ), 
                    array(
                        'header'=>'Status Periksa',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                            return !empty($pd)?$pd->statusperiksa:"-";
                        },
                    ),
                            
                            /*
                    array(
                        'header'=>'Panggil Antrian',
                        'type'=>'raw',
                        'value'=>'',
                    ), */
                    array(
                        'header'=>'Ubah',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align: left;'),
                        'value'=>'(!empty($data->NomorResepSudahBayar) ? "Pasien Sudah Bayar" : CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl((($data->jenispenjualan == Params::JENISPENJUALAN_RESEP) ? "InformasiPenjualanResep/ubahPenjualanResep" : (($data->jenispenjualan == Params::JENISPENJUALAN_RESEP) ? "InformasiPenjualanResep/ubahPenjualanResep" : "InformasiPenjualanResep/ubahPenjualanResep" )),array("idPenjualan"=>$data->penjualanresep_id)),
                                array("class"=>"", 
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk lihat ubah penjualan",
                                )))',
                    ),
                    array(
                        'header'=>'Detail Penjualan',
                        'type'=>'raw', 
                        'value'=>'
                                ($data->jenispenjualan != Params::JENISPENJUALAN_RESEP) ?
                                    CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("penjualanBebas/Print",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                        array("class"=>"", 
                                              "target"=>"iframePenjualanResep",
                                              "onclick"=>"$(\"#urlId\").val($data->penjualanresep_id);$(\"#urlPrintDetail\").val(\"'.Yii::app()->controller->createUrl("penjualanBebas/Print").'\");$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk lihat detail penjualan",
                                        )) : 
                                    CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("penjualanResepRS/print",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                        array("class"=>"",
                                              "target"=>"iframePenjualanResep",
                                              "onclick"=>"$(\"#urlId\").val($data->penjualanresep_id);$(\"#urlPrintDetail\").val(\"'.Yii::app()->controller->createUrl("penjualanResepRS/print").'\");$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk lihat detail penjualan",
                                        ))    
                                    ',
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                    ),
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
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
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
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($modInfoPenjualan->tgl_akhir); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modInfoPenjualan,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbersOnly','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($modInfoPenjualan,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php 
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nourut',
                    ));
                    foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                            'carabayar_id'=>$item->carabayar_id,
                            'penjamin_aktif'=>true,
                       ));
                       if (empty($penjamins)) unset($carabayar[$idx]);
                    }
                    $penjamin = PenjaminpasienM::model()->findAll(array(
                        'condition'=>'penjamin_aktif = true',
                        'order'=>'penjamin_nama',
                    ));
                    echo $form->dropDownListRow($modInfoPenjualan,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                        'empty'=>'-- Pilih --',
                        'class'=>'span3', 
                        'ajax' => array('type'=>'POST',
                            'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modInfoPenjualan))), 
                            'success'=>'function(data){$("#'.CHtml::activeId($modInfoPenjualan, "penjamin_id").'").html(data); }',
                        ),
                     ));
                    echo $form->dropDownListRow($modInfoPenjualan,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Penjualan','jenispenjualan',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modInfoPenjualan,'jenispenjualan', $modInfoPenjualan->listJenisPenjualan(),array('empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($modInfoPenjualan,'jenispenjualan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Resep','no_resep',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modInfoPenjualan,'noresep',array('placeholder'=>'Ketik No. Resep','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modInfoPenjualan,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --')); ?>
                    <?php
                    $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                        'instalasi_id'=>array(2, 3, 4),
                    ), array(
                        'order'=>'nama_pegawai asc',
                    )), 'pegawai_id', 'namaLengkap');
                    
                    echo $form->dropDownListRow($modInfoPenjualan, 'pegawai_id', $pegawai, array(
                        'empty'=>'-- Pilih --',
                    ));
                    
                    ?>
                    <?php echo $form->dropDownListRow($modInfoPenjualan, 'ruanganasal_nama', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id'=>array(2, 3, 4),
                            'ruangan_aktif'=>true,
                        ), array(
                            'order'=>'instalasi_id, ruangan_nama asc'
                        )), 'ruangan_nama', 'ruangan_nama'), array('empty'=>'-- Pilih --')); 
                    ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php  
                    $content = $this->renderPartial('../tips/informasi_pencarian',array(),true);
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
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
        ),
    ));
    ?>
    <iframe src="" name="iframePenjualanResep" width="100%" height="550" >
    </iframe>
    <?php
    echo CHtml::hiddenField('urlId', '', array());
    echo CHtml::hiddenField('urlPrintDetail', '', array());
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDetail(\'PRINT\')'))."&nbsp&nbsp";
    $this->endWidget();
    //========= end lihat penjualan resep dialog =============================
    ?>
    <script type="text/javascript">
    function printDetail(caraPrint){
        url = $("#urlPrintDetail").val();
        id = $("#urlId").val();
        window.open(url+"&penjualanresep_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
    </script>
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