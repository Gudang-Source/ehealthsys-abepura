<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeTextField($modTindakan, '[0]kategoriTindakanNama', array('readonly'=>true,'class'=>'span1')) ?></td>
	<td><div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>date('Y-m-d H:i:s'))); ?><span class="add-on"><i class="icon-calendar"></i><i class="icon-time"></i></span></div></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'span1 required')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$modTindakan,
				'attribute'=>'[0]daftartindakanNama',	
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('DaftarTindakan').'",
								   dataType: "json",
								   data: {
									   term: request.term,
									   tipepaket_id: '.Params::TIPEPAKET_ID_NONPAKET.',
									   kelaspelayanan_id: $("#kelaspelayanan_id").val(),
									   penjamin_id: $("#penjamin_id").val(),
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
        
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]rencanatindakan_id', array('readonly'=>true,'class'=>'span1 integer')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '[0]status', array('readonly'=>true,'class'=>'span1')) ?>
    </td>
 <td>
        <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer')) ?>
        
    </td> 
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 lebar1 integer numbersOnly')) ?></td>
    <!--<td><?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer')) ?></td>-->
    <!--<td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 lebar1 integer numbersOnly')) ?></td>-->
    <td><?php echo CHtml::activeDropDownList($modTindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]persenCyto', array('readonly'=>true,'class'=>'span1')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, '[0]cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 lebar2-5')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '[0]tarifcyto_tindakan', array('readonly'=>true,'class'=>'span1 integer')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]jumlahTarif', array('readonly'=>true,'class'=>'span1 integer')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeHiddenField($modTindakan, '[0]pegawai_id', array('readonly'=>true,'class'=>'span1')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$modTindakan,
				'attribute'=>'[0]nama_pegawai',
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('AutocompleteDokter').'",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarDokter','jsFunction'=>"setDialogDokter(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
    </td>
    <td> 
      <?php echo isset($modTindakan->rencanatindakan_id) ? "Telah Di-Verifikasi" : "Belum Di-Verifikasi";	 ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]keterangantindakan', array('readonly'=>false,'class'=>'span2')) ?>
    </td>
    <td>
        <?php 
//            if(!isset($removeButton)){
//                $removeButton = false;
//            }
//            if($removeButton){
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
//                echo "<br/><br/>";
//                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
//            } else {
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
//            }
        ?>
    </td>
</tr>