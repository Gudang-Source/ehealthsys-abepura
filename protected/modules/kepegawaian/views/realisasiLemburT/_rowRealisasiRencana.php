<?php 
foreach ($modRencanaLemburDetail as $i => $detail){ ?>
<tr>
	<td width="3%" style="text-align: center">
		<?php echo CHtml::activeTextField($modRealisasiLemburDetail,'[ii]nourut',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>
	<td width="15%">
		<?php echo CHtml::activeHiddenField($modRealisasiLemburDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'integer','value'=>isset($detail->pegawai_id) ? $detail->pegawai_id : "",)); ?>
		<?php $this->widget('MyJuiAutoComplete', array(
							'model'=>$modRealisasiLemburDetail,
							'attribute'=>'[ii]nomorindukpegawai',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('GetPegawai').'",
											   dataType: "json",
											   data: {
												   term_nip: request.term,
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
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPasienBadak','jsFunction'=>"setDialogPegawai(this);"),
							'htmlOptions'=>array('value'=>isset($detail->pegawai_id) ? $detail->pegawai->nomorindukpegawai : "",'placeholder'=>'Ketik NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)"),
						)); 
		?>
	</td>
	<td width="15%">
		<?php $this->widget('MyJuiAutoComplete', array(
							'model'=>$modPegawai,
							'attribute'=>'[ii]nama_pegawai',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('GetPegawai').'",
											   dataType: "json",
											   data: {
												   term_nama: request.term,
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
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPasienBadak','jsFunction'=>"setDialogPegawai(this);"),
							'htmlOptions'=>array('value'=>isset($detail->pegawai_id) ? $detail->pegawai->nama_pegawai : "",'placeholder'=>'Ketik Nama Pegawai','rel'=>'tooltip','title'=>'Ketik Nama Pegawai untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)"),
						)); 
		?>
	</td>
	<td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail,'[ii]jamMulai',array('value'=>isset($detail->tglmulai) ? substr($detail->tglmulai, 11,5)  : "",'placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'checkTime(this);')); ?></td>
	<td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail,'[ii]jamSelesai',array('value'=>isset($detail->tglselesai) ? substr($detail->tglselesai, 11,5)  : "",'placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'checkTime(this);')); ?></td>
    <td><?php echo CHtml::textArea('RealisasilemburT['.$i.']alasanlembur',isset($detail->alasanlembur) ? $detail->alasanlembur  : "",array('id'=>'RealisasilemburT_'.$i.'_alasanlembur','class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength'=>499,'readonly'=>false)); ?></td>
    <td width="6%">
        <?php 
                $removeButton = false;
            if(count($modRencanaLemburDetail > 0)){
                $removeButton = true;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-form-plus'></i>", '#', array('onclick'=>'addRow(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah pegawai')); 
//                echo "<br/><br/>";
                echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'cancelRow(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan pegawai'));
            } else {
                echo CHtml::link("<i class='icon-form-plus'></i>", '#', array('onclick'=>'addRow(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah pegawai'));
            }
        ?>
    </td>
</tr>
<?php } ?>
