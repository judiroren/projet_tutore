<?php
echo password_hash('nuit', PASSWORD_DEFAULT);
echo "<br />";
echo password_hash('nuit', PASSWORD_DEFAULT);
$i = password_hash('nuit', PASSWORD_DEFAULT);
echo "<br />";echo $i;
if(password_verify('nuit', $i)){
	echo "<br />";
	echo "ok";
}
?>