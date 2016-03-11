<?php
require_once('db_config.php');
include('image_check.php');
ini_set("memory_limit","1000M");
ini_set("upload_max_filesize","500M");
ini_set("post_max_size","800M");
ini_set("max_input_time","6000");
ini_set("max_execution_time","6000");
$msg='';

//echo date( "d-m-Y h:i:s", strtotime( "08/09/2014 05:00" ) );
//exit;

//if($_SERVER['REQUEST_METHOD'] == "POST")
//{

	//$email_address=$_POST['email'];
	//$file_path=$_POST['file_path'];
	//$comments=$_POST['comments'];
	//$dead_line=date( "d-m-Y h:i:s", strtotime($_POST['dead_line']) );
	//$count_file=$_POST['file_count']; //uploaded file count
	//$total_file=$_POST['total_file']; //for all file seperate  with ','.
	//$device_id=$_POST['device_id']; //for all device_id
	//$device_type=$_POST['device_type']; //for device type
	//$no_of_file=$_POST['no_of_file']; //for all file count
	
	
	$email_address='sumitra.unified@gmail.com';
	$file_path='http//:google.com/username';
	$comments='This is  comment';
	$dead_line=$dead_line=date( "d-m-Y h:i:s", strtotime("08/09/2014 08:00") );
	$count_file=1; //uploaded file count
	$total_file=1; //for all file seperate  with ','.
	$device_id='8c27cff4271ed9ecda0f7facad2e9d839789a5feca539e11b5ebcde7a95b53c3'; //for all device_id
	$device_type='IOS'; //for device type
	$no_of_file=2; //for all file count
	
	$name = $_FILES['file']['name'];
	$size = $_FILES['file']['size'];
	$tmp = $_FILES['file']['tmp_name'];
	$ext = getExtension($name);
	
if(strlen($name) > 0)
	{
		
		if(in_array($ext,$valid_formats))
			{
			 
			//if($size<(1024*1024))
			//	{
					include('s3_config.php');
					//Rename image name. 
					//$actual_image_name = time().".".$ext;
					$actual_image_name = $name;
					//echo "name= ".$actual_image_name;
					//$user_email='user.upload@gmail.com/';
					$user_email=$email_address;            // email address is folder name which  created on amazon bucket
					//echo "user_email= ".$user_email;
					$folderName = $user_email.'/'.$actual_image_name;  // folder name with file.. path on s3 bucket.
					//echo "folderName= ".$folderName;
					//$s3->putObjectFile($fileTempName,"jurgens-nettuts-tutorial" ,$folderName ,S3::ACL_PUBLIC_READ );
					
					//if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
					if($s3->putObjectFile($tmp, $bucket , $folderName, S3::ACL_PUBLIC_READ) )
						{
							//$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$folderName; //full file  path
							
							$sql = "INSERT INTO `eq_upload` (`user_email`, `file`, `file_path`, `comment`,
								`deadline`,`device_id`,`upload_time`)
								VALUES ('".$user_email."', '".$actual_image_name."','".$file_path."', '".$comments."',
								'".$dead_line."','".$device_id."',NOW())";

							//echo $sql;
							$res = mysql_query($sql);
							//$msg = "S3 Upload Successful.";
							
/*-----------------------------------------------------PUSH NOTIFICATION-----------------------------------------------------------------*/
						if($count_file==1 && $device_type=='IOS')
						{
							// Put your device token here (without spaces):
							//$deviceToken = '8c27cff4271ed9ecda0f7facad2e9d839789a5feca539e11b5ebcde7a95b53c3';
							$deviceToken = $device_id;
							// Put your private key's passphrase here:
							$passphrase = '1234567890';
							
							// Put your alert message here:
							$message = 'Your '.$no_of_file.' files have been uploaded';
							
							////////////////////////////////////////////////////////////////////////////////
							
							$ctx = stream_context_create();
							stream_context_set_option($ctx, 'ssl', 'local_cert', 'EqDictationPushChat_Dev.pem');
							stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
							
							// Open a connection to the APNS server
							$fp = stream_socket_client(
								'ssl://gateway.sandbox.push.apple.com:2195', $err,
								$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
							
							if (!$fp)
								exit("Failed to connect: $err $errstr" . PHP_EOL);
							
							//echo 'Connected to APNS' . PHP_EOL;
							
							// Create the payload body
							$body['aps'] = array(
								'alert' => $message,
								'sound' => 'default'
								);
							
							// Encode the payload as JSON
							$payload = json_encode($body);
							
							// Build the binary notification
							$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
							
							// Send it to the server
							$result = fwrite($fp, $msg, strlen($msg));
							//
							//if (!$result)
							//	echo 'Message not delivered' . PHP_EOL;
							//else
							//	echo 'Message successfully delivered' . PHP_EOL;
							
							// Close the connection to the server
							fclose($fp);
						}
/*-----------------------------------------------PUSH NOTIFICATION-----------------------------------------------------------------*/

/*----------------------------------------USER MAIL -------------------------------------------------------------------*/
							if($count_file==1)
							{
								$user_to = $user_email;
								$subject = "Upload Successful";
								$body = "Your files ".$total_file." are sent to the server and you will be informed about transcripted files soon.<br/>Deadline:".$dead_line."<br/>Comments:".$comments;;
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= "From: <reshmi.unified@gmail.com>" . "\r\n";
								mail($user_to,$subject,$body,$headers);
								//$send_mail=mail($user_to,$subject,$body,$headers);
								//echo $send_mail;
							}
							
/*----------------------------------------USER MAIL END-------------------------------------------------------------------*/

/*----------------------------------------ADMIN MAIL -------------------------------------------------------------------*/
							if($count_file==1)
							{
								$admin_to = "tania.unified@gmail.com";
								$subject = "The user of ".$user_email." has uploaded files to the server.";
								$body = "The user of ".$user_email." has uploaded ".$total_file." files for transcription.<br/>Deadline:".$dead_line."<br/>Comments:".$comments;
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= "From: <reshmi.unified@gmail.com>" . "\r\n";
								mail($admin_to,$subject,$body,$headers);
								//$send_mail1=mail($admin_to,$subject,$body,$headers);
								//echo $send_mail1;
							}
							
/*----------------------------------------ADMIN MAIL END-------------------------------------------------------------------*/


							$arr=array('status'=>'1','msg'=>'S3 Upload Successful.');
							echo json_encode($arr);
							// Close the connection to the server
							//fclose($fp);
							exit;
							//$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$folderName;
							//echo "<img src='$s3file' style='max-width:400px'/><br/>";
							//echo '<b>S3 File URL:</b>'.$s3file;
						
						}
					else
						{
							//$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$folderName;
							//echo '<b>S3 File URL:</b>'.$s3file;
							$msg = "S3 Upload Fail.";
							$arr=array('status'=>'0','msg'=>'S3 Upload Fail.');
							echo json_encode($arr);
							exit;
						}
				
				
			//	}
			//else
			//$msg = "Image size Max 1 MB";
			
			}
		else
			{
				$msg = "Invalid file, please upload image file.";
				$arr=array('status'=>'0','msg'=>'Invalid file, please upload image file.');
				echo json_encode($arr);
				exit;
			}
	}
	//else
	//{
	//	$arr=array('status'=>'0','msg'=>'Please select file.');
	//	echo json_encode($arr);
	//	exit;
	//}

//}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body>
<a href='http://www.9lessons.info'>www.9lessons.info</a>
<form action="" method='post' enctype="multipart/form-data">
<h3>Upload image file here</h3><br/>
<div style='margin:10px'><input type='file' name='file'/> <input type='submit' value='Upload Image'/></div>
</form>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>
