<?php

	//$host="coolture.digitallpost.com.mx";
	$host="host.digitalpost.com";

	$dbname="cooldigi_coolture";
	$dbuser="cooldigi_cool";
	$dbpss="cAl1f012ni4N_0RangE!buD";

	$link=mysql_connect($host,$dbuser,$dbpss);
	if(!$link)
	{
		echo "error: ".mysql_error()."<br>";
	}
	else
	{
		echo "here";
		mysql_select_db($dbname);
	}


$tables=array("wp_posts");
	
	
?>
<!-- 
<form action="http://coolture.digitallpost.com.mx/searchreplacedb2.php?step=5" method="post">
	<fieldset>
		<p>
			<label for="host">Server Name:</label>
			<input class="text" type="text" name="host" id="host" value="localhost" />
		</p>

		<p>
			<label for="data">Database Name:</label>
			<input class="text" type="text" name="data" id="data" value="cooldigi_coolture" />
		</p>

		<p>
			<label for="user">Username:</label>
			<input class="text" type="text" name="user" id="user" value="cooldigi_cool" />
		</p>

		<p>
			<label for="pass">Password:</label>
			<input class="text" type="password" name="pass" id="pass" value="cAl1f012ni4N_0RangE!buD" />
		</p>

		<p>
			<?php
			foreach( $tables as $i => $tab )
				echo '<input type="text" name="tables['.$i.']" value="'.$tab.'" /><br>';			
			?>
		</p>

		<p>
			<label for="srch">Search for (case sensitive string):</label>
			<input class="text" type="text" name="srch" id="srch" value="ESTE ES EL DOODLE" />
		</p>

		<p>
			<label for="rplc">Replace with:</label>
			<input class="text" type="text" name="rplc" id="rplc" value="ESTE ES EL GOODLE" />
		</p>

		<input type="submit" value="Dale!" />
	</fieldset>
</form>	 -->