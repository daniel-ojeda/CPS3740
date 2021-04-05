
<?php

if(isset($_COOKIE['ID'])){
	include "dbconfig.php";

	$con=mysqli_connect($server,$login,$password,$dbname)
		or die("<br>Cannot connect to DB\n");
	echo "<a href='logout.php'>User logout</a><br>";

  $cid =  $_COOKIE['ID'];

  $query="SELECT * FROM CPS3740_2020S.Money_ojedada where cid = '$cid'";
  $result=mysqli_query($con,$query);


  $i = 0;
  $b = 0;
  $z = 0;
  while($row=mysqli_fetch_array($result)) { 
    
    if(empty($_POST["delete"][$i])){
    $note[$b] = $_POST["note"][$i]; 
    $mid[$b] = $_POST["mid"][$i];
    } else {

  
      $delete[$i] = $_POST["delete"][$i];
      $query1 ="DELETE FROM CPS3740_2020S.Money_ojedada WHERE mid ='$delete[$i]'";


      $result1=mysqli_query($con,$query1);
      echo "Successfully deleted transaction code: Delete from Money_ojedada where id=".$delete[$i]."<br/>";
      --$b;
      ++$z;

    }
    ++$i;
    ++$b;
  }


  $a=0; 
  $x=0;


  $query2="SELECT * FROM CPS3740_2020S.Money_ojedada where cid = '$cid'";
  $result2=mysqli_query($con,$query2);
  while($row1=mysqli_fetch_array($result2)) {


    if($note[$a] != $row1['note']) {
      $query3 = "UPDATE CPS3740_2020S.Money_ojedada SET note = '$note[$a]' WHERE mid='$mid[$a]' AND note != '$note[$a]'";
      $result3 = mysqli_query($con,$query3);
      echo "Successfully updated transaction  $query3 <br/>";
      ++$x;
    }
    ++$a;
  }

  echo "Finish deleting $z records and updating $x transactions.";

 } else {
    echo "Please click on <a href='index.html'>Here (project home)</a> to login first!<br>";
}

?>








