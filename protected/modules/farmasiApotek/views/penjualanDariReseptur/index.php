<div class="white-container">
<?php
$sukses = isset($_GET['sukses'])?true:false;
$this->breadcrumbs=array(
	'Gfmutasioaruangan Ts'=>array('index'),
	'Create',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penjualanresep-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#FAPendaftaranT_instalasi_id',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
));?>

	<legend class="rim2">Penjualan <b>Resep Dari Reseptur</b></legend>
<?php
if(isset($_GET['sukses'])){
    if($_GET['sukses'] == 1){
        Yii::app()->user->setFlash("success","Tansaksi berhasil disimpan!");
    }
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset id="form-infopasien" class="box">
    <legend class="rim"><span class='judul'>Data Pasien </span></legend>
    <div class="row-fluid box">
        <?php $this->renderPartial('_formInfoPasien', array('form'=>$form,'modInfoRI'=>$modInfoRI)); ?>
    </div>
</fieldset>
<fieldset id="form-dataresep" class="box">
    <legend class="rim">Data Resep</legend>
    <?php $this->renderPartial('_formDataResep', array('form'=>$form,'modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); ?>
</fieldset>
<?php if($sukses){ ?>
<div class="block-tabel">
    <h6>Tabel <b>Obat Alkes</b></h6>
    <table class="items table table-striped table-condensed" id="table-obatalkespasien">
        <thead>
            <tr>
                <th>Resep</th>
                <th>R ke</th>
                <th>Kode / Nama Obat Pada Resep</th>
                <th width='180'>Kode / Nama Obat Dilayani</th>
                <th>Jumlah Pada Resep</th>
                <th>Jumlah Dilayani</th>
                <th hidden>Sumber Dana</th>
                <!--th>Satuan Kecil</th-->
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Signa</th>
                <th>Etiket</th>
                <th>Tipe Racikan</th>
            </tr>
        </thead>
        <tbody>
			<?php
            if(count($modObatAlkesPasien) > 0){
                foreach($modObatAlkesPasien AS $iii=> $modObatAlkes){
                    echo $this->renderPartial('_rowDetailOaPasien',array('modObatAlkesPasien'=>$modObatAlkes, 'modDetailReseptur'=>$modDetailReseptur,'iii'=>$iii));
                }
            }
            ?>
		</tbody>
	</table>
</div>
<?php }else{ ?>
			
<div class="block-tabel">
    <h6>Tabel <b>Obat Alkes</b></h6>
    <table class="items table table-striped table-condensed" id="table-obatalkespasien">
        <thead>
            <tr>
                <th>Resep</th>
                <th>R ke</th>
                <th>Kode / Nama Obat Pada Resep</th>
                <th width='180'>Kode / Nama Obat Dilayani</th>
                <th>Jumlah Pada Resep</th>
                <th>Jumlah Dilayani</th>
                <th hidden>Sumber Dana</th>
                <!--th>Satuan Kecil</th--!>
                <!--th>Stok</th-->
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Signa</th>
                <th>Etiket</th>
                <th>Tipe Racikan</th>
                <th>Sediaan Racikan</th>
                <th width="65" colspan="2">Tambah / Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetailReseptur) > 0){
                foreach($modDetailReseptur AS $ii=> $modDetail){
                    $modDetail->jmlstok = StokobatalkesT::getJumlahStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    echo $this->renderPartial('_rowDetail',array('modResepturDetail'=> $modDetail,'modObatAlkesPasien'=>$modObatAlkesPasien));
                }
            }
            ?>
        </tbody>
		<tfoot>
			<tr>
				<td colspan="3"></td>
				<td><strong>Takaran Resep : </strong><?php echo $form->dropDownList($modPenjualan, 'takaranresep', LookupM::getItems('takaranresep') ,array('class'=>'span1','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'ubahTakaranResep(this);')); ?></td>
				<td colspan="2"></td>
				<td style="text-align: right;"><strong>Total</strong></td>
				<td><strong>
					<?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->textField($modPenjualan, 'totalhargajual',array('class'=>'integer2','style'=>'width:60px;', 'readonly'=>'true', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				</strong></td>
				<td  colspan="4"></td>
				<td style="text-align: center;">
					<?php // echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('onclick'=>'tambahTindakan();','rel'=>'tooltip','title'=>'Klik untuk menambah obat alkes')); ?>
					<?php echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick'=>'tambahObatalkesRacikan(this,1);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat Alkes RACIKAN dengan R Baru')); ?>
				</td>
				<td >
					<?php echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick'=>'tambahObatalkes(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat Alkes NON RACIKAN dengan R Baru'));  ?>
				</td>
			</tr>
		</tfoot>
    </table>
	<div class="row-fluid">
		<div class="span4"></div>
		<div class="span4">
			<?php echo $form->hiddenField($modPenjualan, 'totharganetto',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'totaltarifservice',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'biayakonseling',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'pembulatanharga',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'jasadokterresep',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'discount',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'subsidirs',array('class'=>'integer2', 'readonly'=>'true')); ?>
			<?php echo $form->hiddenField($modPenjualan, 'iurbiaya',array('class'=>'integer2', 'readonly'=>'true')); ?>
		</div>
	</div>
</div>
		
<?php } ?>

<div class="form-actions">
		<?php
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekValiditas(); ', 'onkeypress'=>'cekValiditas();','disabled'=>$sukses)); //formSubmit(this,event)        
		?>
		<?php
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/index&reseptur_id='.$_GET['reseptur_id']), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php
				echo CHtml::Link("<i class='icon-print icon-white'></i> Print Resep Dokter",'#',array('class'=>'btn btn-info',"rel"=>"tooltip","title"=>"Klik untuk print resep dari dokter",'onclick'=>'printRecordTerakhir(\'PRINT\')'));
		?>
		<?php
		if($this->ada_penjualan){
			echo CHtml::Link("<i class='icon-print icon-white'></i> Print Salinan Resep",
				Yii::app()->controller->createUrl("PenjualanDariReseptur/CopyResep",
						array("penjualanresep_id"=>$modPenjualan->penjualanresep_id,"pasien_id"=>$modPenjualan->pasien_id)
				),
				array('class'=>'btn btn-info',
						"rel"=>"tooltip",
						"title"=>"Klik untuk print salinan resep",
						"target"=>"iframeCopyResep",
						"onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
				)
			);
		}else{
			echo CHtml::Link("<i class='icon-print icon-white'></i> Print Salinan Resep",'',array('class'=>'btn btn-info',"rel"=>"tooltip","title"=>"Tombol aktif setelah transaksi berhasil","disabled"=>true,));
		}
		?>
		<?php
			$content = $this->renderPartial($this->path_view.'tips/tipsPenjualanResepRS',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
</div>
<?php $this->endWidget(); ?>

<?php 
$urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php 
if(!isset($_GET['sukses'])){
	
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogOa',
    'options'=>array(
        'title'=>'Stok Obat & Alkes '.Yii::app()->user->getState('ruangan_nama'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo CHtml::hiddenField('tindakan_untuk',0,array('readonly'=>true));
echo CHtml::hiddenField('is_rowbaru','',array('readonly'=>true));
$modObatDialog = new FAObatalkesM('searchObatFarmasi');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM'])){
    $modObatDialog->attributes = $_GET['FAObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'filter'=>$modObatDialog,
    'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
							pilihObatalkes($data->obatalkes_id,
										\"$data->obatalkes_nama\",
										$data->StokObatRuangan,
										$data->hargajual,
										$data->harganetto,
										\"$data->obatalkes_kode\",
										$data->sumberdana_id,
										\"$data->SumberDanaNama\",
										$data->satuankecil_id,
										\"$data->SatuanKecilNama\",
										$(\"#is_rowbaru\").val()
										);
                            $(\"#dialogOa\").dialog(\"close\");
                            return false;
                ",
               ))',
        ),

        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header'=>'Tanggal Kadaluarsa',
            'name'=>'tglkadaluarsa',
            'filter'=>'',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
            'htmlOptions'=>array(
                'style'=>'text-align: right;',
            )
        ),   
        array(
            'header'=>'Stok',
            'type'=>'raw',
            'value'=>'$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
	
}

?> 

<?php 
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogCopyResep',
    'options'=>array(
        'title'=>'Salinan Resep',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>1300,
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

<?php $this->renderPartial('_jsFunctions', array('modReseptur'=>$modReseptur,'modDetailReseptur'=>$modDetailReseptur,'modPenjualan'=>$modPenjualan)); ?>
</div>