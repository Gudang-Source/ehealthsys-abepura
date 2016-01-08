<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lihat-detail-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<div><br/><table class="table-condensed">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo $form->uneditableRow($modRealisasiLembur,'tglrealisasi', array('class'=>'span3')); ?>
            </div>
            <div class="control-group">
                <?php echo $form->uneditableRow($modRealisasiLembur,'norealisasi',array('class'=>'span3')); ?>
                </div>
            </div>
        </td>
        <td width="50%">
            <div class="control-group">
                <?php $modRealisasiLembur->mengetahui_nama = $modRealisasiLembur->pegawaimengetahui->nama_pegawai; ?>
                <?php echo $form->uneditableRow($modRealisasiLembur,  'mengetahui_nama',array('class'=>'span3')); ?>
            </div>
            <div class="control-group">
                <?php $modRealisasiLembur->menyetujui_nama = $modRealisasiLembur->pegawaimenyetujui->nama_pegawai; ?>
                <?php echo $form->uneditableRow($modRealisasiLembur,  'menyetujui_nama',array('class'=>'span3')); ?>
            </div>
        </td>
    </tr>
</table></div>


<table id="tabelKaryawanLembur" class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th style="text-align: center;">No.</th>
        <th style="text-align: center;">No. Induk Pegawai</th>
        <th style="text-align: center;">Nama Pegawai</th>
        <!--<th style="text-align: center;">Departemen</th>-->
        <th style="text-align: center;">Jam Mulai</th>
        <th style="text-align: center;">Jam Selesai</th>
        <th style="text-align: center;">Alasan Lembur</th>
        
    </tr>
    </thead>
    <tbody>
        <?php                    
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
             foreach ($modDetail as $key => $detail) {
                    $modDetail[$key]->jamMulai = date('H:i', strtotime($modDetail[$key]->tglmulai));
                    $modDetail[$key]->jamSelesai = date('H:i', strtotime($modDetail[$key]->tglselesai));
                    $tr.="<tr>
                       <td>". CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE))."</td>
                       <td>".$modDetail[$key]->pegawai->nomorindukpegawai."</td>
                       <td>".$modDetail[$key]->pegawai->nama_pegawai."</td>
                       
                       <td style='text-align:center;'>".$modDetail[$key]->jamMulai."</td>
                       <td style='text-align:center;'>".$modDetail[$key]->jamSelesai."</td>
                       <td>".$modDetail[$key]->alasanlembur."</td>
                       </tr>   
                   "; //<td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                    
             }
             echo $tr;
        ?>
    </tbody>
</table>
<table class="table-condensed">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo $form->labelEx($modRealisasiLembur, 'keterangan', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modRealisasiLembur, 'keterangan', array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
        <td width="50%">
            <div class="control-group">
                <?php $modRealisasiLembur->pemberitugas_nama = $modRealisasiLembur->pemberitugas->nama_pegawai; ?>
                <?php echo $form->uneditableRow($modRealisasiLembur,  'pemberitugas_nama',array('class'=>'span3')); ?>
            </div>
        </td>
    </tr>    

</table>
<div class="form-actions">
        <?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
		echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
		?>	
	</div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&norealisasi='.$modRealisasiLembur->norealisasi);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#realisasi-lembur-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  

?>
<?php $this->endWidget(); ?>


