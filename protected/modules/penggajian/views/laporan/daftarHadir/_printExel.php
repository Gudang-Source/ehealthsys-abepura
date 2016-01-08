
<?php
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');

    echo $this->renderPartial(
        'application.views.headerReport.headerLaporanTransaksi',
            array(
                'judulLaporan'=>false,
            )
    );
?>
<?php
      $this->widget('ext.bootstrap.widgets.BootExcelGridView',
        array(
            'id'=>'lapegawai-d-grid',
            'dataProvider'=>$model->printDetailPresensi(),
            'template'=>"{pager}\n{items}",
            'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$row+1',
                    'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
                ),
                array(
                   'header'=>'Tanggal',
                   'type'=>'raw',
                   'value'=>'date("d/m/Y", strtotime($data->datepresensi))',
                   'htmlOptions'=>array('style'=>'width:120px'),
                ),
                array(
                    'header'=>'<center>Masuk</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
            ),
        )
  );
?>