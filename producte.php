<?php
/**
 * Clasa cu produse
 */
class Produse
{
    // Afisare numar de produse initial
    const SHOW_DEFAULT = 10;
    /**
     * Return ultimele produse
     */
    public static function getUltimeleProducte($numar = self::SHOW_BY_DEFAULT)
    {
        $db = Db::getConnection();
        $sql = 'SELECT id_produse, denumire, pret, este_nou FROM produse '
                . 'WHERE status = "1" ORDER BY id_produse DESC '
                . 'LIMIT :numar';
        $result = $db->prepare($sql);
        $result->bindParam(':numar', $numar, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $i = 0;
        $ListaProducte = array();
        while ($row = $result->fetch()) {
            $ListaProducte[$i]['id_produse'] = $row['id_produse'];
            $ListaProducte[$i]['denumire'] = $row['denumire'];
            $ListaProducte[$i]['pret'] = $row['pret'];
            $ListaProducte[$i]['este_nou'] = $row['este_nou'];
            $i++;
        }
        return $ListaProducte;
    }
    /**
     * Return lista cu produse dintr-o anumita categorie
     */
    public static function getProductListByCategorie($idcategorie, $pagina = 1)
    {
        $limit = produse::SHOW_BY_DEFAULT;
        $offset = ($pagina - 1) * self::SHOW_BY_DEFAULT;
        $db = Db::getConnection();
        $sql = 'SELECT id_produse, denumire, pret, este_nou FROM produse '
                . 'WHERE status = 1 AND idcategorie = :idcategorie '
                . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';
        $result = $db->prepare($sql);
        $result->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $producte = array();
        while ($row = $result->fetch()) {
            $producte[$i]['id_produse'] = $row['id_produse'];
            $producte[$i]['denumire'] = $row['denumire'];
            $producte[$i]['pret'] = $row['pret'];
            $producte[$i]['este_nou'] = $row['este_nou'];
            $i++;
        }
        return $producte;
    }
    /**
     * Return produse
     */
    public static function getProductById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM produse WHERE id_produse = :id_produse';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    /**
     * Afisare nr de produse
     */
    public static function getTotalProduseInCategorie($idcategorie)
    {
        $db = Db::getConnection();
        $sql = 'SELECT numar(id_produse) AS numar FROM produse WHERE status="1" AND idcategorie = :idcategorie';
        $result = $db->prepare($sql);
        $result->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return $row['numar'];
    }
  
    public static function getProdustsByIds($idsArray)
    {
        $db = Db::getConnection();
        $idsString = implode(',', $idsArray);
        // Текст запроса к БД
        $sql = "SELECT * FROM produse WHERE status='1' AND id_produse IN ($idsString)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        $producte = array();
        while ($row = $result->fetch()) {
            $producte[$i]['id'] = $row['id'];
            $producte[$i]['cod'] = $row['cod'];
            $producte[$i]['denumire'] = $row['denumire'];
            $producte[$i]['pret'] = $row['pret'];
            $i++;
        }
        return $producte;
    }
    /**
     * Return lista cu produse recomandate
     */
    public static function getProducteRecomandate()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id_produse, denumire, pret, este_nou FROM produse '
                . 'WHERE status = "1" AND recomandare = "1" '
                . 'ORDER BY id DESC');
        $i = 0;
        $ListaProducte = array();
        while ($row = $result->fetch()) {
            $ListaProducte[$i]['id_produse'] = $row['id_produse'];
            $ListaProducte[$i]['denumire'] = $row['denumire'];
            $ListaProducte[$i]['pret'] = $row['pret'];
            $ListaProducte[$i]['este_nou'] = $row['este_nou'];
            $i++;
        }
        return $ListaProducte;
    }
    /**
     * Return lista produse
     */
    public static function getListaProducte()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id_produse, denumire, pret, cod FROM produse ORDER BY id ASC');
        $ListaProducte = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ListaProducte[$i]['id_produse'] = $row['id_produse'];
            $ListaProducte[$i]['denumire'] = $row['denumire'];
            $ListaProducte[$i]['cod'] = $row['cod'];
            $ListaProducte[$i]['pret'] = $row['pret'];
            $i++;
        }
        return $ListaProducte;
    }
    /**
     * Stergerea produsului cu un anumit id
     */
    public static function deleteProductById($id_produse)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM produse WHERE id_produse = :id_produse';
        $result = $db->prepare($sql);
        $result->bindParam(':id_produse', $id_produse, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Update pentru produse
     */
    public static function updateProductById($id_produse, $optiune)
    {
        $db = Db::getConnection();
        $sql = "UPDATE produse
            SET 
                denumire = :denumire, 
                cod = :cod, 
                pret = :pret, 
                idcategorie = :idcategorie, 
                brand = :brand,
				disponibilitate = :disponibilitate,
                descriere = :descriere, 
                este_nou = :este_nou, 
                recomandare = :recomandare, 
                status = :status
            WHERE id_produse = :id_produse";
        $result = $db->prepare($sql);
        $result->bindParam(':id_produse', $id_produse, PDO::PARAM_INT);
        $result->bindParam(':denumire', $optiune['denumire'], PDO::PARAM_STR);
        $result->bindParam(':cod', $optiune['cod'], PDO::PARAM_STR);
        $result->bindParam(':pret', $optiune['pret'], PDO::PARAM_STR);
        $result->bindParam(':idcategorie', $optiune['idcategorie'], PDO::PARAM_INT);
        $result->bindParam(':brand', $optiune['brand'], PDO::PARAM_STR);
		$result->bindParam(':disponibilitate', $optiune['disponibilitate'], PDO::PARAM_STR);
        $result->bindParam(':descriere', $optiune['descriere'], PDO::PARAM_STR);
        $result->bindParam(':este_nou', $optiune['este_nou'], PDO::PARAM_INT);
        $result->bindParam(':recomandare', $optiune['recomandare'], PDO::PARAM_INT);
        $result->bindParam(':status', $optiune['status'], PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Adaugare nou produs
     */
    public static function creareProduct($optiune)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO produse '
                . '(denumire, cod, pret, idcategorie, brand, '
                . 'descriere, este_nou, recomandare, status)'
                . 'VALUES '
                . '(:denumire, :cod, :pret, :idcategorie, :brand, :availability, :disponibilitate,'
                . ':descriere, :este_nou, :recomandare, :status)';
        $result = $db->prepare($sql);
        $result->bindParam(':denumire', $optiune['denumire'], PDO::PARAM_STR);
        $result->bindParam(':cod', $optiune['cod'], PDO::PARAM_STR);
        $result->bindParam(':pret', $optiune['pret'], PDO::PARAM_STR);
        $result->bindParam(':idcategorie', $optiune['idcategorie'], PDO::PARAM_INT);
        $result->bindParam(':brand', $optiune['brand'], PDO::PARAM_STR);
		 $result->bindParam(':disponibilitate', $optiune['disponibilitate'], PDO::PARAM_STR);
        $result->bindParam(':descriere', $optiune['descriere'], PDO::PARAM_STR);
        $result->bindParam(':este_nou', $optiune['este_nou'], PDO::PARAM_INT);
        $result->bindParam(':recomandare', $optiune['recomandare'], PDO::PARAM_INT);
        $result->bindParam(':status', $optiune['status'], PDO::PARAM_INT);
        if ($result->execute()) {
      
            return $db->lastInsertId();
        }
        return 0;
    }
    /**
     * Returna daca produsul este in stoc sau este comandat
     */
    public static function getAvailabilityText($disponibilitate)
    {
        switch ($disponibilitate) {
            case '1':
                return 'Este pe stoc';
                break;
            case '0':
                return 'Comandat';
                break;
        }
    }
    /**
     * Reintoarcerea la imagine
     */
    public static function getImagine($id_produse)
    {
        $noImage = 'no-image.jpg';
        $path = '/upload/imagine/produse/';
        $pathToProductImage = $path . $id_produse . '.jpg';
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            return $pathToProductImage;
        }
        return $path . $noImage;
    }
}
