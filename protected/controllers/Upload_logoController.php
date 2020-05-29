<?php
class Upload_logoController extends Controller
{
	/**
	* Declares class-based actions.
	*/        
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionUpload_logo()
	{
		if(Yii::app()->user->hasState("login"))
        {
			Yii::app()->controller->renderPartial('index');
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionUpload()
    {
	
	
		if(Yii::app()->user->hasState("login"))
        {        	
		if($_REQUEST["welcome_url"]!='')
			{
			$companyid 	= Yii::app()->user->getState("company_id");  
			$client 	= Controller::companyDbconnection();
			$doc   = $client->getDoc($companyid);
			//GEZG 07/26/2018
			//Changing method for esnureing URL is reachable
			$url = $_REQUEST["welcome_url"];									
			$url = str_replace("http://", "", $url);
			$url = str_replace("https://", "", $url);					
			if (shell_exec("ping -c 1 -w 1 ". $url) != null)
			{
				
				$doc->welcome_urls= $_REQUEST["welcome_url"];
				$client->storeDoc($doc);
				$msg='<div style="color:green">URL saved successfully</div>';
			}
			else
				$msg='<div style="color:red">URL not saved. Invalid URL.</div>';
			}
			if(isset($_FILES["FileInput"]))
			{
				if($_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
				{
					$UploadDirectory	= Yii::getPathOfAlias('application.upload').DIRECTORY_SEPARATOR; //specify upload directory ends with / (slash)
					
					//check if this is an ajax request
					if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']))
						die();
					
					//Is file size is less than allowed size.
					if ($_FILES["FileInput"]["size"] > 5242880)
						die("File size is too big. File size should be less than 512KB.".$msg);
					
					//allowed file type Server side check
					$type = $_FILES['FileInput']['type'];
					switch(strtolower($type))
					{
						//allowed file types
						case 'image/bmp': 
						case 'image/png': 
						case 'image/gif': 
						case 'image/jpeg': 
						case 'image/pjpeg':
							break;
						default:
							die('Unsupported File. Only image files of type .bmp, .gif, .png, .jpeg, and .pjpeg are supported.'.$msg); //output error
					}
					
					$fileName = $_FILES["FileInput"]["name"]; // The file name
					$fileTmpLoc = $_FILES["FileInput"]["tmp_name"]; // File in the PHP tmp folder
					$fileType = $_FILES["FileInput"]["type"]; // The type of file it is
					$fileSize = $_FILES["FileInput"]["size"]; // File size in bytes
					$fileErrorMsg = $_FILES["FileInput"]["error"]; // 0 for false... and 1 for true
					$File_Ext		= substr($fileName, strrpos($fileName, '.'));
					date_default_timezone_set("America/Los_Angeles");
					$timestamp=date("mdYHis");	
						$companyid 	= Yii::app()->user->getState("company_id");                
						$client 	= Controller::companyDbconnection();
						$NewFileName=$companyid.'_'.$timestamp.$File_Ext;
						$logoPath=Yii::app()->params['logoPath'];
					if(isset($_FILES['FileInput']['tmp_name']))
					{

						if (!is_dir($logoPath)) 
							mkdir($logoPath,0777,true);           
			
						$resized_file = $logoPath."Resize_".$NewFileName;
						if(file_exists($resized_file))
							unlink($resized_file);
						
						$wmax = 175;
						$hmax = 40;

						$img = "";
						if ($File_Ext == ".gif"){ 
						  $img = imagecreatefromgif($_FILES['FileInput']['tmp_name']);
						} else if($File_Ext ==".png"){ 
						  $img = imagecreatefrompng($_FILES['FileInput']['tmp_name']);
						} else { 
						  $img = imagecreatefromjpeg($_FILES['FileInput']['tmp_name']);
						}
						$tci = imagecreatetruecolor($wmax, $hmax);
						 
						list($w_orig, $h_orig) = getimagesize($_FILES['FileInput']['tmp_name']);
						 
						imagecopyresampled($tci, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);
						imagejpeg($tci, $resized_file, 200);
	
						$doc    	= $client->getDoc($companyid);
						if(isset($doc->logo) && file_exists($doc->logo))
							unlink($doc->logo);
						$doc->logo 	= $resized_file;
						$client->storeDoc($doc);
						
						die('File "<strong>'."Resize_".$NewFileName.'</strong>" Uploaded Successfully! '.$msg);
					}
					else
						die('error uploading File! '.$msg);
				}
				else
				{
					die('Something wrong with upload! Is "upload_max_filesize" set correctly? '.$msg);
				}
			}else
			{
			die($msg);
			}
			
        }
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}