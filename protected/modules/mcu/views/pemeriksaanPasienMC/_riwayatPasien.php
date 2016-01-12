	<table class="items table table-striped table-bordered table-condensed" >
	 <thead>
		 <tr>
			 <th>No. Rekam Medik</th>
			 <!--<th>No. Pendaftaran</th> LNG-459 --> 
			 <th>Anamnesis</th>
			 <th>Periksa Fisik</th>
			 <th>Laboratorium</th>
			 <th>Radiologi</th>
			 <th>Treadmill</th>
			 <th>Hearing Test</th>
			 <th>Kacamata</th>
			 <th>Diagnosis</th>
			 <th>Kesimpulan dan Saran</th>
			 <th>Jantung Koroner</th>
		 </tr>

	 </thead>
	 <tbody>
		 <tr>
			 <td><?php echo $modKunjungan->pasien->no_rekam_medik; ?></td>
			 <!--<td><?php // echo $modKunjungan->no_pendaftaran; ?></td>-->
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/DetailAnamnesa",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesa", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Anamnesa")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailPeriksaFisik",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Periksa Fisik", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Periksa Fisik")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilLab",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Laboratorium", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Laboratorium")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilRad",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Radiologi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Radiologi")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailTreadmill",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Treadmill", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Treadmill")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHearingTest",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Hearing Test", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Hearing Test")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailKacamata",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Kacamata", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Kacamata")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilDiagnosa",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Diagnosis", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Diagnosis")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailKesimpulanSaran",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Kesimpulan dan Saran", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Kesimpulan dan Saran")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailJantungKoroner",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Jantung Koroner", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Jantung Koroner")); 

				 ?>
			 </td>
		 </tr>
	 </tbody>
	 <tfoot><tr>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
		 </tr></tfoot>
 </table>

   
