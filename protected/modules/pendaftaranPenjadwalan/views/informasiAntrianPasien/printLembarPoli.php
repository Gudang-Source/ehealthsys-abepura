DALAM PENGEMBANAGAN

<div>
    <TABLE FRAME=VOID CELLSPACING=0 COLS=4 RULES=NONE BORDER=0>
	<COLGROUP><COL WIDTH=100><COL WIDTH=45><COL WIDTH=128><COL WIDTH=86></COLGROUP>
	<TBODY>
		<TR>
			<TD COLSPAN=2 WIDTH=158 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Nama Rumah Sakit / Kelas RS</FONT></TD>
			<TD WIDTH=128 ALIGN=LEFT><FONT SIZE=1>: <?php echo Yii::app()->session['profilrs_nama'] ?></FONT></TD>
			<TD ROWSPAN=3 WIDTH=86 ALIGN=CENTER VALIGN=MIDDLE><img src="<?php echo bu()."/css/images/logo-rsud-sekarwangi_bw.jpg"; ?>" height="60" /></TD>
		</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Alamat Rumah Sakit</FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1>: <?php echo Yii::app()->session['profilrs_alamat'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Telp / Fax</FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1>: <?php echo Yii::app()->session['profilrs_notelepon'] ?> / <?php echo Yii::app()->session['profilrs_nofaksimili'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1><BR></FONT></TD>
		</TR>
		<TR>
			<TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000" COLSPAN=4 HEIGHT=17 ALIGN=RIGHT VALIGN=MIDDLE><FONT SIZE=1>Data Pasien</FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Nama Pasien</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['nama_pasien'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>No. Rekam Medis</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['no_rekam_medik'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>No. Pendaftaran</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['no_pendaftaran'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Jenis Kelamin</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['jeniskelamin_nama'] ?></FONT></TD>
			</TR>
                <TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Alamat</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['alamat_pasien'] ?></FONT></TD>
		</TR>        
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Tgl. Lahir / Umur</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo date('d M Y',strtotime($data['tanggal_lahir'])) ?> / <?php echo $data['umur'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Cara Bayar / Penjamin</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['carabayar_nama'] ?> / <?php echo $data['penjamin_nama'] ?></FONT></TD>
			</TR>
		<TR>
			<TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000" COLSPAN=4 HEIGHT=17 ALIGN=RIGHT VALIGN=MIDDLE><FONT SIZE=1>Perawatan Rawat Jalan</FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Tgl. Berkunjung</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['tgl_pendaftaran'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Polklinik Tujuan / No. Antrian</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE>: <FONT SIZE=3><?php echo $data['ruangan_nama'] ?> / <?php echo $data['no_urutantri'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Tipe Paket / Tindakan</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['tipepaket_nama'] ?> / <?php echo $data['daftartindakan_nama'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Retribusi</FONT></TD>
			<TD COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['tarif_tindakan'] ?></FONT></TD>
			</TR>
		<TR>
			<TD STYLE="border-bottom: 1px solid #000000" COLSPAN=2 HEIGHT=17 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>Dokter Pemeriksa</FONT></TD>
			<TD STYLE="border-bottom: 1px solid #000000" COLSPAN=2 ALIGN=LEFT VALIGN=MIDDLE><FONT SIZE=1>: <?php echo $data['nama_pegawai'] ?></FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=4 HEIGHT=17 ALIGN=RIGHT VALIGN=MIDDLE><FONT SIZE=1>Nama Operator</FONT></TD>
			</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1><BR></FONT></TD>
		</TR>
		<TR>
			<TD COLSPAN=2 HEIGHT=17 ALIGN=CENTER VALIGN=MIDDLE><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=LEFT><FONT SIZE=1><BR></FONT></TD>
			<TD ALIGN=CENTER><FONT SIZE=1><?php echo Yii::app()->session['pegawai_nama'] ?></FONT></TD>
		</TR>
	</TBODY>
    </TABLE>
</div>


<?php

//echo $model->nama_pasien."<br/>";
//echo $noPendaftaran."<br/>";
//echo 'Print lembar poli ttd Hasan Mudras Ganteng skalski...';

//var_dump($data);

?>
