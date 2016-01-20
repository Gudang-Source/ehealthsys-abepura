<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class = "span4">
    <div class="box2">
        <?php echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <div class='control-group'>
            <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($model,'ruangan_id'),array('class'=>'control-label required'))?>                                   
            <div class='controls'>
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RD), 'ruangan_id', 'ruangan_nama') ,
                                      array('empty'=>'-- Pilih --',
                                    'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan()",
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                    //'ajax'=>array(
                                    //      'type'=>'POST',
                                    //      'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
                                    //      'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                                    )); ?>  
                <div class="checkbox inline">
                    <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                    <?php echo $form->checkBox($model,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
                </div><?php echo CHtml::textField('max-antrian-ruangan',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Ruangan','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;',)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3', 'empty'=>'-- Pilih --')); ?>
        <span hidden><?php echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis()", 'class'=>'span3')); ?></span>
        <div class="control-group">
            <label for="PPPendaftaranT_pegawai_id" class="control-label required">
                            Dokter <span class="required">*</span>
                            <?php echo
                            CHtml::link("<i class='icon-dokpoli'></i>",
                                            'javascript:void(0)',
                                            array("rel"=>"tooltip",
                                                            "title"=>"Klik Untuk Melihat Jadwal Dokter",
                                                            "onclick"=>"setRuanganJadwalDokter(); $('#jadwalDokter').dialog('open');return true;"
                                                    ));
                            ?>
                    </label>
            <div class="controls">
                            <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'nama_pegawai',
                                            'source'=>'js: function(request, response) {
                                                                            var ruangan_id = $("#'.CHtml::activeId($model,'ruangan_id').'").val();
                                                                       $.ajax({
                                                                               url: "'.$this->createUrl('AutocompleteDokter').'",
                                                                               dataType: "json",
                                                                               data: {
                                                                                       nama_pegawai: request.term,
                                                                                       ruangan_id: ruangan_id,
                                                                               },
                                                                               success: function (data) {
                                                                                               response(data);
                                                                               }
                                                                       })
                                                                    }',
                                             'options'=>array(
                                                       'minLength' => 2,
                                                            'focus'=> 'js:function( event, ui ) {
                                                                     $(this).val( "");
                                                                     return false;
                                                             }',
                                                       'select'=>'js:function( event, ui ) {
                                                                    $(this).val(ui.item.value);
                                                                    $("#'.CHtml::activeId($model,'pegawai_id').'").val(ui.item.pegawai_id);
                                                                    $("#'.CHtml::activeId($model,'nama_pegawai').'").val(ui.item.nama_pegawai);
                                                                    setAntrianDokter();
                                                                    return false;
                                                            }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogDokter','jsFunction'=>'cekDokter()'),
                                            'htmlOptions'=>array('placeholder'=>'Ketik Nama Dokter','rel'=>'tooltip','title'=>'Ketik Nama Dokter',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur'=>"",),
                                    )); 
                ?>                       
                <?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                <?php // echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); --RND-6869 ?>
                <?php // echo CHtml::textField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); ?>
            </div>
        </div>
            <div class="control-group ">
                    <?php echo $form->labelEx($model,'carabayar_id', array('class'=>'control-label refreshable')) ?>
                    <div class="controls">
                            <?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type'=>'POST',
                                                            'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                                                            'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data);setKarcis();}',
                                                        ),
                                                        'onchange'=>'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);',
                                                        'class'=>'span3',
                            )); ?>
                    </div>
            </div>

        <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onchange'=>'setKarcis(); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        <?php echo $form->dropDownListRow($model,'keadaanmasuk', LookupM::getItems('keadaanmasuk'),array('empty'=>'-- Pilih --',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>

        <?php echo $form->dropDownListRow($model,'transportasi', LookupM::getItems('transportasi'),array('empty'=>'-- Pilih --',
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        <?php echo $form->textAreaRow($model,'keterangan_pendaftaran',array('placeholder'=>'Catatan Khusus Pendaftaran','rows'=>2, 'cols'=>50, 'class'=>'span3 ','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asuransi',
            'content'=>array(
                'content-asuransi'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi')).'<b> <span class="judulasuransi">Asuransi Baru</span> </b> &nbsp &nbsp <span class="refreshasuransi" style="display:none;">'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBaru();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk input asuransi baru')).'</span>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransi',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasien'=>$modAsuransiPasien,
                            ),true),
                    'active'=>false,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_bpjs)?'display:none':'')),
    )); ?>
    <?php echo $form->hiddenField($model,'is_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-bpjs',
            'content'=>array(
                'content-bpjs'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi',)).'<b> BPJS '.CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'resetFormBpjs();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang form bpjs.')).'</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBpjs',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modRujukanBpjs'=>$modRujukanBpjs,
                            'modAsuransiPasien'=>$modAsuransiPasienBpjs,
                            'modSep'=>$modSep,
                            ),true),
                    'active'=>$model->is_bpjs,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_bpjs)?'':'display:none')),
    )); ?>
	<?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asubadak',
            'content'=>array(
                'content-asubadak'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBadak',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                            ),true),
                    'active'=>$model->is_asubadak,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asubadak)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asudepartemen',
            'content'=>array(
                'content-asudepartemen'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Departemen </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_view.'_formAsuransiDepartemen',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                            ),true),
                    'active'=>$model->is_asudepartemen,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asudepartemen)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asupekerja',
            'content'=>array(
                'content-asupekerja'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Pekerja PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_view.'_formAsuransiPekerja',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                            'modPegawai'=>$modPegawai,
                            ),true),
                    'active'=>$model->is_asupekerja,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asupekerja)?'':'display:none')),
    )); 
	?>
</div>

<?php
    //=============================== Dialog Jadwal Dokter =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'jadwalDokter',
            'options'=>array(
                'title'=>'Jadwal Dokter Poliklinik' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modJadDok=new PPJadwaldokterM('search');
	$modJadDok->unsetAttributes();
	$modJadDok->jadwaldokter_hari = $format->getDayUser(date('w'));
	if(isset($_GET['PPJadwaldokterM'])){
		$modJadDok->attributes=$_GET['PPJadwaldokterM'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'rdjadwaldokter-m-grid',
		'dataProvider'=>$modJadDok->search(),
		'filter'=>$modJadDok,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectJadwalDokter",
								"onClick" => "
									setDokterJadwal(\"$data->pegawai_id\");

								"))',
			),
			array(
						'name'=>'pegawai_id',
						'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
						'value'=>'(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "")',
					),
			'jadwaldokter_hari',
			'jadwaldokter_buka',
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Dialog Jadwal Dokter =======================================
?>