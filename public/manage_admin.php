<?php require_once("../includes/session.php"); ?>
    <?php require_once("../includes/db_connection.php"); ?>
     <?php require_once("../includes/functions.php"); ?>
	 <?php require_once("../includes/validation_function.php"); ?>
	 
	 <?php $admin_set=find_all_admins(); ?>
	 <?php $layout_context="admin"; ?>
	 <?php include("../includes/layout/header.php"); ?>
	 
	 <table id="structure">
	 
	<tr>
		<td id="navigation">
		</td>
		<br />
	  <a href="admin.php">&laquo; Main menu </a><br />
		<td id="page">
		<?php echo message(); ?>
			<h2>Manage Admins</h2>
			<table>
			<tr>
			<th style="text-align:left;width;200px;">Username</th>
			<th colspan="2" style="text-align: left;">Actions</th>
			</tr>
			<?php while($admin=mysqli_fetch_assoc($admin_set)){ ?>
			<tr>
			<td> <?php echo htmlentities($admin["Username"]); ?> 
			<br />
		   <?php echo htmlentities($admin["hashed_password"]); ?>
		   </td>
			
			<td> <a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit </a> </td>
			<td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure?');">delete</a> </td>
			</tr>
			<?php } ?>
			</table>
			
			<br/>
			<a href="new_admin.php">Add new admin</a>
			

		</td>
	</tr>
</table>
 <?php include("../includes/layout/footer.php"); ?>