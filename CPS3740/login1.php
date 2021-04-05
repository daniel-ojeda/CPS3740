<?php
$username = strtolower($_POST['username']);
$browser_password = $_POST['password'];

include "dbconfig.php";

$con=mysqli_connect($server,$login,$password,$dbname)
	or die("<br>Cannot connect to DB\n");

$query = "SELECT * FROM Customers where login = '$username' and password = '$browser_password'";

$result = mysqli_query($con,$query);

if ($result) {
	if (mysqli_num_rows($result)>0) {
		while($row = mysqli_fetch_array($result)){
			if ($browser_password == $row['password']){

            	setcookie("User", $username, time() +(60*60*24), "/");
				
				$customersTableID = $row['id'];
				$name = $row['name'];
				$DOB = $row['DOB'];
				$ageInSeconds = abs(strtotime("now") - strtotime($DOB));
				$age = floor($ageInSeconds / (365*24*60*60));
				$street = $row['street'];
				$city = $row['city'];
				$zipcode = $row['zipcode'];

				$ip = $_SERVER['REMOTE_ADDR'];
				echo "<br>Your IP: $ip</br>"; 
				echo "Your browser and OS: ".$_SERVER['HTTP_USER_AGENT'];
			  
			    $IPv4= explode(".",$ip);
			    if ($IPv4 [0] == "10" OR  $IPv4[0].".".$IPv4[1]=="131.125"){
			    	echo "<br>You are at Kean domain.<br>";

			    } else {
			    	echo "<br>You are NOT from Kean domain.<br>";
			    	#echo $IPv4[0].".".$IPv4[1];</br>
			    }

				echo "Welcome Customer: ". $name."</br>";

				echo "Age: ". $age."<br>";
				echo "Address: ". $street .", ". $city .", ". $zipcode."</br><hr>";
				echo "The transcations for customer " .$name ." are: Saving account";

				$query2 = "SELECT * FROM CPS3740_2020S.Money_ojedada";
				$query3 = "SELECT cid FROM CPS3740_2020S.Money_ojedada";

				$result2 = mysqli_query($con, $query2);
				$result3 = mysqli_query($con, $query3);
				$row = mysqli_fetch_array($result3);
            
				if($result2 and $customersTableID == $row['cid']) {

					if(mysqli_num_rows($result2)>0){
						echo "<TABLE border='1'>";
						echo "<tr><th>ID</th><th>Code</th><th>Operation</th><th>Amount</th><th>Date Time</th><th>Note</th></tr>";

						while($row = mysqli_fetch_array($result2)){

							$cid = $row['cid'];
				            $mid = $row['mid'];
							$code = $row['code'];
							$operation = $row['type'];
							$amount = $row['amount'];
							$myDateTime = $row['mydatetime'];
							$note = $row['note'];

							echo "<tr><td>".$mid."</td>";
							echo "<td>".$code."</td>";
							echo "<td>".$operation ."</td>";
							if($amount > 0) {
							echo "<td><font color=blue>". $amount."</font></td>";
							} else {
							echo "<td><font color=red>". $amount."</font></td>";	
							}
							echo "<td>".$myDateTime."</td>";
							echo "<td>".$note."</td></tr>";
	  
						}
						echo "</TABLE>\n";
						$query4 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada";
						$result4=mysqli_query($con,$query4);

				        if(mysqli_num_rows($result4)>0) {
				        	while($row = mysqli_fetch_array($result4)){
				        		$balance = $row['balance'];
						     	echo "Total balance: ".$balance;
						     
				        	}
						}
					}
				}
			}
		}

	} else {
		$query5 = "SELECT login FROM Customers where login = '$username'";
		$result5 = mysqli_query($con,$query5);
		$row = mysqli_fetch_array($result5);
		
    	if ($username == $row['login']) {
    		echo "<br>Login " . $username . " exists, but password not match.\n";
    	} else {
			echo "<br>Login " . $username ." doesn’t exist in the database.\n";
		}
	}
	mysqli_free_reslut($result);
	mysqli_free_reslut($result2);
	mysqli_free_reslut($result3);
	mysqli_free_reslut($result4);
	mysqli_free_reslut($result5);

} else {
	echo "<br>Something wrong with the SQL query.\n";
	echo"<br>Error:" . mysql_error($con);
}

mysql_close($con);
?>