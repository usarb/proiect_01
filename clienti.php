
<?php
/**
 * Clasa clienti
 */
class Client
{
    /**
     * Inregistrarea clientilor
     * @param string $nume <p>Numele</p>
	 * @param string $prenume <p>Prenumele</p>
	 * @param string $datanastere <p>Data de nastere</p>
	 * @param string $email <p>E-mail</p>
	 * @param string $telefon <p>Telefon</p>
     * @param string $username <p>Username</p>
     * @param string $parola <p>Parola</p>
     * @return boolean <p>Daca a fost facuta inregistrarea</p>
     */
    public static function register($nume, $prenume, $datanastere, $email, $telefon, $username, $parola)
    {
        // Conexiuneacu baza de date
        $db = Db::getConnection();
        $sql = 'INSERT INTO clienti (nume, prenume, datanastere, email, telefon, username, parola) '
                . 'VALUES (:nume, :prenume, :datanastere, :email, :telefon, :username, :parola)';
        // Afisare rezultate
        $rezultat = $db->prepare($sql);
        $rezultat->bindParam(':nume', $nume, PDO::PARAM_STR);
		$rezultat->bindParam(':prenume', $prenume, PDO::PARAM_STR);
		$rezultat->bindParam(':datanastere', $datanastere, PDO::PARAM_STR);
		$rezultat->bindParam(':email', $email, PDO::PARAM_STR);
		$rezultat->bindParam(':telefon', $telefon, PDO::PARAM_STR);
        $rezultat->bindParam(':username', $username, PDO::PARAM_STR);
        $rezultat->bindParam(':parola', $parola, PDO::PARAM_STR);
        return $rezultat->execute();
    }
    /**
     * Redactarea datelor cu id_client, email si parola
     * @return boolean <p>Daca a fost facuta inregistrarea</p>
     */
    public static function edit($id_client, $email, $username)
    {
        $db = Db::getConnection();
        $sql = "UPDATE clienti 
            SET email = :email, parola= :parola
            WHERE id_client = :id_client";
        //  Afisare rezultate
        $rezultat = $db->prepare($sql);
        $rezultat->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $rezultat->bindParam(':email', $email, PDO::PARAM_STR);
        $rezultat->bindParam(':parola', $parola, PDO::PARAM_STR);
        return $rezultat->execute();
    }
    /**
     * Verific daca exista utilizator cu asa $email и $username
     */
    public static function checkUserData($email, $parola)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM clienti WHERE email = :email AND parola = :parola';
        $rezultat = $db->prepare($sql);
        $rezultat->bindParam(':email', $email, PDO::PARAM_INT);
        $rezultat->bindParam(':parola', $parola, PDO::PARAM_INT);
        $rezultat->execute();
        $clienti = $rezultat->fetch();
        if ($clienti) {
            return $clienti['id_client'];
        }
        return false;
    }
    /**
     *Memoram utilizator
     */
    public static function auth($userId)
    {
        $_SESSION['clienti'] = $userId;
    }
    public static function checkLogged()
    {
        if (isset($_SESSION['clienti'])) {
            return $_SESSION['clienti'];
        }
        header("Location: /clienti/login");
    }
    /**
     * Verific daca clientul este doar vizitator
     */
    public static function esteVizitator()
    {
        if (isset($_SESSION['clienti'])) {
            return false;
        }
        return true;
    }
    /**
     * Verific daca numele are mai mult de 3 simboluri
     */
    public static function nrNume($nume)
    {
        if (strlen($nume) >= 3) {
            return true;
        }
        return false;
    }
    /**
     * Telefonul sa aiba 9 simboluri
     */
    public static function verificTelefon($telefon)
    {
        if (strlen($telefon) = 9) {
            return true;
        }
        return false;
    }
    /**
     * Verific parola mai mult de 4 simboluri
     */
    public static function verificParola($parola)
    {
        if (strlen($parola) >= 4) {
            return true;
        }
        return false;
    }
    /**
     * Verific email
     */
    public static function verificEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    /**
     * Verific daca email-ul nu este ocupat de altcineva
     */
    public static function emailExista($email)
    {    
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM clienti WHERE email = :email';
        $rezultat = $db->prepare($sql);
        $rezultat->bindParam(':email', $email, PDO::PARAM_STR);
        $rezultat->execute();
        if ($rezultat->fetchColumn())
            return true;
        return false;
    }
    /**
     * Return utilizator
     */
    public static function getClientById($id_client)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM clienti WHERE id_client = :id_client';
        $rezultat = $db->prepare($sql);
        $rezultat->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $rezultat->setFetchMode(PDO::FETCH_ASSOC);
        $rezultat->execute();
        return $rezultat->fetch();
    }
}