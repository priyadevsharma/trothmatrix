<?php 
function output($Return=array())
{
    /*Set response header*/
    @header('Cache-Control: no-cache, must-revalidate');
    @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	@header("Access-Control-Allow-Origin: *");
	@header("Content-Type: application/json; charset=UTF-8");
    /* Final JSON response */
    exit(json_encode($Return));
    die;
}

$tag=isset($_REQUEST['tag']) ? $_REQUEST['tag'] : "";
$method=$_SERVER['REQUEST_METHOD'];
$Response=array("method"=>$method,"tag"=>$tag,"status"=>0,"message"=>"");


if(isset($_REQUEST['tag']) && $_REQUEST['tag']!="")
{
	function validateInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if($tag=="getInTouch")
	{
		$name = (!empty($_REQUEST['name'])) ? validateInput($_REQUEST['name']) : "";
		$email = (!empty($_REQUEST['email'])) ? validateInput($_REQUEST['email']) : "";
		$message_request = (!empty($_REQUEST['message'])) ? validateInput($_REQUEST['message']) : "";
		
		$subject = "New Contact Query";
		$to = "info@trothmatrix.com";
		$message = "<h2>Hi,</h2>
		<p>You have received a new contact query from the visitor. Please check the details below: <br/>
		<p> Name: $name </p>
		<p> Email: $email </p>
		<p> Message: $message_request </p>
		<p> Thanks </p> ";
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $email . "\r\n";
	
		$Response['status']=1;
		$Response['message']= "Mail Sent Successfully.";

		output($Response);
	}
	
	else
	{
		$Response['message']="Sorry! Invalid parameter passed.";
		output($Response);
	}
}
else
{
	$Response['message']="Parameter Missing.";
	output($Response);
}



?>