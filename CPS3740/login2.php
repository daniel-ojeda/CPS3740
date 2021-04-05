

<?php


if (isset($_POST['username']) && $_POST['password']){

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
	
					$ID = $row['id'];
					$name = $row['name'];
					setcookie("ID", $ID, time() +(60*60*24));
	            	setcookie("customer_name", $name, time() +(60*60*24));
					
					$DOB = $row['DOB'];
					$ageInSeconds = abs(strtotime("now") - strtotime($DOB));
					$age = floor($ageInSeconds / (365*24*60*60));
					$street = $row['street'];
					$city = $row['city'];
					$zipcode = $row['zipcode'];

					$ip = $_SERVER['REMOTE_ADDR'];
					echo "<a href='logout.php'>User logout</a><br>";
					echo "<br>Your IP: $ip</br>"; 
					echo "Your browser and OS: ".$_SERVER['HTTP_USER_AGENT'];
				  
				    $IPv4= explode(".",$ip);
				    if ($IPv4[0] == "10" OR  $IPv4[0].".".$IPv4[1] == "131.125"){

				    	echo "<br>You are at Kean domain.<br>";

				    } else {
				    	echo "<br>You are NOT from Kean domain.<br>";
				    	#echo $IPv4[0].".".$IPv4[1];</br>
				    }

					echo "Welcome Customer: ". $name."</br>";

					echo "Age: ". $age."<br>";
					echo "Address: ". $street .", ". $city .", ". $zipcode."</br><hr>";
					echo "The transcations for customer " .$name ." are: Saving account";

					$query2 = "SELECT * FROM CPS3740_2020S.Money_ojedada where cid = '$ID'";
					

					$result2 = mysqli_query($con, $query2);
				
				
					
	            
					if($result2) {

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
							$query4 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$ID'";
							$result4=mysqli_query($con,$query4);

					        if(mysqli_num_rows($result4)>0) {
					        	while($row = mysqli_fetch_array($result4)){
					        		$balance = $row['balance'];
							     	echo "Total balance: ".$balance;
							     
					        	}
							}
							echo "<br><br><TABLE border=0>";
							echo "<TR><TD><form action='add_transaction.php' method='POST'>";
							echo "<input type='hidden' name='customer_name' value=\"".$name."\">";
							echo "<input type='submit' value='Add transaction'></form>";
							echo "<TD><a href='display_update_transaction.php'>Display and update transaction</a>";
							echo "<TR><TD colspan=2><form action='search.php' method='GET'>";
							echo "Keyword: <input type='text' name='keyword'  required='required' >";
							echo "<input type='submit' value='Search transaction'></form>";
							echo "</TABLE></HTML>";
						}
					mysqli_free_result($result2);
					
					mysqli_free_result($result4);
				
					}
				}
			}
		mysqli_free_result($result);

		} else {
			$query5 = "SELECT login FROM Customers where login = '$username'";
			$result5 = mysqli_query($con,$query5);
			$row = mysqli_fetch_array($result5);
			
	    	if ($username == $row['login']) {
	    		echo "<br>Login " . $username . " exists, but password not match.\n";
	    		mysqli_free_result($result5);
	    	} else {
				echo "<br>Login " . $username ." doesn’t exist in the database.\n";
				mysqli_free_result($result5);
			}
		}
	}

	mysqli_close($con);



} else if (isset($_COOKIE['ID'])){
	include "dbconfig.php";
	$con=mysqli_connect($server,$login,$password,$dbname)
		or die("<br>Cannot connect to DB\n");
	$ID = $_COOKIE['ID'];

	$query = "SELECT * FROM Customers where id ='$ID'";
	$result = mysqli_query($con,$query);

	if ($result) {
		if (mysqli_num_rows($result)>0) {
			while($row = mysqli_fetch_array($result)){
					
					$name = $row['name'];
					$DOB = $row['DOB'];
					$ageInSeconds = abs(strtotime("now") - strtotime($DOB));
					$age = floor($ageInSeconds / (365*24*60*60));
					$street = $row['street'];
					$city = $row['city'];
					$zipcode = $row['zipcode'];

					$ip = $_SERVER['REMOTE_ADDR'];
					echo "<a href='logout.php'>User logout</a><br>";
					echo "<br>Your IP: $ip</br>"; 
					echo "Your browser and OS: ".$_SERVER['HTTP_USER_AGENT'];
				  
				    $IPv4= explode(".",$ip);
				    if ($IPv4[0] == "10" OR  $IPv4[0].".".$IPv4[1] == "131.125"){

				    	echo "<br>You are at Kean domain.<br>";

				    } else {
				    	echo "<br>You are NOT from Kean domain.<br>";
				    	#echo $IPv4[0].".".$IPv4[1];</br>
				    }

					echo "Welcome Customer: ". $name."</br>";

					echo "Age: ". $age."<br>";
					echo "Address: ". $street .", ". $city .", ". $zipcode."</br><hr>";
					echo "The transcations for customer " .$name ." are: Saving account";

					$query2 = "SELECT * FROM CPS3740_2020S.Money_ojedada where cid = '$ID'";
					

					$result2 = mysqli_query($con, $query2);
					
					
					
	            
					if($result2) {

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
							$query4 = "SELECT sum(amount) as balance FROM CPS3740_2020S.Money_ojedada where cid = '$ID'";
							$result4=mysqli_query($con,$query4);

					        if(mysqli_num_rows($result4)>0) {
					        	while($row = mysqli_fetch_array($result4)){
					        		$balance = $row['balance'];
							     	echo "Total balance: ".$balance;
							     
					        	}
							}
							echo "<br><br><TABLE border=0>";
							echo "<TR><TD><form action='add_transaction.php' method='POST'>";
							echo "<input type='hidden' name='customer_name' value=\"".$name."\">";
							echo "<input type='submit' value='Add transaction'></form>";
							echo "<TD><a href='display_update_transaction.php'>Display and update transaction</a>";
							echo "<TR><TD colspan=2><form action='search.php' method='GET'>";
							echo "Keyword: <input type='text' name='keyword'  required='required' >";
							echo "<input type='submit' value='Search transaction'></form>";
							echo "</TABLE></HTML>";
						}
					mysqli_free_result($result2);
					
					mysqli_free_result($result4);
				
					}
				
			}
		mysqli_free_result($result);

		}

	}
	mysqli_close($con);








} else {
	$ip = $_SERVER['REMOTE_ADDR'];
	echo "<br>Your IP: $ip</br>"; 
	
	$IPv4= explode(".",$ip);
	if ($IPv4[0] == "10" OR  $IPv4[0].".".$IPv4[1] == "131.125"){

		echo "<br>You are at Kean domain.<br>";

	} else {
		echo "<br>You are NOT from Kean domain.<br>";
		#echo $IPv4[0].".".$IPv4[1];</br>
	}


	echo "<br>Users must login first.\n";
	echo "<br>Please follow the link below:\n";
}
    


?>