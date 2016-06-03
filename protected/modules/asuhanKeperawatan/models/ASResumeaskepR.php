<?php
class ASResumeaskepR extends ResumeaskepR
{
	public $diagnosakep_nama,$diagnosakep_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumeaskep_id' => 'Resumeaskep',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'noresume' => 'No. Resume',
			'tglresume' => 'Tgl. Resume',
			'keluhanutamamasuk' => 'Keluhan',
			'keadaanumummasuk' => 'Kesadaran',
			'gcs_eye' => 'Eye',
			'gcs_motorik' => 'Motorik',
			'gcs_verbal' => 'Verbal',
			'gcs_hasil' => 'Hasil',
			'tekanandarahmasuk' => 'Tekanan Darah',
			'detaknadimasuk' => 'Detak Nadi',
			'suhutubuhmasuk' => 'Suhu Tubuh',
			'pernapasanmasuk' => 'Pernapasan',
			'diagnosakeperawatan' => 'Diagnosa Keperawatan',
			'tindakankeperawatan' => 'Tindakan Keperawatan',
			'keluhanakhir' => 'Keluhan',
			'keadaanumumakhir' => 'Keadaan Umum',
			'tekanandarahakhir' => 'Tekanan Darah',
			'detaknadiakhir' => 'Detak Nadi',
			'suhutubuhakhir' => 'Suhu Tubuh',
			'pernapasanakhir' => 'Pernapasan',
			'namaperawat' => 'Nama Perawat',
			'tglmasukrs' => 'Tgl. Masuk RS',
			'tglkeluarrs' => 'Tgl. Keluar RS',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}
}