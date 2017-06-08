<?php
  function redirect_to($new_location)
  {
	  header("location:" . $new_location);
	  exit;
  }
  function mysql_prep($string)
  {
	  global $connection;
	   $escaped_string=mysqli_real_escape_string($connection,$string);
	   return $escaped_string;
  }
 

 function confirm_query($result)
 {
	 if(!$result)
	 {
		 die("Database query failed.");
	 }
 }
 function form_errors($errors=array())
	{
							$output="";
							if(!empty($errors))
							{
								$output.= "<div class=\"error\">";
								$output.= "please fix the following errors:";
								$output.= "<ul>";
								foreach($errors as $key=> $errors)
								{
									$output  .=  "<li>";
									$output  .= htmlentities($errors);
									$output  .= "</li>";
								}
							        $output  .=  "</ul>";
								    $output  .= "</div>";
							}
							return $output;
	}
		
 	
  function find_all_subjects($public=true)
  {
	  global $connection;
	   $query = "select * ";
	  $query.=  "from subjects ";
	  if($public)
	  {
	  $query .=  "where visible= 1 ";
	  }
	  $query .=  "order by position asc";
	   $subject_set= mysqli_query($connection,$query);
		  confirm_query($subject_set);
		  return $subject_set;
  }
  
   function find_pages_for_subjects($subject_id,$public=true)
   {
	   
	   global $connection;
	   $safe_subject_id=mysqli_real_escape_string($connection,$subject_id);
	  
	    $query = "select * ";
	  $query.=  "from pages ";
	  
	   $query .="where subject_id ={$safe_subject_id} ";
	    if($public)
		{
	   $query .=  "and visible= 1 ";
		}
	  $query .=  "order by position asc";
	   $page_set= mysqli_query($connection,$query);
		  confirm_query($page_set);
		  return $page_set;
	   
   }
   function find_all_admins()
   {   global $connection;
	   $query = "select * ";
	  $query.=  "from admins ";
	  $query .=  "order by username asc";
	   $admin_set= mysqli_query($connection,$query);
		confirm_query($admin_set);
		  return $admin_set;
   }
   
    function find_subject_by_id($subject_id,$public=true)
	{
		global $connection;
$safe_subject_id=mysqli_real_escape_string($connection,$subject_id);
	   $query = "select * ";
	  $query.=  "from subjects ";
	  $query .=  "where id={$safe_subject_id} ";
	   if($public)
	  {
		  $query .="and visible=1";
	  }
	  $query .=  "LIMIT 1";
	   $subject_set= mysqli_query($connection,$query);
	 confirm_query($subject_set);
	
if($subject=mysqli_fetch_assoc($subject_set))
{
		  return $subject;
  
	}
	else{
		return null;
	}
	}
	 function find_page_by_id($page_id,$public=true)
	 	{
		global $connection;
 $safe_page_id=mysqli_real_escape_string($connection,$page_id);
	   $query = "select * ";
	  $query.=  "from pages ";
	  $query .=  "where id={$safe_page_id} ";
	  if($public)
	  {
		  $query .="and visible=1";
	  }
	  $query .=  "LIMIT 1";
	   $page_set= mysqli_query($connection,$query);
	 confirm_query($page_set);
	
if($page=mysqli_fetch_assoc($page_set))
{
		  return $page;
  
	}
	else{
		return null;
	}
	}
	function find_default_pages_for_subjects($subject_id)
	{	
	$page_set=find_pages_for_subjects($subject_id);
		
if($first_page=mysqli_fetch_assoc($page_set))
{
		  return $first_page;
  
	}
	else{
		return null;
	}
	}
	function find_admin_by_id($admin_id)
	{
		global $connection;
		$safe_admin_id=mysqli_real_escape_string($connection,$admin_id);
	   $query = "select * ";
	  $query.=  "from admins ";
	  $query .=  "where id= ($safe_admin_id)";
	  $query .=  "limit 1";
	   $admin_set= mysqli_query($connection,$query);
		  confirm_query($admin_set);
		  if($admin=mysqli_fetch_assoc($admin_set))
		  {
		  return $admin;
		  }
		  else{
			  return null;
		  }
	  }
	
