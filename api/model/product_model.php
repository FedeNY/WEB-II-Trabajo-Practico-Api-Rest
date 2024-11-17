<?php

require_once 'api/model/data_base.php';


class ProductApiModel extends DataBase
{
    public function getProducts($brand, $order="asc")
    {

        $sql = "SELECT * FROM product ";

        if ($brand) {
            $sql .= 'WHERE id_brand = ?';
        }

        $sql .= 'ORDER BY offer_price ';

        if ($order == "desc")
            $sql .= 'DESC;';

        else
            $sql .= 'ASC;';

        $query = $this->db->prepare($sql);

        if ($brand) {
            $query->execute([$brand]);
        } else {
            $query->execute();
        }

        $arr = $query->fetchAll(PDO::FETCH_OBJ);
        return $arr;
    }

    public function getProductId($id)
    {
        $query = $this->db->prepare('SELECT * FROM product WHERE id = ?');
        $query->execute([$id]);
        $arr = $query->fetchAll(PDO::FETCH_OBJ);
        return $arr;
    }

    public function deleteProductId($id)
    {
        $query = $this->db->prepare('DELETE FROM product WHERE id = ?');
        $query->execute([$id]);
        $arr = $query->rowCount();
        return $arr;
    }

    public function updateProduct($product)
    {
        $query = $this->db->prepare('UPDATE product SET img = ?, name = ?, description = ?, camera = ?,  screen = ?, system = ?, id_brand = ?, gamma = ?, price = ?, offer = ?,  stock = ?, quota = ?, offer_price = ? WHERE id = ?');
        $query->execute($product);
        $status = $query->rowCount();
        return $status;
    }

    public function createProduct($product)
    {
        $query = $this->db->prepare('INSERT INTO product (id, img, name, description, camera, screen, system,  id_brand, gamma, price, offer, stock, quota, offer_price) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $query->execute($product);
        $id = $this->db->lastInsertId();
        return $id;
    }
}
