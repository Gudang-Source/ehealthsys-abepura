<div class="white-container">
    <legend class="rim2">Transaksi Penerimaan <b>Bahan Makanan</b></legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gzterimabahanmakan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus' => '#',
            ));
    ?>
    <?php if(!empty($_GET['id'])){ ?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert"> x</a>
        Data Berhasil Disimpan
    </div>
    <?php } ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <?php if (count($modPengajuan) > 0) { ?>

        
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'nopengajuan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'nopengajuan', array('readonly'=>true))
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'tglpengajuanbahan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'tglpengajuanbahan', array('readonly'=>true))
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'idpegawai_mengajukan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'idpegawai_mengajukan', array('readonly'=>true, 'value'=>  PegawaiM::model()->findByPK($modPengajuan->idpegawai_mengajukan)->nama_pegawai))
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <hr />
    <?php } ?>
    <table width="100%">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($model,'pengajuanbahanmkn_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($model->Supplier, 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'sumberdanabhn',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php echo $form->dropDownListRow($model, 'sumberdanabhn', LookupM::getItems('sumberdanabahan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->hiddenField($model, 'nopenerimaanbahan', array('readonly' => true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class = "control-group">
                    <?php echo Chtml::label("No Penerimaan Bahan",'temp_no', array('class'=>'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'temp_no', array('readonly' => true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'tglterimabahan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglterimabahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglterimabahan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglterimabahan'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'tglsurjalan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglsurjalan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglsurjalan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglsurjalan'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nofaktur', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglfaktur',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglfaktur'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'tglfaktur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
				<?php echo $form->textAreaRow($model, 'keterangan_terima_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
			</td>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'totaldiscount', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo Chtml::textField('discountpersen', '', array('class' => 'span1 integer2', 'onkeyup' => 'hitungTotalDiscount();', 'onfocus' => 'hitungTotalDiscount();','maxlength' => 3)); ?> % = 
                        <?php echo $form->textField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'totaldiscount'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'biayapengiriman', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textFieldRow($model, 'biayatransportasi', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'biayapajak', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textFieldRow($model,'totalharganetto',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </table>
    <div class="block-tabel">
        <h6>Tabel Penerimaan <b>Bahan Makanan</b></h6>
        <!--<legend class="rim">Detail Bahan Makanan</legend>-->
        <?php if (count($modDetailPengajuan) < 1) { ?>
            <div class="control-group ">
                <label class="control-label" for="namaObat">Nama Bahan Makanan <font color="red"> * </font></label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('idBahan'); ?>
                    <!--                <div class="input-append" style='display:inline'>-->
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namaBahan',
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/BahanMakanan') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                            'select' => 'js:function( event, ui ) {
                                                        $("#idBahan").val(ui.item.bahanmakanan_id); 
                                                        $("#qty").val(1); 
                                                        $("#satuanbahan").val(ui.item.satuanbahan);
                                                        return false;
                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="namaObat">Jumlah</label>
                <div class="controls">
                    <?php echo CHtml::textField('qty', '', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    <?php echo CHtml::dropDownList('satuanbahan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span1')); ?>
                    <?php echo CHtml::textField('ukuran', '', array('class' => 'span2', 'placeholder' => 'Ukuran')); ?>
                    <?php echo CHtml::textField('merk', '', array('class' => 'span2', 'placeholder' => 'Merk')); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputBahanMakanan();return false;',
                        'class' => 'btn btn-primary integer2',
                        'onkeypress' => "inputBahanMakanan();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Bahan Makanan",));
                    ?>
                </div>
            </div>
        <?php } ?>
        <table class="table table-striped table-condensed" id="tableBahanMakanan">
            <thead>
                <tr>
                    <th hidden><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                    <th>No.Urut</th>
                    <th>Golongan</th>
                    <th>Jenis</th>
                    <th>Kelompok</th>
                    <th>Nama</th>
                    <th>Jumlah Persediaan</th>
                    <th hidden>Satuan</th>
                    <th>Harga Netto</th>
                    <!--<th>Harga Jual</th>-->
                    <th>Diskon</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
				
				
                if (count($modDetailPengajuan) > 0) {
                    foreach ($modDetailPengajuan as $i => $baris) {
						$persediaan = empty($baris->bahanmakanan->jmlpersediaan)?0:$baris->bahanmakanan->jmlpersediaan;
				
						/* 
						 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
						 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
						 * jmlpersediaan pada master
						 */
						$stokgizi = Yii::app()->user->getState('krngistokgizi');

						if ($stokgizi) {
							$stok = StokbahanmakananT::model()->findAllByAttributes(array(
								'bahanmakanan_id'=>$baris->bahanmakanan_id,
							));
							$tot = 0;
							foreach ($stok as $item) {
								$tot += $item->qty_current;
							}
							$persediaan = $tot;
						}
						
						
                        $modDetail = new TerimabahandetailT();
                        $modDetail['satuanbahan'] = $baris->satuanbahan;
                        $subNetto = $baris->qty_pengajuan * $baris->harganettobhn;
                        echo '<tr>
                                <td hidden>'
                        . CHtml::checkBox('checkList[' . $i . ']', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                        . CHtml::activeHiddenField($modDetail, '[0]golbahanmakanan_id', array('value' => $baris->golbahanmakanan_id))
                        . CHtml::activeHiddenField($modDetail, '[0]bahanmakanan_id', array('value' => $baris->bahanmakanan_id))
                        . CHtml::activeHiddenField($modDetail, '[0]harganettobahan', array('value' => $baris->harganettobhn))
                        . CHtml::activeHiddenField($modDetail, '[0]jmlkemasan', array('value' => $baris->jmlkemasan))
                        . CHtml::activeHiddenField($modDetail, '[0]hargajualbahan', array('value' => $baris->bahanmakanan->hargajualbahan))
                        . CHtml::activeHiddenField($modDetail, '[0]ukuran_bahanterima', array('value' => $baris->ukuranbahan))
                        . CHtml::activeHiddenField($modDetail, '[0]pengajuanbahandetail_id', array('value' => $baris->pengajuanbahandetail_id))
                        . CHtml::activeHiddenField($modDetail, '[0]merk_bahanterima', array('value' => $baris->merkbahan))
                        . '</td>
                                <td>' . CHtml::textField('noUrut[]', $i + 1, array('class' => 'noUrut span1', 'readonly' => true)) . '</td>
                                <td>' . $baris->golbahanmakanan->golbahanmakanan_nama . '</td>
                                <td>' . $baris->bahanmakanan->jenisbahanmakanan . '</td>
                                <td>' . $baris->bahanmakanan->kelbahanmakanan . '</td>
                                <td>' . $baris->bahanmakanan->namabahanmakanan . '</td>
                                <td style="text-align: right">' .MyFormatter::formatNumberForUser($persediaan)." ".$baris->satuanbahan . '</td>
                                <td hidden>' . CHtml::activeDropDownList($modDetail, '[0]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('options' => array('' . $baris->satuanbahan . '' => array('selected' => 'selected')), 'class' => 'span2 satuanbahan')) . '</td>
                                <td>' . CHtml::activeTextField($modDetail, '[0]harganettobahan', array('value'=>$baris->harganettobhn, 'class'=>'span2 integer2 harganettobahan', 'onblur'=>'hitung(this);','readonly'=>false)) . '</td>
                                
                                
                                <td>' . CHtml::activeTextField($modDetail, '[0]discount', array('value' => $baris->bahanmakanan->discount, 'class' => 'discount span1 integer2', 'onkeyup' => 'hitungTotalDiscount();')) . '</td>'.
                                '<td>' . 
								'<div class="input-append">'.
								CHtml::activeTextField($modDetail, '[0]tglkadaluarsabahan', array('readonly'=>true,'value'=>MyFormatter::formatDateTimeForUser($baris->bahanmakanan->tglkadaluarsabahan),'class'=>'tanggal dtPicker2', 'style'=>'float:left;')) . 
								'<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="icon-calendar"></i></span>'.
								'</div>'.
								'</td>    

                                <td>' . CHtml::activeTextField($modDetail, '[0]qty_terima', array('value' => $baris->qty_pengajuan, 'class' => 'span1 integer2 qty', 'onkeyup' => 'hitung(this);'))." ".$baris->satuanbahan . '</td>
                                <td>' . CHtml::TextField('[0]subNetto', MyFormatter::formatNumberForPrint($subNetto), array('value' => MyFormatter::formatNumberForPrint($subNetto), 'class' => 'subNetto span2', 'readonly' => true,'style'=>'text-align:right')) . '</td>
                                <td>' . CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')).'</td>
                                </tr>';//<td>' . $baris->bahanmakanan->hargajualbahan . '</td>
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='10'><div class='pull-right'>Total Harga Netto</div></td>
                    <td><?php echo $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer2 total_semua', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-actions">
        <?php
		if($model->isNewRecord){
			echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
		} else {
			echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled'=>true));
		}
		?>
	  <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index',array('modul_id'=>Yii::app()->session['modul_id'])) . '";}); return false;'));
        ?>
		<?php 
		if($model->isNewRecord){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"return false",'disabled'=>TRUE  ));
        }else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE  ));
        }
		
		?>
	<?php 
        $content = $this->renderPartial('../tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>

    <?php $this->endWidget(); ?>
</div>
    <?php
    $totalHarga = CHtml::activeId($model, 'totalharganetto');
    $urlBahan = $this->createUrl('getBahanMakananDariPenerimaan');

    ?>

    <?php
//========= Dialog buat cari Bahan Makanan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogBahanMakanan',
        'options' => array(
            'title' => 'Bahan Makanan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modBahanMakanan = new GZBahanMakananM('search');
    $modBahanMakanan->unsetAttributes();
    if (isset($_GET['GZBahanMakananM'])) {
        $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'gzbahanmakanan-m-grid',
        'dataProvider' => $modBahanMakanan->search(),
        'filter' => $modBahanMakanan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#idBahan\').val($data->bahanmakanan_id);
                                    $(\'#namaBahan\').val(\'$data->jenisbahanmakanan - $data->namabahanmakanan\');
                                    $(\'#satuanbahan\').val(\'$data->satuanbahan\');
                                    $(\'#qty\').val(1);
                                    $(\'#dialogBahanMakanan\').dialog(\'close\');return false;"))',
            ),
            array(
                'name' => 'golbahanmakanan_id',
                'filter' => CHtml::activeDropDownList($modBahanMakanan, 'golbahanmakanan_id', CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true'), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty'=>'-- Pilih --')),
                'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
            ),
			array(
				'name' => 'jenisbahanmakanan',
                'filter' => CHtml::activeDropDownList($modBahanMakanan, 'jenisbahanmakanan', LookupM::getItems('jenisbahanmakanan'), array('empty'=>'-- Pilih --')),
				'value' => '$data->jenisbahanmakanan',
			),
			array(
				'name' => 'kelbahanmakanan',
                'filter' => CHtml::activeDropDownList($modBahanMakanan, 'kelbahanmakanan', LookupM::getItems('kelompokbahanmakanan'), array('empty'=>'-- Pilih --')),
				'value' => '$data->kelbahanmakanan',
			),
            'namabahanmakanan',
			array(
				'name'=>'jmlpersediaan',
				'value'=>function($data) {
					/* 
					 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
					 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
					 * jmlpersediaan pada master
					 */
					$stokgizi = Yii::app()->user->getState('krngistokgizi');
					
					if ($stokgizi) {
						$stok = StokbahanmakananT::model()->findAllByAttributes(array(
							'bahanmakanan_id'=>$data->bahanmakanan_id,
						));
						$tot = 0;
						foreach ($stok as $item) {
							$tot += $item->qty_current;
						}
						return $tot." ".$data->satuanbahan;
					}
					
					return $data->jmlpersediaan." ".$data->satuanbahan;
				},
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
				'filter'=>false,
			),
			array(
				'name'=>'harganettobahan',
				'value'=>'MyFormatter::formatNumberForPrint($data->harganettobahan)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
				'filter'=>false,
			),
			array(
				'name'=>'hargajualbahan',
				'value'=>'MyFormatter::formatNumberForPrint($data->hargajualbahan)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
				'filter'=>false,
			),
            //'harganettobahan',
            //'hargajualbahan',
			array(
				'name'=>'discount',
				'value'=>'MyFormatter::formatNumberForPrint($data->discount)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
				'filter'=>false,
			),
            //'discount',
			array(
				'name'=>'tglkadaluarsabahan',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan);',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
				'filter'=>false,
			),
//        'jmlminimal',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));


    $this->endWidget();
    ?>

<?php echo $this->renderPartial('_jsFunctions', array('totalHarga'=>$totalHarga, 'urlBahan'=>$urlBahan, 'model'=>$model), true); ?>