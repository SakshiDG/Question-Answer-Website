<html>
<head>
<style>
/* 
body{ font: 14px sans-serif; text-align:center; }
 */
		
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
        	margin-right: 100px;
        }
h2{
margin: 30px;
}
table, tr {
  margin: 30px;
  width: 600px;
  padding: 50px;
  border: 1px solid black;
  border-collapse: collapse;
}
#time, #likes{
display: inline;
}
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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
		<a href="welcome.php" class="btn btn-primary btn-block">Home</a>
		<a href="user_profile.php" class="btn btn-warning btn-block">Profile</a>
    	<a href="post_question.php" class="btn btn-primary btn-block">Post a Question</a>
        <a href="topics.php"  class="btn btn-danger btn-block"> Topics  </a>
        <a href="logout.php" class="btn btn-danger btn-block">Sign Out of Your Account</a> 
    </p>
    </div>


<?php

// Initialize the session
session_start();
require_once "config.php";


if(isset($_GET['que_id'])){
$que_id = $_GET['que_id'];
$sql = "select q.user_id, q.que_id, q.que_title, q.que_text, u.user_name, u.user_id, q.time_asked, q.is_active from question q join users u on q.user_id = u.user_id where q.que_id = $que_id;";
$result = $link->query($sql);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$que_id =  $row['que_id'];
// if($row['user_id'] == $_SESSION['id'] && $row['is_active'] == 1){
// 	echo '<a href="/PDS_Project/view_question?mark_resolved='$que_id'" class="btn btn-primary">Mark Resolved</a>';
// }
// 
// if($row['is_active'] == 0){
// 	echo "<input id = 'resolved' name='resolved' type = 'button' style = 'margin-right:500px; background-color:blue; color:white'>Resolved</input>";

	$que_title = $row['que_title'];
	$que_text = $row['que_text'];
	$by = $row['user_name'];
	$time_asked = $row['time_asked'];
	echo "<form method = 'post'><h2 value = $que_id> $que_title </h2>";
	echo "<table >
			<tr>
				<td> $que_text
				<br>
				<p style='text-align:right'> By $by</p> 
				<p style='text-align:right'> on $time_asked</p>
			</td></tr>
			</table>";
}}
echo"<h2> Answers: </h2>";
$sql = "select a.ans_id, a.ans_text, u.user_name, a.time_answered, t.likes from answer a join users u on a.user_id = u.user_id  left join (select ans_id, count(ans_id) as likes from thumbs_up group by ans_id) t on a.ans_id = t.ans_id where a.que_id = $que_id order by a.time_answered desc;";
$result = $link->query($sql);

if ($result->num_rows > 0) {
echo "<table>";
while ($row = $result->fetch_assoc()) {
	$user_id = $_SESSION['id'];
	$ans_text = $row['ans_text'];
	$ans_id = $row['ans_id'];
	$by = $row['user_name'];
	$time_answered = $row['time_answered'];
	$likes = 0;
	$likes = $row['likes'];
	$sql_likes = "select * from thumbs_up where ans_id = $ans_id and user_id = $user_id;";
	$result_likes = $link->query($sql_likes);
	if($likes == null){
	$likes = 0;
	}
	if($result_likes->num_rows > 0){
		$new_id = 'thumbs_up'."$ans_id";
	echo "<tr>
				<td> $ans_text
				<br>
				<p style='text-align:right'>By $by</p> 
				<p id = 'likes' style='float:left'>$likes <button  id = '$new_id' name='thumbs_up_remove' type = 'submit' class='fa fa-thumbs-up' style='color:red' value='$ans_id'></button></p>
				<p id = 'time' style='float:right'> on $time_answered</p>  
				</td>
				</tr>
			";
	unset($result_likes);
	} else{
	$new_id = 'thumbs_up'."$ans_id";
	echo "<tr>
				<td> $ans_text
				<br>
				<p style='text-align:right'>By $by</p> 
				<p id = 'likes' style='float:left'>$likes <button id = '$new_id' name='thumbs_up' type = 'submit' class='fa fa-thumbs-up' value=$ans_id></button></p>
				<p id = 'time' style='float:right'> on $time_answered</p>  
				</td>
				</tr>
			";
	
	}
}
echo "<tr id= 'add_answer'><td> <textarea id = 'new_ans_text' name = 'new_ans_text' rows='2' cols='60' ></textarea><button class='btn btn-primary btn-sm' type='submit' name = 'post_answer'>Post Answer</button></td> </tr>";
echo "</table>";
echo "<button id = 'add_ans' type='button' onclick='addAnswer()' style='margin-left:30px'>Add Answer</button></form>";
}
else{
echo "<h3 style='margin-left:200px'>No Answers Yet!</h3>";

echo "<table><tr id= 'add_answer'><td> <textarea id = 'new_ans_text' name = 'new_ans_text' rows='2' cols='60' ></textarea><button class='btn btn-primary btn-sm' type='submit' name = 'post_answer'>Post Answer</button></td> </tr></table>";
echo "<button id = 'add_ans' type='button' onclick='addAnswer()' style='margin-left:30px'>Add Answer</button></form>";

}

}
if (isset($_POST['post_answer'])) {
	unset($_POST['post_answer']);
	$new_ans_text = $_POST['new_ans_text'];
	$user_id = $_SESSION['id'];
	$insert_ans= "Insert into answer values ((select id from (select max(ans_id) as id from answer) max_ans_id)+1, $que_id, '$new_ans_text',$user_id,sysdate(),0);";
	if($link->query($insert_ans)){
	header("Refresh:0");

	}
	else{
		echo "here" . $link->error;
	}
}

if (isset($_GET['mark_resolved'])) {
	$que_id = $_GET['mark_resolved'];
	$user_id = $_SESSION['id'];
	$sql = "update question set is_active = 0 where que_id = $que_id;";
	if($link->query($sql)){
	 header("Refresh:0");
	 header("Refresh:0");
	}
	else{
		echo $link->error;
	}
	header("Refresh:0");
	header("Refresh:0");
	unset($_POST['mark_resolved']);
}

if (isset($_POST['thumbs_up'])) {
	$ans_id = $_POST['thumbs_up'];
	$user_id = $_SESSION['id'];
	$sql = "insert into thumbs_up value($ans_id, $user_id, sysdate());";
	if($link->query($sql)){
	 header("Refresh:0");
	 header("Refresh:0");
	}
	else{
		echo $link->error;
	}
	header("Refresh:0");
	header("Refresh:0");
	unset($_POST['thumbs_up']);
}

if (isset($_POST['thumbs_up_remove'])) {
	$ans_id = $_POST['thumbs_up_remove'];
	$user_id = $_SESSION['id'];
	$sql = "delete from thumbs_up where ans_id = $ans_id and user_id=$user_id;";
	if($link->query($sql)){
	 header("Refresh:0");
	 header("Refresh:0");
	}
	else{
		echo $link->error;
	}
	header("Refresh:0");
	header("Refresh:0");
	unset($_POST['thumbs_up_remove']);
}

?>

<script>
document.getElementById("add_answer").style.visibility = "hidden";
function addAnswer() {
  document.getElementById("add_answer").style.visibility = "visible";
}
</script>
</body>
</html>

