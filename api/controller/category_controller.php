<?php

require_once './api/model/category_model.php';
require_once './api/model/product_model.php';
require_once './api/view/json.view.php';

class CategoryApiController
{
    private $model;

    private $modelProduct;

    private $view;

    public  function __construct()
    {
        $this->model = new CategoryApiModel();
        $this->modelProduct = new ProductApiModel();
        $this->view =  new Json_view();
    }

    public function categoryAdd($req)
    {   
        $statusBrand = $this->model->searchCategory($req->body->brand);

        if (isset($statusBrand))
            return $this->view->response("Error no se pudo realizar la solicitud porque falta la marca", 400);

        if ($statusBrand)
            return $this->view->response("Error esta marca ya existe", 400);

        $newBrand = strtolower($req->body->brand);

        $statusNewBrand = $this->model->createCategory($newBrand);

        if (!$statusNewBrand)
            return $this->view->response("Error fallo al crear la marca", 500);

        $brand = $this->model->searchCategory($statusNewBrand);

        $this->view->response($brand, 201);
    }

    public function categoryAll()
    {
        $arr = $this->model->getAllCategory();

        if (!$arr)
            return $this->view->response("Error se han encontrado marcas cargadas", 404);

        $this->view->response($arr, 200);
    }

    public function categoryDelete($req)
    {

        $brand = $req->params->brand;

        $brandStatus = $this->model->searchCategory($brand);

        if (!$brandStatus)
            return $this->view->response("Error al procesar la solicitud La marca '$brand' no existe", 400);

        $cantProduct = $this->modelProduct->getProducts($brandStatus->id_category);

        if ($cantProduct)
            return $this->view->response("Error al procesar la solicitud no se puede borrar una marca con productos asignados", 400);


        $deleteStatus = $this->model->deleteCategory($brandStatus->id_category);

        if (!$deleteStatus)
            return $this->view->response("Error al procesar la solicitud no ha podido realizar la eliminacion", 400);

        $this->view->response("La categoria fue eliminado con exito", 200);
    }
}
