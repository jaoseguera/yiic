<?php
class Production_order_costingForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    public function rules()
    {
        return array(
            //array('username','email'),
            // username and password are required
            //array('username, password', 'required'),
            // rememberMe needs to be a boolean
            //array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }
    
    public function _actionSubmit($doc, $screen, $fce)
    {
		if(isset($_REQUEST['ORDER_NUMBER']))
		{
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];					
			$ORDER_NUMBER=strtoupper($_REQUEST['ORDER_NUMBER']);
			$importTableOrders = array();

			$orderLenth = count($ORDER_NUMBER);
			if($orderLenth < 12 && $ORDER_NUMBER != "") { $ORDER_NUMBER = str_pad((int) $ORDER_NUMBER, 12, 0, STR_PAD_LEFT); } else { $ORDER_NUMBER = substr($ORDER_NUMBER, -12); }
			
			$ORDERS=array("ORDER_NUMBER"=>$ORDER_NUMBER);
			array_push($importTableOrders, $ORDERS);			
			
			$res = $fce->invoke(['WORK_PROCESS_GROUP'=>'COWORK_BAPI',
								'WORK_PROCESS_MAX'=>99,
								'ORDERS'=>$importTableOrders],$options);
			
			$SalesOrder=$res['DETAIL_RETURN'];
			
			$dt=0;
			$hs="";
			
			foreach($SalesOrder as $keys)
			{
				$hs.=$keys['MESSAGE']."<br>";
				$ty=$keys['TYPE'];
				
				if($ty!='S')
				{
					$dt=1;
				}
			}
			
			if($dt==0)
			{
				?>
				<script>
					$(document).ready(function(e) {
						$('#validation input:text').val("");
					});
				</script>
				<?php
			}
			?>
			<script>
				$(document).ready(function(e) {
					jAlert('<b>SAP System Message: </b><br><?php echo $hs;?>', 'Message');
				});
			</script>
			<?php
		}

		if(isset($_REQUEST['titl']))
		{
			?>
			<script>
				$(document).ready(function() {
					parent.titl('<?php echo $_REQUEST["titl"];?>');
					parent.subtu('<?php echo $_REQUEST["tabs"];?>');
				});
			</script>
			<?php
		}
    }
    
    
}