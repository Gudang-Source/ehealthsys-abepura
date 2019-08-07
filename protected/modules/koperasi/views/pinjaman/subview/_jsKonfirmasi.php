<script type="text/javascript">

function loadKonfirmasi() {
	
	// data pegawai
	idKonTransfer("InformasipermohonanpinjamanV_nokeanggotaan", "k_nokeanggotaan");
	idKonTransfer("InformasipermohonanpinjamanV_nopermohonan", "k_nopermohonan");
	idKonTransfer("InformasipermohonanpinjamanV_nama_pegawai", "k_namaanggota");
	idKonTransfer("InformasipermohonanpinjamanV_jmlpinjaman", "k_jmlpinjaman");
	idKonTransfer("InformasipermohonanpinjamanV_namaunit", "k_unit");
	idKonTransfer("InformasipermohonanpinjamanV_appr_disetujuioleh_id", "k_disetujui");
	idKonTransfer("InformasipermohonanpinjamanV_golonganpegawai_nama", "k_golongan");
	idKonTransfer("InformasipermohonanpinjamanV_untukkeperluan", "k_pkeperluan");
	idKonTransfer("InformasipermohonanpinjamanV_tgl_lahirpegawai", "k_tglumur");
	idKonTransfer("InformasipermohonanpinjamanV_batasplafon", "k_plafon");
	idKonTransfer("InformasipermohonanpinjamanV_status_disetujui", "k_statuspermohonan");
	idKonTransfer("InformasipermohonanpinjamanV_jmltunggakanuangpinj", "k_tunggakanpinjam");
	idKonTransfer("InformasipermohonanpinjamanV_jmltunggakanbrgpinj", "k_tunggakanbarang");
	idKonTransfer("InformasipermohonanpinjamanV_jenispinjaman_permohonan", "k_jenispinjaman");
	
	// pinjaman
	idKonTransfer("PinjamanT_tglpinjaman","kp_tglpinjaman");
	idKonTransfer("PinjamanT_jatuh_tempo","kp_tgljatuhtempo");
	idKonTransfer("PinjamanT_jml_pinjaman","kp_jmlpinjaman");
	idKonTransfer("PinjamanT_jaminan_berupa","kp_jaminanberupa");
	idKonTransfer("PinjamanT_cara_bayar","kp_carabayar");
	idKonTransfer("PinjamanT_jangka_waktu_bln","kp_jangkawaktu");
	idKonTransfer("PinjamanT_jml_kali_angsur","kp_jmlangsuran");
	idKonTransfer("PinjamanT_untuk_keperluan","kp_keperluan");
	$("#kp_jasapinjam").html($("#PinjamanT_persen_jasa_pinjaman").val() + "% (" + $("#rupiah_jasa").val() + ")");
	
	// potongan
	var p = ['k_gaji', 'k_insentif', 'k_simpanan'];
	$(".checkPotongan").each(function(idx) {
		if ($(this).is(':checked')) $("#" + p[idx]).html($(".potongan").eq(idx).val());
		else $("#" + p[idx]).html("0");
	})
	
	// kas keluar
	idKonTransfer("BukitkaskeluarT_keterangan_bkk", "bkk_keterangan");
	idKonTransfer("jumlah_pinjaman", "bkk_jmlpinjaman");
	idKonTransfer("PinjamanT_biaya_administrasi", "bkk_admin");
	idKonTransfer("PinjamanT_biaya_materai", "bkk_materai");
	idKonTransfer("biaya_provisi", "bkk_provisi");
	idKonTransfer("BukitkaskeluarT_jmlkaskeluar", "bkk_kaskeluar");
	
	$("#bkk_asuransi").html($("#biaya_asuransi").val() + " ( " + $("#premiasuransi").val() + "&#8240 )");
	
	// persetujuan
	idKonTransfer("BukitkaskeluarT_preparedby", "per_dibuat");
	idKonTransfer("BukitkaskeluarT_reviewedby", "per_diperiksa");
	idKonTransfer("BukitkaskeluarT_approvedby", "per_disetujui");
	idKonTransfer("BukitkaskeluarT_prepareddate", "per_dibuattgl");
	idKonTransfer("BukitkaskeluarT_revieweddate", "per_diperiksatgl");
	idKonTransfer("BukitkaskeluarT_approveddate", "per_disetujuitgl");
}

function idKonTransfer(id, tgtId) {
	$("#" + tgtId).html($("#" + id).val());
}

</script>