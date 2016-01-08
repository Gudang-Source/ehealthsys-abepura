<div class="white-container">
    <legend class="rim2">Transaksi <b> Rencana Kebutuhan</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Rencana Kebutuhan Barang berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'rencanakebutuhan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>
    
    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim"><span class='judul'>Data Rencana Kebutuhan </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formRencanaKebutuhan', array('form'=>$form,'format'=>$format,'modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
        </div>
    </fieldset>
    
	<fieldset class="box" id="form-recomendedorder">
        <legend class="rim"><span class='judul'>Recomended Order (RO) </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formRecomendedBarang', array('form'=>$form,'format'=>$format,'modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
        </div>
    </fieldset>
	
    <?php  if(!isset($_GET['sukses'])){ ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Tambah Barang</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formBarangRencanaKebutuhan',array('modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
        </div>
    </fieldset>
    <?php } ?>

	
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Kebutuhan</b></h6>
        <table class="items table table-striped table-condensed" id="table-barang">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Asal Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan </th>
                    <th>Jumlah Permintaan</th>
                    <th>Harga</th>
                    <th>Stok Akhir</th>
                    <th>Minimal Stok</th>
					<th>Maksimal Stok</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modDetails) > 0){
                    foreach($modDetails AS $i=>$modRencanaDetailKebBarang){
                        echo $this->renderPartial($this->path_view.'_rowBarangRencanaKebutuhan',array('modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang,'modRencanaKebBarang'=>$modRencanaKebBarang));
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="9">Total</td>
                        <td><?php echo CHtml::textField('total','',array('class'=>'span2 integer','style'=>'width:90px;'))?></td>					
						<td></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>  
    <?php isset($_GET['ubah'])? $modRencanaKebBarang->rencanakebfarmasi_id = '' : '' ; ?>
	<fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row-fluid">
			<div class="span2">
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo $form->labelEx($modRencanaKebBarang, 'pegmengetahui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modRencanaKebBarang, 'pegmengetahui_id',array('readonly'=>true)); ?>
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modRencanaKebBarang,
							'attribute' => 'pegmengetahui_nama',
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
									$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimengetahui_nama',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(""); '
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
						));
						?>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group ">
					<?php echo $form->labelEx($modRencanaKebBarang, 'pegmenyetujui_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->hiddenField($modRencanaKebBarang, 'pegmenyetujui_id',array('readonly'=>true)); ?>
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modRencanaKebBarang,
							'attribute' => 'pegmenyetujui_nama',
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
									$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
							),
							'htmlOptions' => array(
								'class'=>'pegawaimenyetujui_nama',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(""); '
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
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekBarang();', 'onkeypress'=>'cekBarang();')); //formSubmit(this,event)
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
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
                    echo "&nbsp;";
                }

                $content = $this->renderPartial($this->path_view.'tips/tipsRencanaKebutuhan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
