<?php require_once("../includes/session.php"); ?>
    <?php require_once("../includes/db_connection.php"); ?>
     <?php require_once("../includes/functions.php"); ?>
	 <?php require_once("../includes/validation_function.php"); ?>
<?php 
 $Username= "";
if(isset($_POST['submit']))
{
	//validations
	  $required_fields = array("username","password");
	  validate_presences($required_fields);
	  if(empty($errors))
	  {
		  //attempt login
		 $Username=$_POST["Username"];
		 $password=$_POST["password"];
		$found_admin=attempt_login($Username,$password);
		  if($found_admin)
		  { 
         	  //success

			
			$_SESSION["admin_id"]=$found_admin["id"];
			$_SESSION["Username"]=$found_admin["Username"];
			redirect_to("admin.php");
		  else
		  {
			  //failure
			  $_SESSION["$message"]="username/password not found";
		      
		  }
	  }
	  }
}
?>
	<?php $layout_context="admin"; ?>
	<?php require_once("../includes/layout/header.php"); ?>
	
<table id="structure">
	<tr>
		<td id="navigation">
		</td>
		<td id="page">
		<?php echo message(); ?>
			  <?php  echo form_errors($errors); ?>
			<h2>login</h2>
			<form action="login.php" method="post">
				<p>Username: 
					<input type="text" name="Username" value="<?php echo htmlentities($Username); ?>" />
				</p>
				<p>Password: 
					<input type="password" name="password" value="" />
					</p>
					<input type="submit" name="submit" value="submit" />
					
			</form>
		</td>
	</tr>
</table>
 <?php include("../includes/layout/footer.php"); ?>
