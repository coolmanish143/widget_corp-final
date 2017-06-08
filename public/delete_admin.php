<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
     <?php require_once("../includes/functions.php"); ?>
<?php
$admin=find_admin_by_id($_GET["id"]);
    if(!$admin)
	{
		redirect_to("manage_admin.php");
	}
		$id=$admin["id"];
		$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
		$result = mysql_query($query, $connection);
		if ($result && mysql_affected_rows($connection) == 1) {
		    //success
	      $_SESSION["$message"]="Admin  deleted.";
			redirect_to("manage_admins.php");
		  }
		  else
		  {
			  //failure
			  $_SESSION["$message"]="Admin deletion failed";
		      redirect_to("manage_admin.php");
		  }
	
	?>

<?php
	if (isset($connection))
	{
	  mysqli_close($connection); 
	}
 ?>