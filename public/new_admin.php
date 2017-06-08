<?php require_once("../includes/session.php"); ?>
    <?php require_once("../includes/db_connection.php"); ?>
     <?php require_once("../includes/functions.php"); ?>
	 <?php require_once("../includes/validation_function.php"); ?>
<?php if(isset($_POST['submit']))
{
	//validations
	  $required_fields = array("username","password");
	  $errors = validate_presences($required_fields);
	  
	  $fields_with_max_lengths = array("usernama" => 30);
	  $errors = validate_max_lengths($fields_with_max_lengths);
	  if(empty($errors))
	  {
		  //perform create
		  $username=mysql_prep($_POST["username"]);
	  $hashed_password=password_encrypt($_POST["password"]);
		  
		  
		  $query = " insert into admins (";
		$query .=" username,hashed_password";
		$query .= ") values (";
		$query .= "  '{$username}','{$hashed_password}'";
		$query .=")";
		
		
		$result= mysqli_query($connection,$query);
		  if($result)
		  { 
         	  //success
	      $_SESSION["$message"]="Admin created.";
			redirect_to("manage_admin.php");
		  }
		  else
		  {
			  //failure
			  $_SESSION["$message"]="Admin creation failed";
		      
		  }
	  }
	
}
else{
	//This is probably a GET request
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
			  <?php $errors=errors(); ?>
			  <?php  echo form_errors($errors); ?>
			<h2>create admin</h2>
			<form action="new_admin.php" method="post">
				<p>Username: 
					<input type="text" name="username" value="" />
				</p>
				<p>Password: 
					<input type="password" name="password" value="" />
					</p>
					<input type="submit" name="submit" value="create Admin" />
					
			</form>
			<br />
			<a href="manage_admin.php">cancel</a>
		</td>
	</tr>
</table>
 <?php include("../includes/layout/footer.php"); ?>
