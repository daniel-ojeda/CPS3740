<?php 

if(isset($_COOKIE['ID'])){

	include "dbconfig.php";
	$key= $_GET['keyword'];

	 $id=$_COOKIE['ID'];
	 $name=$_COOKIE['customer_name'];
		$con=mysqli_connect($server,$login,$password,$dbname)
			or die("<br>Cannot connect to DB\n");

	if($key =='*'){
		
		$result2 = mysqli_query($con, "SELECT * FROM CPS3740_2020S.Money_ojedada m,CPS3740.Sources s WHERE m.sid=s.id");
		echo "The transaction in the customer <strong> ".$name." </strong>records matched keywords are *.";
			if($result2) {
				if(mysqli_num_rows($result2)>0) {
		            echo "<table border='1'>";
					echo "<tr><th>ID</th><th>Code</th><th>Type</th><th>Amount</th><th>Date Time</th><th>Note</th><th>Source</th></tr>";
					while($row = mysqli_fetch_array($result2)){
			            $MID = $row['mid'];
						$CODE = $row['code'];
						$TYPE = $row['type'];
						$AMOUNT = $row['amount'];
						$DATETIME = $row['mydatetime'];
						$NOTE = $row['note'];
						$SID=$row['name'];

						echo "<tr><td>".$MID."</td>";
						echo "<td>".$CODE."</td>";
						echo "<td>". $TYPE ."</td>";
						
			            if($AMOUNT>0) {
						echo "<td><font color=blue>". $AMOUNT."</font></td>";
					    } else {
							echo "<td><font color=red>". $AMOUNT."</font></td>";	
					    }
						echo "<td>".$DATETIME."</td>";
						echo "<td>".$NOTE."</td>";
						echo "<td>".$SID."</td>";
						}
				
				}
			}
	} else if (empty($key)) {
		echo "No Keyword was entered.";
	} else {
		$query="SELECT * FROM CPS3740_2020S.Money_ojedada m,CPS3740.Sources s WHERE  m.sid=s.id AND note LIKE '%".$key."%'";
		$result = mysqli_query($con, $query);
	    	
	    	
		if($result) {
			if(mysqli_num_rows($result)>0) {
			   	echo "The transaction in the customer <strong> ".$name." </strong> records matched keywords <strong>'$key' </strong>are: <br>";
		        echo "<table border='1'>";
				echo "<tr><th>ID</th><th>Code</th><th>Type</th><th>Amount</th><th>Date Time</th><th>Note</th><th>Source</th></tr>";
				while($row = mysqli_fetch_array($result)) {
			        $MID = $row['mid'];
					$CODE = $row['code'];
					$TYPE = $row['type'];
					$AMOUNT = $row['amount'];
					$DATETIME = $row['mydatetime'];
					$NOTE = $row['note'];
					$SID=$row['name'];

					echo "<tr><td>".$MID."</td>";
					echo "<td>".$CODE."</td>";
					echo "<td>". $TYPE ."</td>";
			
			        if($AMOUNT>0) {
					  echo "<td><font color=blue>". $AMOUNT."</font></td>";
				    }
				    else {
				      echo "<td><font color=red>". $AMOUNT."</font></td>";	
				    }
		
					echo "<td>".$DATETIME."</td>";
					echo "<td>".$NOTE."</td>";
					echo "<td>".$SID."</td>";
				}// while loop	
			} else {
				echo "No transaction was found for <strong> ".$name."</strong> that matched the keyword <strong>'$key' </strong>.";
			}
		} else {
			echo "No result found";
		}
	}
}else{
    echo "Please click on <a href='index.html'>Here (project home)</a> to login first!<br>";
}	

mysqli_close($con);
?>