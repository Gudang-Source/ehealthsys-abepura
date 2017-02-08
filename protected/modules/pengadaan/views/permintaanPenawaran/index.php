<div class="white-container">
    <legend class="rim2">Transaksi <b>Permintaan Penawaran</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Permintaan Penawaran berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
      'id'=>'permintaanpenawaran-form',
      'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($modPermintaanPenawaran,'keteranganpenawaran'),
    )); ?>
    <fieldset class="box" id="form-permintaanpenawaran">
        <legend class="rim"><span class='judul'>Data Permintaan Penawaran</span></legend>
        <div>
			<?php isset($_GET['ubah'])? $modPermintaanPenawaran->permintaanpenawaran_id = '' : '' ; ?>
            <?php $this->renderPartial($this->path_view.'_formPermintaanPenawaran', array('form'=>$form,'format'=>$format,'modPermintaanPenawaran'=>$modPermintaanPenawaran,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
    <?php if (!isset($modRencanaKebFarmasi->rencanakebfarmasi_id)) { ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('form'=>$form,'format'=>$format,'modPermintaanPenawaran'=>$modPermintaanPenawaran,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
    <?php } ?>
    <div class="block-tabel">
        <h6>Tabel <b>Permintaan Penawaran</b></h6>
        <div id="table-obatalkespasien">
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>No.Urut</th>
                        <th>Kategori /<br/> Nama Obat</th>
                        <th>Asal Barang</th>
                        <th>Stok</th>
                        <th>Satuan Kecil/Besar</th>
                        <th>Jumlah Permintaan<br>(Satuan Besar)</th>
                        <th>Minimal Stok</th>
                        <th>Harga Satuan (Rp.)</th>
                        <th>Sub Total (Rp.)</th>
                        <?php echo ((!isset($_GET['sukses'])) ? "<th>Batal</th>" : ""); ?>
                    </tr>
                </thead>    
                <tbody>
                    <?php
                    if(count($modDetails) > 0){
                        foreach($modDetails AS $i=>$modPenawaranDetail){
                            echo $this->renderPartial($this->path_view.'_rowObatAlkesPasien',array('modPermintaanPenawaran'=>$modPermintaanPenawaran, 'modPenawaranDetail'=>$modPenawaranDetail,'modObatAlkes'=>$modObatAlkes));
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">Total</td>
                        <td><?php echo CHtml::textField('total','',array('class'=>'span2 integer2','style'=>'width:90px;'))?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
	<fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row-fluid">
			<div class="span2">
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo Chtml::label("Pegawai Mengetahui <font style='color:red'>*</font>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimengetahui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modPermintaanPenawaran,
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
									$("#'.Chtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimengetahui_nama  hurufs-only required',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(""); ',
                                                                'placeholder' => 'Ketik Pegawai Mengetahui'
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
						)); 
						?>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo Chtml::label("Pegawai Menyetujui <font style='color:red'>*</font>", 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimenyetujui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modPermintaanPenawaran,
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
									$("#'.Chtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimenyetujui_nama hurufs-only required',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(""); ',
                                                                'placeholder' => 'Ketik Pegawai Menyetujui'
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
                    if(!isset($_GET['sukses'])){
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                        echo "&nbsp;";
//                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4044*/
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
                        echo "&nbsp;";
//                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));  /**RND-4044*/
                    }


                    $content = $this->renderPartial($this->path_view.'tips/tipsRencanaKebutuhan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPermintaanPenawaran'=>$modPermintaanPenawaran,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>