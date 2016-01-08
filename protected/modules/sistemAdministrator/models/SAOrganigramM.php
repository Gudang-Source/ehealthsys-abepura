<?php
class SAOrganigramM extends OrganigramM
{
	public $tgl_awal,$tgl_akhir;
	public $nama_pegawai;
	public $jabatan_nama;
	public $atasan; //organigram asal
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganigramM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter;
		$criteria = new CDbCriteria();
		$criteria->with = array('pegawai','organigramasal');
		$criteria->compare('LOWER(t.organigram_kode)',  strtolower($this->organigram_kode), true);
		$criteria->compare('LOWER(t.organigram_unitkerja)',  strtolower($this->organigram_unitkerja), true);
		$criteria->compare('LOWER(t.organigram_formasi)',  strtolower($this->organigram_formasi), true);
		$criteria->compare('LOWER(t.organigramasal.pegawai.nama_pegawai)',  strtolower($this->atasan), true);
		$criteria->compare('LOWER(t.organigramasal.organigram_unitkerja)',  strtolower($this->atasan), true, "OR");
		$criteria->compare('LOWER(pegawai.nama_pegawai)',  strtolower($this->nama_pegawai), true);
		$criteria->compare('(pegawai.jabatan_id)',  ($this->jabatan_nama));
		$criteria->compare('LOWER(t.organigram_pelaksanakerja)',  strtolower($this->organigram_pelaksanakerja), true);
		$criteria->compare('DATE(t.organigram_periode)',$format->formatDateTimeForDb($this->organigram_periode));
		$criteria->compare('DATE(t.organigram_sampaidengan)',$format->formatDateTimeForDb($this->organigram_sampaidengan));
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}