<?php
    /**
     * IndexForm class.
     * IndexForm is the data structure for keeping
     * user login form data. It is used by the 'login' action of 'SiteController'.
     **/
class Material_availabilityForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     **/

    public function _actionSubmit($doc, $screen, $fce)
    {
        $material = $_REQUEST['I_MATNR'];
        $cusLenth = count($material);
        if($cusLenth < 18 && $material != "" && is_numeric($material)) {
            $material = str_pad($material, 18, 0, STR_PAD_LEFT);
        }

        if(isset($_REQUEST['PLANT_FROM']))
            $plant_from = ($_REQUEST['PLANT_FROM']!=null?$_REQUEST['PLANT_FROM']:"");
        else
            $plant_from = "";
        if(isset($_REQUEST['PLANT_TO']))
            $plant_to = ($_REQUEST['PLANT_TO']?$_REQUEST['PLANT_TO']:"");
        else
            $plant_to = "";

        $param ="";
        $importTablePLANT = array();
        if($plant_from!="" && $plant_to=="")
            $param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$plant_from,'HIGH'=>"");
        elseif($plant_from!="" && $plant_to!="")
            $param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$plant_from,'HIGH'=>$plant_to);
        if($param != ""){        
            array_push($importTablePLANT, $param);
        }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_MATNR"=>$material,
                            "I_PLANT_RANGE"=>$importTablePLANT],$options);
        
        $SalesOrder = $res['ET_DATA_LINE'];
        
        $res_msg=$res['ET_MESSAGES'];
        $s_msg = "";
        foreach($res_msg as $msg) {
                $type=$msg['TYPE'];
                $s_msg .= $msg['MESSAGE']."<br>";
        }
        if($type!=""){
            echo $s_msg;
            echo "@".$type."@";
        }


        $ids=1;
        $table_labels = "WERKS,LGORT,LABST,SPEME,UMLME";
        $labels       = "WERKS,LGORT,LABST,SPEME,UMLME";
        $tableField1 = $screen.'_material_availability';
        if(isset($doc->customize->$tableField1->Table_order))
        {
            $labels=$doc->customize->$tableField1->Table_order;
        }
        $exps1 = explode(',',$table_labels);
        $exp   = explode(',',$labels);
		if(count($exp>0))
			$_SESSION['table_today_material_availability_count']=count($exp)-1;
		else
			$_SESSION['table_today_material_availability_count']=11;
        if(count($exp)<11)
        {
            for($j=count($exp)-1;$j<count($exps1);$j++)
            {
                $exp[$j]=$exps1[$j];
            }
        }
        foreach($SalesOrder as $keys=>$value)
        {
            $order_t = array($exp[0]=>$value[$exp[0]],$exp[1]=>$value[$exp[1]],$exp[2]=>$value[$exp[2]],
                $exp[3]=>$value[$exp[3]],$exp[4]=>$value[$exp[4]]);
            unset($value[$exp[0]], $value[$exp[1]], $value[$exp[2]], $value[$exp[3]], $value[$exp[4]]);
            $today = $value;
            $SalesOrder1[$ids] = array_merge((array) $order_t, (array) $today);
            $ids++;
        }
        //................................................................................

        $_SESSION['table_today_material_availability'] = $SalesOrder1;
        $rowsag1 = count($SalesOrder);

    }
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "WERKS,LGORT,LABST,SPEME,UMLME,";
            $labels_inf        = "WERKS,LGORT,LABST,SPEME,UMLME,";
		$tableField1  = $screen.'_material_availability';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)>0)
			$c_c=count($exp)-1;
		else
			$c_c=10;
		$_SESSION['table_today_material_availability_count']=$c_c; 	
		return $c_c;	
	}
}