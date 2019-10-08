<?php
	require "db.php"; 
	$data = $_POST;
	if (isset ($data['do_login']))
	{
		$errors = array();
		$user = R::findOne ('inregistrare', 'username = ?', array($data['username']));
		if ( $user)
		{
			// usernam-ul lipseste
			if (password_verify($data['parola'], $user -> parola)
				){
				//totul este ok, loginul utilizatorului
				$_SESSION ['logare_user'] = $user;
				echo '<div style = "color : green; " >Sunte-ti inregistrat! </br>
				Pute-ti trece la pagina <a href = "/">Pincipală!</a></div><hr>';
				}else 
				{
					$errors[] = 'Parola este introdusa gresit';
				}
		}else
		{
			$errors[] = 'Utilizator cu asa username nu exista';
		}
	
		if( ! empty ($errors))
		{
			echo '<div style = "color : red; " >'.array_shift($errors).'
			</div><hr>';
		}
	}
?>



<form action= "/login.php" method = "POST">
<p>
		<p><strong>Usernam-ul </strong>:</p> 
		<input type = "varchar" name = "username" value = "<?php echo @$data ['username']; ?>">
	</p>
		
	<p>
		<p><strong>Parola</strong>:</p> 
		<input type = "password" name = "parola" value = "<?php echo @$data ['parola']; ?>">
	</p>
			
	<p>
		<button type = "submit" name = "do_login"> Logare </button> 
	</p>
 
</form>