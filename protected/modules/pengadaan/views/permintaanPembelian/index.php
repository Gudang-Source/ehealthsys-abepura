<div class="white-container">
    <legend class="rim2">Permintaan <b>Pembelian</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Permintaan Pembelian berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'permintaanpembelian-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($modPermintaanPembelian,'keteranganpermintaan'),
    )); 

    ?>
    <fieldset class="box" id="form-permintaanpembelian">
        <legend class="rim"><span class='judul'>Data Permintaan Pembelian </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formPermintaanPembelian', array('form'=>$form,'format'=>$format,'modPermintaanPembelian'=>$modPermintaanPembelian,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modPermintaanPenawaran'=>$modPermintaanPenawaran)); ?>
        </div>
    </fieldset>

    <?php if(!isset($_GET['sukses'])){ ?> 
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatPermintaanPembelian',array('modPermintaanPembelian'=>$modPermintaanPembelian)); ?>
        </div>
    </fieldset>
    <?php } ?>

    <div class="block-tabel">
        <h6>Tabel <b>Permintaan Pembelian</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
        <thead>
                <tr>
                    <th>No.</th>
                    <th>Asal Barang</th>
                    <th>Kategori / Nama Obat</th>
                    <th>Satuan</th>
                    <th>Jumlah Pembelian</th>
                    <th>Harga Satuan</th>
                    <th>Stok Akhir</th>
                    <th>PPN (%)</th>
                    <th>PPH (%)</th>
                    <th>Diskon (%)</th>
                    <th>Diskon Total (Rp.)</th>
                    <th>Minimal Stok</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
        </thead>
		<tbody>
			<?php
			if(count($modDetails) > 0){
				foreach($modDetails AS $i=>$modPermintaanPembelianDetail){
					echo $this->renderPartial($this->path_view.'_rowObatPermintaanPembelian',array('modPermintaanPembelian'=>$modPermintaanPembelian,'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail));
				}
			}
			?>
			<tfoot>
				<tr>
					<td colspan="12">Total</td>
					<td><?php echo CHtml::textField('total','',array('class'=>'span2 integer','style'=>'width:90px;'))?></td>
					<td></td>
				</tr>
			</tfoot>
		</tbody>
        </table>
    </fieldset>
	<?php isset($_GET['ubah'])? $modPermintaanPembelian->permintaanpembelian_id = '' : '' ; ?>
	<fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row-fluid">
			<div class="span2">
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo CHtml::label("Pegawai Mengetahui <font style = 'color:red'>*</font>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimengetahui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modPermintaanPembelian,
							'attribute' => 'pegawaimengetahui_nama',
							'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
												   dataType: "json",
												   data: {
													   term: request.term,
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 3,
								'focus' => 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								}',
								'select' => 'js:function( event, ui ) {
									$("#'.Chtml::activeId($modPermintaanPembelian, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimengetahui_nama required',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermintaanPembelian, 'pegawaimengetahui_id') . '").val(""); '
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
						));
						?>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo Chtml::label("Pegawai Menyetujui <font style = 'color:red'>*</font>", 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimenyetujui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modPermintaanPembelian,
							'attribute' => 'pegawaimenyetujui_nama',
							'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
												   dataType: "json",
												   data: {
													   term: request.term,
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 3,
								'focus' => 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								}',
								'select' => 'js:function( event, ui ) {
									$("#'.Chtml::activeId($modPermintaanPembelian, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimenyetujui_nama required',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermintaanPembelian, 'pegawaimenyetujui_id') . '").val(""); '
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
						));
						?>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if(!isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
                    echo "&nbsp;";
                }


                if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));
                    echo "&nbsp;";
                }
//                if(!isset($_GET['sukses'])){
//                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4045*
//                    echo "&nbsp;";
//                }else{
//                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
//    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4045*
//                    echo "&nbsp;";
//                }


                $content = $this->renderPartial($this->path_view.'tips/tipsPermintaanPembelian',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPermintaanPembelian'=>$modPermintaanPembelian,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modPermintaanPenawaran'=>$modPermintaanPenawaran)); ?>