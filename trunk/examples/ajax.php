<?php
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "signup")
{
	if($_POST["Username"] == "formbuilder")
		echo 'Error: Username "', $_POST["Username"], '" already exists in the system.  Please enter a new Username.';
	elseif(strlen($_POST["Password"]) <= 5)
		echo "Error: All password must be at least 6 characters in length.  Please enter a new Password.";
	elseif($_POST["Password"] != $_POST["Password2"])
		echo "Error: Password fields do not match.";
	else
		echo "Success: You're Signed Up";
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "loading")
{
	if(!empty($_POST["Email"]))
		echo "Your email address, " . $_POST["Email"] . ", has been successfully added to our mailing list.";
	else	
		echo "To join our mailing list, please submit a valid email address in the form provided below.";
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "manual")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Ajax Form Submission</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Ajax</b> - Included in this class is the ability to submit a form using ajax.  Simply set the <i>ajax</i> form attribute to 1 and you are ready to get started.  Optional parameters include 
			<i>ajaxType</i> which allows you to specify if you want to submit the form using POST or GET (defaults to POST), <i>ajaxUrl</i> which controls where the form submits data (defaults to current script), 
			<i>ajaxDataType</i> which specifies the server response format (defaults to text), and <i>ajaxCallback</i> which gives you control over what events happen once the form have successfully submitted.</p>

			<p><b>Example 1: Sign Up Form</b> - Below you will find a typical signup form with a field for a entering a username, password, and confirmation password.  In the processing section, which is viewable in this php source code, you will see that if
			the user enters "formbuilder" in the Username field, an error message will be displayed explaining that username "formbuilder" already exists in the system.  Also, if the Password field is not greater than 5 characters or the two password fields do not match, an appropriate error message will be displayed via javascript alerts.</p>
			<?php
			$form = new form("signup");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "300"),
				"ajax" => 1
			));
			$form->addHidden("cmd", "signup");
			$form->addTextbox("Username:", "Username", "", array("required" => 1));
			$form->addPassword("Password:", "Password", "", array("required" => 1, "postHTML" => '<div style="font-size: 11px;">Must By Greater Than 5 Characters</div>'));
			$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("signup");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "300"),
	"ajax" => 1
));
$form->addHidden("cmd", "signup");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1, "postHTML" => \'<div style="font-size: 11px;">Must By Greater Than 5 Characters</div>\'));
$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
$form->addButton();
$form->render();
?>') . '</pre>';
			?>

			<p><b>Example 2: Login Form</b> - This sample login form uses four ajax specific paramters, each of which are described below.
			<ul>
				<li><i>ajaxType</i> - controls submission method - GET or POST.  By default, this parameter is set to POST; however, it is set to GET in the form below.</li>
				<li><i>ajaxCallback</i> - triggers javascript function once the form has submitted.  Notice that the function is set as a string without "( )" on the end.  
				Also, a parameter, msg in this case, is automatically passed to this callback function which includes any response sent back from the web server.</li>  
				<li><i>ajaxUrl</i> - controls where form submits.  By default, this parameter is set to the current script; however, it is set to ajaxSubmission.php in the form below.</li>
				<li><i>ajaxDataType</i> - specifies the data format for any server responses.  Options include xml, html, script, json, jsonp, and text.  By default, this parameter is set to text; however, it is set to xml in the form below.
			</ul>
			
			</p><p>Use "formbuilder" as the Username and "password" as the Password to login with the form below.  Any other parameters will display an error message above the form.</p>

			<div id="messageDiv" style="color: #990000; font-weight: bold; width: 300px; text-align: center; display: none;"></div>
			<?php
			$form = new form("login");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"preventJQueryLoad" => "1",
				"tableAttributes" => array("width" => "300"),
				"ajax" => 1,
				"ajaxType" => "GET",
				"ajaxCallback" => "loginHandler",
				"ajaxUrl" => "ajax-submission.php",
				"ajaxDataType" => "xml"
			));
			$form->addHidden("cmd", "login");
			$form->addTextbox("Username:", "Username", "", array("required" => 1));
			$form->addPassword("Password:", "Password", "", array("required" => 1));
			$form->addButton();
			$form->render();
			?>
			<script type="text/javascript">
				function loginHandler(msg)
				{
					var response = msg.getElementsByTagName("response")[0];
					document.getElementById("messageDiv").innerHTML = response.getElementsByTagName("status")[0].firstChild.data + ": " + response.getElementsByTagName("message")[0].firstChild.data;
					document.getElementById("messageDiv").style.display = "block";
				}
			</script>
			<?

