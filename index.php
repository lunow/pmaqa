<?php
	/**
	 *	phpMyAdmin QuickAccess 
	 *	(c) 2010 Ape Unit GmbH
	 */
	$config = array(
		//database connection
		'server' => 'localhost',
		'name' => 'root',
		'pass' => 'root',
	);
	
	//absolut path to phpmyadmin - with slash at the end
	define('PHPMYADMIN', 'http://localhost/mysql/index.php?db=');
	
	$db = mysql_connect($config['server'], $config['name'], $config['pass']);
	if(!$db) {
		die('Sorry, keine Verbindung zur Datenbank!');	
	}
	$db_list = mysql_list_dbs($db);
	if(!$db_list) {
		die('Sorry, keine Datenbank gefunden!');	
	}
	mysql_close();
	
	$counter = 0;
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <title>phpMyAdmin Quick Access</title>
    <script src="jquery.min.js"></script>
    <script src="jquery.quicksearch.js"></script>
    <script>
    	jQuery(function($) {
    		$('#db')
    			.focus()
    			.quicksearch('table tr');
    		$('form').submit(function(e) {
    			e.preventDefault();
    			if($('table tr:visible').length == 1) {
    				//wtf, didnt work?!
    				//$('table tr:visible a').click();
    				window.location = $('table tr:visible a').attr('href');
    			}
    		});
    	});
    </script>
    <style>
    	body {
    		background:#e1e1e1;
    		padding:50px;	
    	}
    	#wrap {
    		background:white;
    		padding:40px;	
			width:600px;
    		margin:0 auto;
    		text-align:center;
    		-moz-box-shadow:0 0 50px silver;
    		-moz-border-radius:5px;
    	}
    	#wrap h1, #wrap h1 a {
    		font-weight:normal;
    		font-size:40px;
    		color:#858585;	
    	}
    	#wrap form input {
    		padding:10px;
    		font-size:35px;
    		display:block;
    		width:95%;
    		outline:none;
    		border:1px solid silver;
    		background:silver;
    		color:white;
    		-moz-border-radius:2px;
    	}
    	#wrap table a {
    		display:block;
    		color:#858585;
    		text-decoration:none;
    		width:100%;
    		padding:5px 10px;
    	}
    	#wrap a:hover {
    		color:black;	
    		background:#e1e1e1;
    	}
    	#wrap .wraptable {
    		position:relative;
    		margin:10px 0;
    		height:300px;
    		overflow-x:hidden;
    		overflow-y:scroll;
    	}
    	#wrap table {
    		position:relative;
    		z-index:5;
    		width:100%;
    	}
    	#wrap table tr td {
    		text-align:left;	
    		width:100%;
    	}
    </style>
  </head>
  <body>
  	
  	<div id="wrap">
  		<form id="access">
  			<h1>
  				<a href="<?php echo PHPMYADMIN; ?>">phpMyAdmin</a> Quick Access</h1>
  			<input type="text" name="db" id="db" autocomplete="off" tabindex="0" />
  		</form>
  		
  		<div class="wraptable">
	  		<table>
	  			<?php while($row = mysql_fetch_object($db_list)): $counter++; ?>
	  				<tr>
	  					<td class="name">
	  						<a href="<?php echo PHPMYADMIN.$row->Database; ?>" tabindex="<?php echo $counter; ?>">
	  							<?php echo $row->Database; ?>
	  						</a>
	  					</td>
	  				</tr>
	  			<?php endwhile; ?>
	  		</table>
	  	</div>
  	</div>
  	
  </body>
</html>