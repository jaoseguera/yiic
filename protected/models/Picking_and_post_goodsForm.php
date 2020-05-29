<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Picking_and_post_goodsForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    /**
    * Declares the validation rules.
    * The rules state that username and password are required,
    * and password needs to be authenticated.
    **/
    
    public function rules()
    {
        return array(
            // array('username','email'),
            // username and password are required
            // array('username, password', 'required'),
            // rememberMe needs to be a boolean
            // array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }
	
	public function _actionSubmit($doc, $screen, $fce)
    {
	}
    
	public function _actionPostSubmit($doc, $screen, $fce)
	{
		$i_vbeln      = $_REQUEST['I_VBELN'];
		$i_vbelnLenth = count($i_vbeln);
		if($i_vbelnLenth < 10 && $i_vbeln != '')
		{
			$i_vbeln = str_pad((int) $i_vbeln, 10, 0, STR_PAD_LEFT);
		}
		else
		{
			$i_vbeln = substr($i_vbeln, -10);
		}

		$material    = $_REQUEST['MATNR'];
		$items       = $_REQUEST['POSNR'];
		$delivery_qu = $_REQUEST['LFIMG'];
		$plant       = $_REQUEST['WERKS'];

		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$importTableLIPS = array();						
		foreach($items as $key => $val)
		{
			$VBE[$i_vbeln][] = array('VBELN'=>$_REQUEST['I_VBELN'],'POSNR'=>$val,'MATNR'=>$material[$key],'LFIMG'=>floatval($delivery_qu[$key]),'WERKS'=>$plant[$key]);
			$T_LIPS = array("VBELN"=>$i_vbeln,"POSNR"=>$val,"MATNR"=>strtoupper($material[$key]),'LFIMG'=>floatval($delivery_qu[$key]));
			array_push($importTableLIPS, $T_LIPS);			
		}
		$res = $fce->invoke(['I_VBELN'=>strtoupper($i_vbeln),
							'T_LIPS'=>$importTableLIPS],$options);

		echo $res['E_MESSAGES'];
    }
}