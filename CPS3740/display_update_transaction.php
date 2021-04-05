
<?php

if(isset($_COOKIE['ID'])){
	include "dbconfig.php";
	$con=mysqli_connect($server,$login,$password,$dbname)
		or die("<br>Cannot connect to DB\n");
	echo "<a href='logout.php'>User logout</a><br>";
	$cida =  $_COOKIE['ID'];

	$query2 = "SELECT * FROM CPS3740_2020S.Money_ojedada where cid = '$cida'";

	$result2 = mysqli_query($con, $query2);
	if($result2) {
		$i=0;
		if(mysqli_num_rows($result2)>0){
			echo "You can only udpdate <b>Note</b> column.<br>";
			echo "<form action='update_transaction.php' method='post'>";
			echo "<TABLE border='1'>";
			echo "<tr><th>ID</th><th>Code</th><th>Operation</th><th>Amount</th><th>Date Time</th><th>Note</th><th>Delete</th></tr>";

			while($row = mysqli_fetch_array($result2)){


				$cid = $row['cid'];
	            $mid = $row['mid'];
				$code = $row['code'];
				$operation = $row['type'];
				$amount = $row['amount'];
				$myDateTime = $row['mydatetime'];
				$note = $row['note'];

				echo "<tr><td><input type='hidden' name='mid[$i]' value=".$mid.">".$mid."</td>";
				echo "<td>".$code."</td>";
				echo "<td>".$operation ."</td>";
				if($amount > 0) {
				echo "<td><font color=blue>". $amount."</font></td>";
				} else {
				echo "<td><font color=red>". $amount."</font></td>";	
				}
				echo "<td>".$myDateTime."</td>";
				echo "<td bgcolor='yellow'><input type='text' style='background-color:yellow;' name='note[$i]' value='".$note."' /></td>";
				echo "<td><input type='checkbox' name='delete[$i]' value='".$mid."'></td></tr>";
				++$i;

			}
			echo "</TABLE>\n";
			$query4 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$cida'";
			$result4=mysqli_query($con,$query4);

	        if(mysqli_num_rows($result4)>0) {
	        	while($row = mysqli_fetch_array($result4)){
	        		$balance = $row['balance'];
			     	echo "Total balance: ".$balance;

			     
	        	}
			}
			echo"<br><input type='submit' value='Update transaction'>";
			echo"</form>";

		}
	}

		       

		mysqli_close($con);
 
}
else{
    echo "Please click on <a href='index.html'>Here (project home)</a> to login first!<br>";
}

?>