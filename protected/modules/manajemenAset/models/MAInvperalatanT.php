
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvperalatanT extends InvperalatanT
{
    public $barang_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
