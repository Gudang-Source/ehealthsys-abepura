<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        public function checkRoles($roles)
        {
           $cek = AssignmentsK::model()->findByAttributes(array('userid'=>Yii::app()->user->id,'itemname'=>$roles));
           if(!empty ($cek)){
               return TRUE;
           }
           else{
               return FALSE;
           }
         }
       
           public function getNamaHari($tgl)
           {
                $format = new MyFormatter();

                $tanggal=trim(substr($tgl,0,-8)); //Menampilkan Tanggal Tanpa Jam
                $tanggalDB = $format->formatDateTimeForDb($tanggal);//Mengubah Tanggal inputan ke tanggal database
                $hari=date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

                 if(strtolower($hari)=='sunday')
                    {
                        $hari='Minggu';
                    }
                 else if(strtolower($hari)=='monday')
                    {
                        $hari='Senin';
                    }
                 else if(strtolower($hari)=='tuesday')
                    {
                        $hari='Selasa';
                    }
                 else if(strtolower($hari)=='wednesday')
                    {
                        $hari='Rabu';
                    }
                 else if(strtolower($hari)=='thursday')
                    {
                        $hari='Kamis';
                    }
                 else if(strtolower($hari)=='friday')
                    {
                        $hari='Jumat';
                    }
                 else if(strtolower($hari)=='saturday')
                    {
                        $hari='Sabtu';
                    }    

                 return $hari;
           }
}