<?php

require_once 'api/model/data_base.php';

class CategoryApiModel extends DataBase
{   
    public function getAllCategory()
    {
        $query = $this->db->prepare('SELECT * FROM category');
        $query->execute();
        $arr = $query->fetchAll(PDO::FETCH_OBJ);
        return $arr;
    }

    public function searchCategory($id_brand)
    {
        $query = $this->db->prepare('SELECT * FROM category WHERE id_category = ?');
        $query->execute([$id_brand]);
        $brand = $query->fetch(PDO::FETCH_OBJ);
        return $brand;
    }

    public function createCategory($newBrand)
    {
        $query = $this->db->prepare('INSERT INTO category (id_category, brand) VALUES (null,?)');
        $query->execute([$newBrand]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function deleteCategory($id_brand)
    {
        $query = $this->db->prepare('DELETE FROM category WHERE id_category = ?');
        $query->execute([$id_brand]);
        $status = $query->rowCount();
        return $status;     
    }
}
