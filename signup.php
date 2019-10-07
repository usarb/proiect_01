<?php
	require "db.php"; 
	
	$data = $_POST;
	if (isset ($data['do_signup']))
	{
		// aici ne inregistram
		$errors = array();
		if( trim($data ['nume'] ) == '')
		{
			$errors[] = 'Introduceți numele de familie';
		}
		if( trim( $data ['prenume'] ) == '')
		{
			$errors[] = 'Introduceți prenumele dumneavoastra';
		}
		if( trim( $data ['data_nasterii'] ) == '')
		{
			$errors[] = 'Introduceți data nașterii';
		}
		if( trim( $data ['telefon'] ) == '')
		{
			$errors[] = 'Introduceți telefonul dumneavoastră';
		}
		if( trim( $data ['email'] ) == '')
		{
			$errors[] = 'Introduceți email-ul dumneavoastră';
		}
		if( trim( $data ['username'] ) == '')
		{
			$errors[] = 'Introduceți username';
		}
		if( trim( $data ['parola'] ) == '')
		{
			$errors[] = 'Introduceți parola';
		}
		if( trim($data ['parola_2'] ) != $data ['parola'])
		{
			$errors[] = 'Parola nu corespunde cu cea de mai sus';
		}
	
		if( empty ($errors))
		{
			//totul este ok, se poate de inregistrat
			$user = R::dispense('users');
			$user -> nume = $data ['nume'];
			$user -> prenume = $data ['prenume'];
			$user -> telefon = $data ['telefon'];
			$user -> email = $data ['email'];
			$user -> username = $data ['username'];
			$user -> parola = $data ['parola'];
			R::store($user);
			echo '<div style = "color : green; " >Felicitări!V-ați înregistrat cu succes!
			</div><hr>';
		} else
		{
			echo '<div style = "color : red; " >'.array_shift($errors).'
			</div><hr>';
		}
	}
?>

<form action= "/signup.php" method = "POST">
	<p>
		<p><strong> Numele vostru </strong>:</p> 
		<input type = "varchar" name = "nume" value = "<?php echo @$data ['nume']; ?>">
	</p>
	
	<p>
		<p><strong> Prenumele vostru </strong>:</p> 
		<input type = "varchar" name = "prenume"value = "<?php echo @$data ['prenume']; ?>">
	</p>
	
	<p>
		<p><strong> Data de naștere a dumneavoastra </strong>:</p> 
		<input type = "varchar" name = "data_nasterii" value = "<?php echo @$data ['data_nasterii']; ?>">
	</p>
	
	<p>
		<p><strong> Telefonul vostru </strong>:</p> 
		<input type = "varchar" name = "telefon" value = "<?php echo @$data ['telefon']; ?>">
	</p>
	
	<p>
		<p><strong> Email-ul vostru </strong>:</p> 
		<input type = "varchar" name = "email" value = "<?php echo @$data ['email']; ?>">
	</p>
	
	<p>
		<p><strong> Usernam-ul vostru </strong>:</p> 
		<input type = "varchar" name = "username" value = "<?php echo @$data ['username']; ?>">
	</p>
		
	<p>
		<p><strong> Parola voastră </strong>:</p> 
		<input type = "varchar" name = "parola" value = "<?php echo @$data ['parola']; ?>">
	</p>
	
	<p>
		<p><strong> Repetați vă rog parola </strong>:</p> 
		<input type = "varchar" name = "parola_2" value = "<?php echo @$data ['parola_2']; ?>">
	</p>
	
	<p>
		<button type = "submit" name = "do_signup"> Înregistrare </button> 
	</p>
 
</form>
 