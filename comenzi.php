<?php

class Comanda
{
    /**
     * Salvarea comenzii
     */
    public static function save($username, $email, $userComment, $id_client, $produse)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO comenzi (username, email, user_comment, id_client, produse) '
                . 'VALUES (:username, :email, :user_comment, :id_client, :produse)';
        $produse = json_encode($produse);
        $resultat = $db->prepare($sql);
        $resultat->bindParam(':username', $username, PDO::PARAM_STR);
        $resultat->bindParam(':email', $email, PDO::PARAM_STR);
        $resultat->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $resultat->bindParam(':id_client', $id_client, PDO::PARAM_STR);
        $resultat->bindParam(':produse', $produse, PDO::PARAM_STR);
        return $resultat->execute();
    }
    /**
     * Return lista comenzii
     */
    public static function getListaComenzii()
    {
        $db = Db::getConnection();
        $resultat = $db->query('SELECT id_comanda, username, email, data, status FROM comenzi Comanda BY id_comanda DESC');
        $listaComanda = array();
        $i = 0;
        while ($row = $resultat->fetch()) {
            $listaComanda[$i]['id_comanda'] = $row['id_comanda'];
            $listaComanda[$i]['username'] = $row['username'];
            $listaComanda[$i]['email'] = $row['email'];
            $listaComanda[$i]['data'] = $row['data'];
            $listaComanda[$i]['status'] = $row['status'];
            $i++;
        }
        return $listaComanda;
    }
    /**
     * Return status comanda : 1- comanda noua, 2- in asteptare, 3- este pe drum, 4- inchis
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Comanda noua';
                break;
            case '2':
                return 'In asteptare';
                break;
            case '3':
                return 'Este pe drum';
                break;
            case '4':
                return 'Inchis';
                break;
        }
    }
    /**
     * Return comanda
     */
    public static function getComandaById($id_comanda)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM comenzi WHERE id_comanda = :id_comanda';
        $resultat = $db->prepare($sql);
        $resultat->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
        $resultat->setFetchMode(PDO::FETCH_ASSOC);
        $resultat->execute();
        return $resultat->fetch();
    }
    /**
     * Stergere comanda
     */
    public static function stergeComandaById($id_comanda)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM comenzi WHERE id_comanda = :id_comanda';
        $resultat = $db->prepare($sql);
        $resultat->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
        return $resultat->execute();
    }
    /**
     * Actualizare comanda
     */
    public static function actualizareComandaById($id_comanda, $username, $email, $userComment, $data, $status)
    {
        $db = Db::getConnection();
        $sql = "UPDATE comenzi
            SET 
                username = :username, 
                email = :email, 
                user_comment = :user_comment, 
                data = :data, 
                status = :status 
            WHERE id_comanda = :id_comanda";
        $resultat = $db->prepare($sql);
        $resultat->bindParam(':id_comanda', $id_comanda, PDO::PARAM_INT);
        $resultat->bindParam(':username', $username, PDO::PARAM_STR);
        $resultat->bindParam(':email', $email, PDO::PARAM_STR);
        $resultat->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $resultat->bindParam(':data', $data, PDO::PARAM_STR);
        $resultat->bindParam(':status', $status, PDO::PARAM_INT);
        return $resultat->execute();
    }
}
