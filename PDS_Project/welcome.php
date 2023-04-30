<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


if (isset($_POST["query"])) {
	// (B1) SEARCH FOR USERS
	$search_keyword = $_POST["query"];
	$sql_search = "select * from question where QUE_TITLE LIKE '%$search_keyword%' UNION select * from question where QUE_TEXT LIKE '%$search_keyword%'";     
	$results = $link->query($sql_search);
  
	// (B2) DISPLAY RESULTS
	if ($results->num_rows > 0) { 
		$url = 'welcome.php?search_keyword='.$search_keyword;
		$_SESSION["search_keyword"] = $search_keyword;
		header("location: $url");
	} 
// 	else {echo '<script>alert("No records found")</script>'; }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align:center; }
		
 		#welcome, #actions{
 			display: inline;
 		}
 		#posts {
 		
 		margin-left:300px;
 		float: left;
 		}
 		.question-summary_container{
 		width:850px;
 		padding: 50px;

 		border: 1px solid;
 		text-align:left;
 		}
        div.span2{
        	width: 250px;
        	float: right;
        	margin-right: 50px;
        }
    </style>
</head>
<body>
    <h1 id = 'welcome' class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <div id = 'actions' class="span2">
    <div class="topnav">
    <br><br>
		<form method="POST" style='border:1px solid; padding:10px'>
			<input type="text"  style='border:1px solid' name='query' placeholder='Search'/>
			<input type="submit" value="Search"  />
		</form>

	</div>
    <p>
		<br>
		<a href="welcome.php" class="btn btn-primary btn-block">Home</a><br>
		<a href="user_profile.php" class="btn btn-warning btn-block">Profile</a><br>
    	<a href="post_question.php" class="btn btn-primary btn-block">Post a Question</a><br>
        <a href="topics.php"  class="btn btn-danger btn-block"> Topics  </a>    <br>
        <a href="logout.php" class="btn btn-danger btn-block">Sign Out of Your Account</a> 
    </p>
    </div>
    <div id = 'posts'>
    <?php
    if (isset($_GET['search_keyword']))
	{
    	$search_keyword = $_GET['search_keyword'];
    	if ($search_keyword == '')
        	{echo '<script>alert("Please enter search text.")</script>'; }
    	else{
            $sql_search = "select * from question q join topic t on q.topic_id = t.topic_id join users u on q.user_id = u.user_id where q.QUE_TITLE LIKE '%$search_keyword%' or q.QUE_TEXT LIKE '%$search_keyword%' order by q.time_asked desc;";     
            $result = $link->query($sql_search);
            if($result->num_rows>0){
            	echo "<br><br><h2><b>Results</b><h2>";
            }
        }
    
	}
    elseif (isset($_GET["topic_id"])) {
        $topic_id = $_GET["topic_id"];
        $sql_search = "select * from question q join topic t on q.topic_id = t.topic_id join users u on q.user_id = u.user_id where q.topic_id = $topic_id;";     
        $result = $link->query($sql_search);
        if(isset($_GET["topic_id"])){
        	$topic_name = $_GET["topic_name"];
        		echo "<br><br><h2><b>Results for <a class='btn btn-primary  btn-sm' href='/PDS_Project/welcome.php' style='background-color:blue'>$topic_name X</a></b><h2>";
        	}
    }
    else{
    	$user_id = $_SESSION["id"];
    	$sql = "select * from question q join topic t on q.topic_id = t.topic_id join users u on q.user_id = u.user_id where q.que_id in (select q.que_id from question q join answer a on q.que_id = a.que_id where q.user_id = $user_id  or a.user_id = $user_id) and is_active = 1;";     
		$result = $link->query($sql);
		echo "<br><br><h2><b>Your Recent Activity</b><h2>";
    }
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        	$que_id = $row['que_id'];
        	$que_title = $row['que_title'];
        	$que_text = $row['que_text'];
        	$topic_id = $row['topic_id'];
        	$topic_name = $row['topic_name'];
        	$time_asked = $row['time_asked'];
        	$user_name = $row['user_name'];
        	echo "<div class='question-summary_container'>
    	<a class='question-summary_link' href='/PDS_Project/view_question.php?que_id=$que_id' style='font-size:20px'>$que_title</a>
    	<div class='question-summary_excerpt' style='font-size:20px'>$que_text</div>
    	<div class='question-summary_footer__2fK4q'>
    		<div class='question-summary_tagContainer__2hPyr'>
    			<a class='btn btn-primary  btn-sm' href='/PDS_Project/welcome.php?topic_id=$topic_id&&topic_name=$topic_name' style='background-color:blue'>$topic_name</a>
    		<div class='question-summary_userDetails'>
    			</a><div class='question-summary_info' style='text-align:right; font-size:20px'><span> On: $time_asked</span>
    			<p style='text-align:right; font-size:20px'>By: $user_name</p></div>
    	</div></div></div></div>";
        	
            }
    }
    else{
    
    echo "<div><p><b>No Records Found!</b></p></div>";
    
    }
    ?></div>
</body>
</html>