function find_admin_by_Username($Username)
{
	global $connection;
		$safe_Username=mysqli_real_escape_string($connection,$Username);
	   $query = "select * ";
	  $query.=  "from admins ";
	  $query .=  "where Username= '{$safe_Username}' ";
	  $query .=  "limit 1";
	   $admin_set= mysqli_query($connection,$query);
		  confirm_query($admin_set);
		  if($admin=mysqli_fetch_assoc($admin_set))
		  {
		  return $admin;
		  }
		  else{
			  return null;
		  }
}	
function find_selected_page($public=false)
{
	global $current_subject;
	global $current_page;
	
	   if(isset($_GET["subject"]))
	   {
		   $current_subject=find_subject_by_id($_GET["subject"],$public);
		   if($current_subject && $public)
		   {
			   
		   $current_page=find_default_pages_for_subjects($current_subject["id"]);
	   }else
	   {
		   $current_page=null;
	   }
	   }
		elseif(isset($_GET["page"]))
		{
			
			$current_subject=null;
		   $current_page=find_page_by_id($_GET["page"],$public);
		   
		   
		}
		else
		{
			 
			 $current_subject=null;
			  $current_page=null;
		}
}	
 //navigation takeds 2 arguments
   // -the current subject array or null
   // -the current page array or null
   
   function navigation($subject_array,$page_array)
   {
	   $output =" <ul class=\"subjects\">";
       $subject_set=find_all_subjects(false);
	 while($subject = mysqli_fetch_assoc($subject_set))
	 {
            	 $output .= "<li" ;
				 if($subject_array && $subject["id"] == $subject_array["id"])
				 {
				 $output .=" class=\"selected\"";
				 }
				   $output .= ">";
	 $output .= "<a href=\"index.php?subject=";
	  $output .= urlencode($subject["id"]);
	   $output .= "\">";
	   $output .=  htmlentities($subject["menu_name"]);
	    $output .= "</a>";
		
		
	 $page_set= find_pages_for_subjects($subject["id"],false );	      
      $output .= "<ul class=\"pages\">";
		   
	 while($page= mysqli_fetch_assoc($page_set))
	 {
            	  $output .="<li" ;
				 if($page_array && $page["id"] == $page_array["id"])
				 {
				 $output .=  " class=\"selected\"";
				 }
				 $output .= ">";
	 $output .="<a href=\"manage_content.php?page=";
	 $output .= urlencode($page["id"]);
	  $output .= "\">";
	  $output .=  htmlentities($page["menu_name"]);
     $output .= "</a></li>";
	 }
	
	   mysqli_free_result($page_set);
	 
	  
	 
	 $output .=  "</ul></li>";

	 }
	
	        mysqli_free_result($subject_set);
	   $output .= "</ul>";
	   return $output;
	   
   }
     function public_navigation($subject_array,$page_array)
   {
	   $output =" <ul class=\"subjects\">";
       $subject_set=find_all_subjects();
	 while($subject = mysqli_fetch_assoc($subject_set))
	 {
            	 $output .= "<li" ;
				 if($subject_array && $subject["id"] == $subject_array["id"])
				 {
				 $output .=" class=\"selected\"";
				 }
				   $output .= ">";
	 $output .= "<a href=\"index.php?subject=";
	  $output .= urlencode($subject["id"]);
	   $output .= "\">";
	   $output .=  htmlentities($subject["menu_name"]);
	    $output .= "</a>";
		
		if($subject_array["id"]==$subject["id"] || $page_array["subject_id"]==$subject["id"])
		{
	 $page_set= find_pages_for_subjects($subject["id"]);	      
      $output .= "<ul class=\"pages\">";
		   
	 while($page= mysqli_fetch_assoc($page_set))
	 {
            	  $output .="<li" ;
				 if($page_array && $page["id"] == $page_array["id"])
				 {
				 $output .=  " class=\"selected\"";
				 }
				 $output .= ">";
	 $output .="<a href=\"index.php?page=";
	 $output .= urlencode($page["id"]);
	  $output .= "\">";
	  $output .=  htmlentities($page["menu_name"]);
     $output .= "</a></li>";
	 }
	 $output .=  "</ul>";
    mysqli_free_result($page_set);
		}
	 
	  
	 
	 
	 $output .=  "</li>";

	 }
	
	        mysqli_free_result($subject_set);
	   $output .= "</ul>";
	   return $output;
	   
   }
   function password_encrypt($password)
   { 
		 
		    $hash_format="$2y$10$";
			$salt_length=22;
		    $salt=generate_salt($salt_length);
			$format_and_salt=$hash_format.$salt;
			$hash=crypt($password,$format_and_salt);
			return $hash;
			
			
   }
	
	function generate_salt($length)
	{
		$unique_random_string=md5(uniqid(mt_rand(),true));
		$base64_string=base64_encode($unique_random_string);
		$modified_base64_string=str_replace('+','.',$base64_string);
		$salt=substr($modified_base64_string,0,$length);
		return $salt;
		
	}
	function password_check($password,$existing_hash)
	{
		$hash=crypt($password,$existing_hash);
		if($hash===$existing_hash)
		{
			return true;
		}
		else
		{
			return false;
	}
	}
	function attempt_login($username,$password)
	{
		$admin=find_admin_by_Username($username);
		if($admin)
		{
		if	(password_check($password,$admin["hashed_password"]))
		{
			return $admin;
		}
		else{
			return false;
		}
		
		}
		else{
			
			return false;
		}
	}
	function logged_in()
	{ 
	return isset($_SESSION['admin_id']);
	}
	
   function confirm_logged_in()
   {
	   if(!logged_in())
{
	redirect_to("login.php");
	
}
   }
   
?>