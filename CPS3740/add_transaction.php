
<?php



if(isset($_COOKIE['ID'])){
	$customer_name = $_POST['customer_name'];
	include "dbconfig.php";

	$con=mysqli_connect($server,$login,$password,$dbname)
		or die("<br>Cannot connect to DB\n");
	echo "<a href='logout.php'>User logout</a><br>";

	$ID =  $_COOKIE['ID'];

	$query1 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$ID'";
	$result1=mysqli_query($con,$query1);

    if(mysqli_num_rows($result1)>0) {
    	while($row = mysqli_fetch_array($result1)){
    		$balance = $row['balance'];
    		
	     	
			echo "<br><font size=4><b>Add Transaction</b></font><br>";
			echo "<b>".$customer_name."</b> current balance is <b>".$balance."</b>.";
			
			echo"<br><form name='input' action='insert_transaction.php' method='post' required='required'>";
			echo"Transaction code: <input type='text' name='code' required='required'>";
			echo"<br><input type='radio' name='type' value='D'>Deposit";
			echo"<input type='radio' name='type' value='W'>Withdraw";
			echo"<br> Amount: <input type='text' name='amount' required='required'><input type='hidden' name='balance' value=".$balance.">";
			$query2 ="SELECT * FROM CPS3740.Sources";
			$result2= mysqli_query($con, $query2);
			echo"<br>Select a Source: <SELECT name='sourceID'>";
			

			if($result2) {
				if(mysqli_num_rows($result2)>0) { 
					while($row = mysqli_fetch_array($result2)){
						$sourceID=$row['id'];
						$sourceName=$row['name'];
			          	echo "<option value =".$sourceID.">".$sourceName."</option>";
					}
				}
			}
			echo "</SELECT>";
			echo "<BR>Note: <input type='text' name='note'><br>";
			echo "<input type='submit' value='Submit'></form>";

    	}
	}

 
}
else{
    echo "Please click on <a href='index.html'>Here (project home)</a> to login first!<br>";
}

?>








