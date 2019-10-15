<?php
/**
 * Clasa categorii
 */
class Categorii
{
    /**
     * Returna categoriile pentru lucru cu site-ul
     * @return array <p>Categorii</p>
     */
    public static function getCategorieList()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT idcategorie, denumire FROM categorii WHERE status = "1" ORDER BY nrordine, denumire ASC');
        // Primirea si returnare rezultat
        $i = 0;
        $categoriiList = array();
        while ($row = $result->fetch()) {
            $categoriiList[$i]['idcategorie'] = $row['idcategorie'];
            $categoriiList[$i]['denumire'] = $row['denumire'];
            $i++;
        }
        return $categoriiList;
    }
    /**
     * Returna categoriile
     */
    public static function getCategorieListAdmin()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT idcategorie, denumire, nrordine, status FROM categorii ORDER BY nrordine ASC');
        $categoriiList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $categoriiList[$i]['idcategorie'] = $row['idcategorie'];
            $categoriiList[$i]['denumire'] = $row['denumire'];
            $categoriiList[$i]['nrordine'] = $row['nrordine'];
            $categoriiList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoriiList;
    }
    /**
     * Stergerea categorii cu un anumit idcategorie
     */
    public static function deleteCategorieById($idcategorie)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM categorii WHERE idcategorie = :idcategorie';
        $result = $db->prepare($sql);
        $result->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Redactarea categorii cu un anumit idcategorie
     */
    public static function updateCategoryById($idcategorie, $denumire, $nrordine, $status)
    {
        $db = Db::getConnection();
        $sql = "UPDATE category
            SET 
                denumire = :denumire, 
                nrordine = :nrordine, 
                status = :status
            WHERE idcategorie = :idcategorie";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Returna categoria cu un anumit idcategorie
     */
    public static function getCategoriiById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM categorii WHERE idcategorie = :idcategorie';
        $result = $db->prepare($sql);
        $result->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    /**
     * Returna in forma de text status categorie: 0 - ascuns, 1 - prezent
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Prezent';
                break;
            case '0':
                return 'Ascuns';
                break;
        }
    }
    /**
     * Adauga noua categorie
     */
    public static function createCategorie($denumire, $nrordine, $status)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO categorii (denumire, nrordine, status) '
                . 'VALUES (:denumire, :nrordine, :status)';
        $result = $db->prepare($sql);
        $result->bindParam(':denumire', $denumire, PDO::PARAM_STR);
        $result->bindParam(':nrordine', $nrordine, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
}