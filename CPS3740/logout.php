<?php

setcookie('ID', '', time() - 3600);
setcookie('customer_name', '', time() - 3600);
       
echo "You successfully logout.<br><br>";
echo "<a href='index.html'>Project home page</a><br>";

?>