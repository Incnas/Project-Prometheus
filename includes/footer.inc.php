	</div> <!-- /content -->
	<div id="footer">
		Logged in as: <? echo $_SESSION['user_name']; ?>
		<br />
		Generated in <? echo round((microtime(true) - $pageload), 4); ?> seconds at <b><? echo date('H:i:s d/m/y');
		//Display page load time and current date
		?>
	</div>
</div> <!-- /container -->