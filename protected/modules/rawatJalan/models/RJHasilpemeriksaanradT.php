<?php

class RJHasilpemeriksaanradT extends HasilpemeriksaanradT
{
	public $jenispemeriksaanrad_nama,$pemeriksaanrad_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
