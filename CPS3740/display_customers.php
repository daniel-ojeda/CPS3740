<HTML>

<HEAD>
<TITLE>Display Customers</TITLE>
</HEAD>

<BODY>

<?php	

	include "dbconfig.php";

	
	$con = mysqli_connect($server,$login,$password,$dbname) 
		or die("<br>Cannot connect to DB\n");

	$query = "SELECT * FROM Customers";

	$result = mysqli_query($con,$query);

	if($result) {
		if(mysqli_num_rows($result) > 0) {
		
			echo "The following customers are in the bank system:";



			echo "<TABLE border='1'>";
			echo "<tr><th>ID</th><th>login</th><th>password</th><th>Name</th><th>Gender</th>
				<th>DOB</th><th>Street</th><th>City</th><th>State</th><th>Zipcode</th></tr>";


			while ($row = mysqli_fetch_array($result)) {
          
	            $id = $row['id'];
	            $name = $row['name'];
				$login = $row['login'];
				$password = $row['password'];
				$DOB = $row['DOB'];
				$gender = $row['gender'];
				$street = $row['street'];
				$city = $row['city'];
				$state = $row['state'];
				$zipcode = $row['zipcode'];

				echo "<tr><td>".$id."</td>";
				echo "<td>".$login."</td>";
				echo "<td>".$password ."</td>";
				echo "<td>".$name."</td>";
				echo "<td>".$gender."</td>";
				echo "<td>".$DOB."</td>";
				echo "<td>".$street ."</td>";
				echo "<td>".$city ."</td>";
				echo "<td>".$state ."</td>";
				echo "<td>".$zipcode."</td></tr>";

			}

		} else {
			echo "<br>No records in the database.\n";
			mysqli_free_result($result);

		}
		echo "</TABLE>\n";
		
	} else {
		echo "<br>Something wrong with the SQL query.\n";
	}
	mysqli_close($con);
?> 

</BODY>

</HTML>