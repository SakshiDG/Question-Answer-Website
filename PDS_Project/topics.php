<?php
    session_start();
    require_once "config.php";

    $sql_search = "SELECT t.topic_id as topic_id,t.topic_name as topic_name,Count(q.que_id) as number_of_questions FROM   topic t LEFT JOIN question q ON t.topic_id = q.topic_id GROUP  BY t.topic_id,t.topic_name ";     
    $results = $link->query($sql_search);

    if ($results->num_rows > 0) { 


        while ($row = $results->fetch_assoc()) {
                            $topic_id = $row['topic_id'];
                            $topic_name = $row['topic_name'];
                            $no_ques    =$row['number_of_questions'];
                            
//                              echo "<a id = 'tag' href='/PDS_Project/welcome.php?topic_id=$topic_id' class='button' style='vertical-align:middle'><span>$topic_name</span> </a><p id='no_que'> X $no_ques</p><br>";
                             echo "<a href='/PDS_Project/welcome.php?topic_id=$topic_id&&topic_name=$topic_name'><button style='background-color:blue; color:white'>$topic_name</button></a><p id='no_que'> X $no_ques</p><br>";
                        }









        
    } 
    else {echo '<script>alert("No Record found")</script>'; }



?>
<style>

#tag, #no_que{
display: inline;

}

.button {
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 25px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

</style>