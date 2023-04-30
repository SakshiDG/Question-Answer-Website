

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
 
    <script>
    .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 300px;
    margin: auto;
    text-align: center;
    }

    .title {
    color: grey;
    font-size: 18px;
    }

    button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    }

    a {
    text-decoration: none;
    font-size: 22px;
    color: black;
    }

    button:hover, a:hover {
    opacity: 0.7;
    }
</script>
</head>
<body>

<?php
    session_start();
    require_once "config.php";
    $user_id = $_SESSION["id"];
    $sql_search = "SELECT u.user_name,u.phone_number,u.email,u.city,u.state,u.user_profile,s.status_name as status FROM users u join status s on u.status_id = s.status_id where user_id=$user_id ";     
    $results = $link->query($sql_search);

    if ($results->num_rows > 0) { 



        while ($row = $results->fetch_assoc()) {
            $user_name = $row['user_name'];
            $phone_number = $row['phone_number'];
            $email    =$row['email'];
            $city = $row['city'];
            $state = $row['state'];
            $profile    =$row['user_profile'];
            $status    = $row['status'];

        echo "           <div class='card'> ";
        echo "                <img src='https://i.imgur.com/wvxPV9S.png' height='100' width='100'> ";
        echo "                <h1>$user_name</h1> ";
        echo "                <p class='title'>$status</p> ";
        echo "                <p>$phone_number</p> ";
        echo "                <p>$email</p> ";
        echo "                <p>$profile</p> ";
        echo "                <p>$city </p> ";
        echo "                <p>$state</p> ";
        echo "                <a href='#'><i class='fa fa-dribbble'></i></a> ";
        echo "                <a href='#'><i class='fa fa-twitter'></i></a>  ";
        echo "                <a href='#'><i class='fa fa-linkedin'></i></a> ";
        echo "                <a href='#'><i class='fa fa-facebook'></i></a> ";
        echo "                <p><button>Contact</button></p> ";
        echo "            </div>";
        

        }

        
    } 
    else {echo '<script>alert("No Record found")</script>'; }


?>
</body>