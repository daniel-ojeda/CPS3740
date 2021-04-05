
<?php



if(isset($_COOKIE['ID'])){
	include "dbconfig.php";
	$balance = $_POST['balance'];
	$sourceID = $_POST['sourceID'];
	$amount = $_POST['amount'];
	$code = $_POST['code'];
	$note = $_POST['note'];
	$type = $_POST['type'];
	$cid =  $_COOKIE['ID'];
	$mydatetime = date("Y-m-d H:i:s");

	
	$con=mysqli_connect($server,$login,$password,$dbname)
		or die("<br>Cannot connect to DB\n");
	echo "<a href='logout.php'>User logout</a><br>";

	$query1 = "SELECT code from CPS3740_2020S.Money_ojedada where code = '$code'";
	$result1 = mysqli_query($con,$query1);
	
	$query2 = "SELECT sum(amount) as amount FROM CPS3740_2020S.Money_ojedada where cid = '$cid'"; 
	$result2 = mysqli_query($con,$query2);
	if(mysqli_num_rows($result2) > 0) {
		$sumAmount = mysqli_fetch_array($result2);
		     	
	}

	if (!is_numeric($amount)) {
		echo "Not numeric";
	}
    else if($amount <= 0) {
    	echo "Please enter Positive amount.";
    } else if (empty($amount)) {
    	echo "Please enter an amount.";
	} else if($type == '') {
    	echo "Please select deposit or withdraw.";
    } else if($sourceID == '') {
		echo "Please select a source.";
	} else if(mysqli_num_rows($result1) > 0){
		echo "Transaction code ".$code."  already exists.";
    } else if($type=='W'&& $amount > $sumAmount['amount']) {
     	echo "<font color=red>The balance: $".$sumAmount['amount']." is less than the withdraw amount: $".$amount.". </font>";
    } else if ($type=='W') {
    	$amount=$amount*(-1);
     	$query3 = "INSERT INTO CPS3740_2020S.Money_ojedada (code, cid, sid, type, amount, mydatetime, note) VALUES ('$code', '$cid', '$sourceID', '$type', '$amount', '$mydatetime', '$note')";
     	$result3 = mysqli_query($con, $query3);

     	if ($result3) {
     		echo "The transaction has been successfully added.<br>";
			$query4 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$cid'";
			$result4 = mysqli_query($con,$query4);
	        if(mysqli_num_rows($result4)>0) {
	        	while($row = mysqli_fetch_array($result4)){
	        		$newBalance = $row['balance'];
			     	echo "New balance:<b> $".$newBalance."</b>";

	        	}
			}


        } else {
        	echo "Error ".mysqli_error($con);
        	
    	} 

	            
	} else {

	    $query5 ="INSERT INTO CPS3740_2020S.Money_ojedada (code, cid, sid, type, amount, mydatetime, note) VALUES ( '$code', '$cid', '$sourceID', '$type', '$amount', '$mydatetime', '$note')";
	    $result5 = mysqli_query($con, $query5);       
        if($result5) {
     		echo "The transaction has been successfully added.<br>";
			$query6 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$cid'";
			$result6 = mysqli_query($con,$query6);
	        if(mysqli_num_rows($result6)>0) {
	        	while($row = mysqli_fetch_array($result6)){
	        		$newBalance = $row['balance'];
			     	echo "New balance:<b> $".$newBalance."</b>";
	        	}
			}

        } else {
        	echo "Error ".mysqli_error($con);
        }
	     
	}
	 
} else{
    echo "Please click on <a href='index.html'>Here (project home)</a> to login first!<br>";
}

?>