echo '<pre>' . htmlentities('<?php
$form = new form("login");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"preventJQueryLoad" => "1",
	"tableAttributes" => array("width" => "300"),
	"ajax" => 1,
	"ajaxType" => "GET",
	"ajaxCallback" => "loginHandler",
	"ajaxUrl" => "ajax-submission.php",
	"ajaxDataType" => "xml"
));
$form->addHidden("cmd", "login");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addButton();
$form->render();
?>
<script type="text/javascript">
	function loginHandler(msg)
	{
		var response = msg.getElementsByTagName("response")[0];
		document.getElementById("messageDiv").innerHTML = response.getElementsByTagName("status")[0].firstChild.data + ": " + response.getElementsByTagName("message")[0].firstChild.data;
		document.getElementById("messageDiv").style.display = "block";
	}
</script>
') . '</pre>';
			?>

			<p><b>Example 3: Ajax w/Loading Image & Disabled Submit Button</b> - This sample demonstrates how the <i>ajaxCallback</i> and <i>ajaxPreCallback</i> form attributes can be used to display an animated loading image to give
			users instant feedback that their data is being submitted.  The submit button will also be disabled while the form's data is being submitted.  Please note that this is just an example and your email is not being stored in 
			an actual mailing list.

			<?php
			$form = new form("loading");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"preventJQueryLoad" => "1",
				"tableAttributes" => array("width" => "300"),
				"ajax" => 1,
				"ajaxPreCallback" => "beginAjaxLoading",
				"ajaxCallback" => "endAjaxLoading",
				"emailErrorMsgFormat" => "Invalid Email Address - Please ensure you are entering a valid email address in the form provided below."
			));
			$form->addHidden("cmd", "loading");
			$form->addEmail("Email Address:", "Email");
			$form->addHTML('<div id="ajaxLoadingDiv" style="display: none; text-align: center;"><small>Your information is being submitted...</small><br/><img src="images/ajax-loader.gif" border="0"/></div>');
			$form->addButton("Submit", "submit", array("id" => "ajaxLoadingButton"));
			$form->render();
			?>
			<script type="text/javascript">
				function beginAjaxLoading()
				{
					document.getElementById("ajaxLoadingDiv").style.display = "block";
					document.getElementById("ajaxLoadingButton").disabled = true;
				}

				function endAjaxLoading(responseMsg)
				{
					alert(responseMsg);
					document.getElementById("ajaxLoadingDiv").style.display = "none";
					document.getElementById("ajaxLoadingButton").disabled = false;
				}
			</script>

<?
echo '<pre>' . htmlentities('<?php
$form = new form("loading");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"preventJQueryLoad" => "1",
	"tableAttributes" => array("width" => "300"),
	"ajax" => 1,
	"ajaxPreCallback" => "beginAjaxLoading",
	"ajaxCallback" => "endAjaxLoading",
	"emailErrorMsgFormat" => "Invalid Email Address - Please ensure you are entering a valid email address in the form provided below."
));
$form->addHidden("cmd", "loading");
$form->addEmail("Email Address:", "Email");
$form->addHTML(\'<div id="ajaxLoadingDiv" style="display: none; text-align: center;"><small>Your information is being submitted...</small><br/><img src="images/ajax-loader.gif" border="0"/></div>\');
$form->addButton("Submit", "submit", array("id" => "ajaxLoadingButton"));
$form->render();
?>
<script type="text/javascript">
	function beginAjaxLoading()
	{
		document.getElementById("ajaxLoadingDiv").style.display = "block";
		document.getElementById("ajaxLoadingButton").disabled = true;
	}

	function endAjaxLoading(responseMsg)
	{
		alert(responseMsg);
		document.getElementById("ajaxLoadingDiv").style.display = "none";
		document.getElementById("ajaxLoadingButton").disabled = false;
	}
</script>
') . '</pre>';
?>
			<p><b>Example 4: Manual Ajax Submission</b> - This sample demonstrates how you can manually call the form's existing function responsible for ajax submission and javascript validation. 
			By default, this onsubmit function will be named "formhandler_" + form's name; however, you can make use of the <i>onsubmitFunctionOverride</i> form attribute if you would like rename 
			it.  You will need to pass the form's object reference when this function is invoked.</p>  

			<?
			$form = new form("manual");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"preventJQueryLoad" => "1",
				"tableAttributes" => array("width" => "300"),
				"ajax" => 1,
				"onsubmitFunctionOverride" => "processAjaxPost"
			));
			$form->addHidden("cmd", "manual");
			$form->addCheckbox("Available Options:", "Option", "", array("Option #1", "Option #2", "Option #3"), array("onclick" => "processAjaxPost(this.form);"));
			$form->render();
			?>
			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>
	<?php
}
?>

