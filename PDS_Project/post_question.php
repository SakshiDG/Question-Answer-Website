<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            border: 1px solid;
            margin: 250px;
        }

        .topic_button:focus {
            background-color: red;
        }
    </style>

</head>
<body>
<h1 class="my-5"></b>Post your Question</h1>
<form method='post' name="question_details">
    <p><b>Question Title:</b></p>
    <textarea id="question_title" name="question_title" rows="1" cols="100" placeholder="Enter your question title here." required>
</textarea><br><br>
    <p><b>Question:</b></p>
    <textarea id="question_text" name="question_text" rows="4" cols="100" placeholder="Enter your question here." required>
</textarea><br><br>
    <p><b>Choose related tag</b></p>
    <?php
    // Include config file
    $sql = "Select topic_id, topic_name from topic;";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $topic_id = $row['topic_id'];
            $topic_name = $row['topic_name'];
            $length = strlen($topic_name);
            echo "<input name = 'selected_tag' class='btn btn-primary focus--mouse selected ml-4 btn-sm' type = 'radio' value = '$topic_id' tabindex='0' size ='$length' required>$topic_name</input>";
        }
    }
    echo "<p>
     	<br><br><button class='btn btn-primary' type='submit' name = 'submit'>submit</button>
        <a href='Welcome.php' class='btn btn-warning'>back</a>
        
    </p>";
    ?>

</form>

<?php
if (isset($_POST['submit'])) {
    $question_title = $_POST['question_title'];
    $question_text = $_POST['question_text'];
    $topic_id = $_POST['selected_tag'];
    $user_id = $_SESSION['id'];
    echo '<br><br><br>';
    $id_query = "select id from (SELECT COALESCE(Max(que_id), 0) AS id 
              FROM   question) que;";
    $result = $link->query($id_query);
	while ($row = $result->fetch_assoc()) {
		$new_id = $row['id'] + 1;
		echo $new_id;
	}
    $insert_query = "INSERT INTO question 
            (que_id, 
             user_id, 
             que_title, 
             que_text, 
             topic_id, 
             time_asked, 
             is_active) 
VALUES      ($new_id, 
             $user_id, 
             '$question_title', 
             '$question_text', 
             $topic_id, 
             sysdate(), 
             1); ";
    echo $insert_query;

     if($link->query($insert_query)) {
     	echo"success";
        header("Location: http://localhost:8888/PDS_Project/view_question.php?que_id=$new_id");
    } else {
        echo "Error: " . $insert_query . "<br>" . $link->error;
    }
}

?>
</body>
</html>