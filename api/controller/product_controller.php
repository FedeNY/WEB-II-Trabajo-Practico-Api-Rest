<?php

require_once 'api/model/product_model.php';
require_once 'api/model/category_model.php';
require_once 'api/view/json.view.php';

class ProductApiController
{
    private $model;

    private $modelCategory;

    private $view;

    public  function __construct()
    {
        $this->model = new ProductApiModel();
        $this->modelCategory = new CategoryApiModel();
        $this->view = new Json_view();
    }

    public function productGet($req)
    {

        $brandParam = null;
        $id_brand = null;

        //Verifica que la marca que le pasamos exista

        if (isset($req->query->brand))
            $brandParam = $req->query->brand;


        if ($brandParam) {

            $categoryBrand = $this->modelCategory->getAllCategory();

            $status = false;

            foreach ($categoryBrand as $brand) {
                if ($brandParam === $brand->brand) {
                    $status = true;
                    $id_brand = $brand->id_category;
                }
            }

            if ($status == false)
                return $this->view->response("Error marca invalida", 400);
        }

        //Verifica que el orden que le pasamos sea correcto    

        $order = 'asc';

        if (isset($req->query->order) && ($req->query->order === 'asc' || $req->query->order === 'desc'))
            $order = $req->query->order;

        else if (isset($req->query->order) && ($req->query->order !== 'asc' || $req->query->order !== 'desc'))
            return $this->view->response("Error orden invalido", 400);

        //Ejecuta la consulta 

        $products = $this->model->getProducts($id_brand, $order);

        if (!$products)
            return $this->view->response("Error no se han encontrado productos", 404);

        $this->view->response($products);
    }

    public function ProductId($req)
    {
        $id = $req->params->id;

        $arr = $this->model->getProductId($id);

        if (!$arr)
            return $this->view->response("Producto #$id no encontrado", 404);

        $this->view->response($arr);
    }
    public function productDelete($req)
    {
        $id = $req->params->id;

        $arr = $this->model->getProductId($id);

        if (!$arr)
            return $this->view->response("Producto #$id no encontrado", 404);

        $this->model->deleteProductId($id);

        $arr = $this->model->getProductId($id);

        if ($arr) {
            return $this->view->response("El producto no pudo eliminarse", 500);
        }

        $this->view->response("El producto fue eliminado con exito", 200);
    }

    public function productUpdate($req)
    {
        // Verificacion de existencia del producto

        $id = $req->params->id;

        $arr = $this->model->getProductId($id);

        if (!$arr)
            return  $this->view->response("Producto #$id no encontrado", 404);

        // Validaciones de datos y declaraciones de datos

        $product = array(
            $req->body->img,
            $req->body->name,
            $req->body->description,
            $req->body->camera,
            $req->body->screen,
            $req->body->system,
            $req->body->id_brand,
            $req->body->gamma,
            $req->body->price,
            $req->body->offer,
            $req->body->stock,
            $req->body->quota,
        );

        foreach ($product as $specification) {
            if (!isset($specification) || $specification === "")
                return  $this->view->response("Error al procesar la solicitud falta de datos", 400);
        };

        // Verifica la existencia de la marca asignada.

        $categoryBrand = $this->modelCategory->getAllCategory();
        $status = false;
        foreach ($categoryBrand as $brand) {
            if ($req->body->id_brand === $brand->id_category) {
                $status = true;
            }
        }


        if ($status == false)
            return $this->view->response("Error marca invalida", 400);


        if ($req->body->stock > 1 || $req->body->price <= 0 || $req->body->screen <= 0 || $req->body->camera <= 0 || $req->body->offer >= 100 || $req->body->offer < 0 || ($req->body->quota != 0 && $req->body->quota != 6 && $req->body->quota != 12 && $req->body->quota != 612))
            return  $this->view->response("Error datos invalidos", 400);



        if ($req->body->stock > 1 || $req->body->price <= 0 || $req->body->screen <= 0 || $req->body->camera <= 0 || $req->body->offer > 100 || $req->body->offer < 0 || ($req->body->quota != 0 && $req->body->quota != 6 && $req->body->quota != 12 && $req->body->quota != 612))
            return  $this->view->response("Error datos invalidos", 400);

        // Calcula el nuevo precio de oferta    

        $offer_price = $req->body->price - ($req->body->price * ($req->body->offer / 100));

        array_push($product, $offer_price, $id);

        // Actualiza y recibe un estado 

        $statusUpdate = $this->model->updateProduct($product);

        if (!$statusUpdate)
            return  $this->view->response("Se ha producido un error, no se han realizado cambios", 500);

        $arr = $this->model->getProductId($id);

        $this->view->response($arr, 200);
    }
    public function productAdd($req)
    {

        $product = array(
            $req->body->img,
            $req->body->name,
            $req->body->description,
            $req->body->camera,
            $req->body->screen,
            $req->body->system,
            $req->body->id_brand,
            $req->body->gamma,
            $req->body->price,
            $req->body->offer,
            $req->body->stock,
            $req->body->quota,
        );

        foreach ($product as $specification) {
            if (!isset($specification) || $specification === "")
                return  $this->view->response("Error al procesar la solicitud falta de datos", 400);
        };

        // Verifica la existencia de la marca asignada.

        $categoryBrand = $this->modelCategory->getAllCategory();
        $status = false;
        foreach ($categoryBrand as $brand) {
            if ($req->body->id_brand === $brand->id_category) {
                $status = true;
            }
        }


        if ($status == false)
            return $this->view->response("Error marca invalida", 400);


        if ($req->body->stock > 1 || $req->body->price <= 0 || $req->body->screen <= 0 || $req->body->camera <= 0 || $req->body->offer >= 100 || $req->body->offer < 0 || ($req->body->quota != 0 && $req->body->quota != 6 && $req->body->quota != 12))
            return  $this->view->response("Error datos invalidos", 400);



        // Calcula el precio de oferta    

        $offer_price = $req->body->price - ($req->body->price * ($req->body->offer / 100));

        array_push($product, $offer_price);

        $id = $this->model->createProduct($product);

        if (!$id)
            return  $this->view->response("Error no se ha podido crear el producto", 400);

        $productCreated = $this->model->getProductId($id);

        $this->view->response($productCreated, 201);
    }
}
