<h1>WEB-II-Trabajo-Practico-Api-Rest</h1>

<h2>Integrante</h2>
<p><b>Federico Massolo</b><br>
DNI: 41.675.964</p>

<h2>Puntos desarrollados del TP</h2>

<h3>Obligatorios:</h3>
<ul>
    <li><b>La API Rest debe ser RESTful</b></li>
    <li><b>Debe tener al menos un servicio que liste (GET) una colección entera de entidades.</b></li>
    <li><b>El servicio que lista una colección entera debe poder ordenarse opcionalmente por al menos un campo de la tabla, de manera ascendente o descendente.</b></li>
    <li><b>Debe tener al menos un servicio que obtenga (GET) una entidad determinada por su ID.</b></li>
    <li><b>Debe tener al menos un servicio para agregar y otro para modificar datos (POST y PUT).</b></li>
    <li><b>La API Rest debe manejar de manera adecuada al menos los siguientes códigos de error (200, 201, 400 y 404).</b></li>
</ul>

<h3>Opcionales:</h3>
<ul>
    <li><b>El servicio que obtiene una colección entera debe poder filtrarse por alguno de sus campos.</b></li>
</ul>

<h2>End Points</h2>

<h2>Productos</h2>

<h3>Obtener Productos (GET):</h3>
<p>Obtiene un listado de todos los productos de la DB ordenados por el precio final (calculo resultado de la oferta y el precio base) ordenado defecto de forma ascendente.</p>
<p><b>Endpoint:</b><br>
/product</p>

`Obtener Productos ordenados de forma ascendente o descendente:`
<p>Se le puede especificar de qué forma debe devolver los productos, ya sea ascendente o descendente.</p>
<p><b>Ejemplo:</b><br>
/product?order=asc<br>
/product?order=desc</p>

`Filtrar productos por marca:`
<p>Obtiene un listado de los productos de la DB filtrados por la marca. Los devuelve de la misma forma que con "/product" pero de una marca específica.</p>
<p><b>Ejemplo:</b><br>
/product?brand=(nombre de la marca ej: motorola)</p>

<h3>Obtener un Producto por ID:</h3>
<p>Obtiene un solo producto especificado por el parámetro en base a su ID.</p>
<p><b>Endpoint:</b><br>
/product/:id<br>
<b>Ejemplo:</b><br>
/product/1</p>

<h3>Agregar un nuevo Producto (POST):</h3>
<p>Crea un producto en la base de datos si los datos proporcionados cumplen con las condiciones de las propiedades.</p>
<p><b>Endpoint:</b><br>
/product</p>
<p><b>Ejemplo de una solicitud en formato JSON de cómo debería ser el objeto a completar:</b></p>
<pre>
<code>{
  "img": "(https://www.cordobadigital.net/wp-content/uploads/2024/05/A55-5G.png",
  "name": "Samsung Galaxy A55 5G 256gb 8gb",
  "description": "Lorem Ipsum",
  "camera": "48",
  "system": "Android 12",
  "screen": "6.5",
  "id_brand": "1",
  "gamma": "high",
  "price": "150000",
  "offer": "50",
  "stock": "1",
  "quota": "12"
}</code>
</pre>

<h3>Requerimientos válidos de cada campo:</h3>
<p>Cualquier campo que no sea válido o esté vacío recibirá como resultado un error 400.</p>
<ul>
    <li><b>img:</b> dato de tipo <code>varchar</code> con una capacidad de 250 caracteres. El valor esperado de esta propiedad es la URL de una imagen copiada de internet.</li>
    <li><b>name:</b> dato de tipo <code>varchar</code> con una capacidad de 200 caracteres. El valor esperado es el nombre del producto.</li>
    <li><b>description:</b> dato de tipo <code>text</code>. El valor esperado es una descripción breve del producto.</li>
    <li><b>camera:</b> dato de tipo <code>double</code>. Esta propiedad no puede recibir un valor que sea igual o inferior a 0.</li>
    <li><b>system:</b> dato de tipo <code>varchar</code> con una capacidad de 30 caracteres. El valor esperado es el nombre del sistema operativo.</li>
    <li><b>screen:</b> dato de tipo <code>double</code>. Esta propiedad no puede recibir un valor que sea igual o inferior a 0.</li>
    <li><b>id_brand:</b> dato de tipo <code>int</code>, hace referencia al ID de categoría de otra tabla. El valor esperado es una ID existente en esa tabla. <i>Recomendación: hacer una solicitud GET a la tabla "category" para buscar una ID válida.</i></li>
    <li><b>gamma:</b> dato de tipo <code>varchar</code> con capacidad de 10 caracteres. El valor esperado es una de las tres opciones: "low", "medium" o "high".</li>
    <li><b>price:</b> dato de tipo <code>double</code>. El valor esperado es un número superior a 0.</li>
    <li><b>offer:</b> dato de tipo <code>double</code>. El valor esperado es un número entre 1 y 99.</li>
    <li><b>stock:</b> dato de tipo <code>boolean</code>. El valor esperado es 0 (sin stock) o 1 (con stock).</li>
    <li><b>quota:</b> dato de tipo <code>int</code>. El valor esperado es un valor numérico comprendido entre una de las siguientes opciones: 0 (sin cuotas sin interés), 6 (6 cuotas sin interés), 12 (12 cuotas sin interés).</li>
</ul>

<h3>Actualizar un Producto (PUT):</h3>
<p>Actualiza un producto proporcionando su ID por params. Si la ID no existe en la DB, recibirá un 404 indicando que el producto que quiere modificar no existe.</p>
<p><b>Endpoint:</b><br>
/product/:id<br>
<b>Ejemplo:</b><br>
/product/1</p>
<p><b>Importante:</b><br>
Antes de modificar un producto, primero obténgalo con una solicitud GET de todos los productos (<code>/product</code>) o, si sabe que la ID existe, obténgalo por ID (<code>/product/:id</code>) para tener el objeto JSON el cual quiere modificar y sólo tendría que modificar sus valores. (Revisar sección "Requerimientos válidos de cada campo" para saber qué tipo de datos son válidos para la solicitud).</p>
<p><b>Ejemplo de un producto obtenido:</b></p>
<pre>
<code>{
  "id": "6",
  "img": "(https://www.cordobadigital.net/wp-content/uploads/2024/05/A55-5G.png",
  "name": "Samsung Caross",
  "description": "Lorem",
  "camera": "42",
  "system": "Android 12",
  "screen": "6.5",
  "id_brand": "11",
  "gamma": "high",
  "price": "70000",
  "offer": "50",
  "offer_price": "0",
  "stock": "0",
  "quota": "12"
}</code>
</pre>
<ul><b>Importante:</b>
    <li>La propiedad <b>"id"</b> no debe ser modificada, ya que es un identificador que la misma DB utiliza para poder actualizar el producto buscándolo en la misma.</li>
    <li>La propiedad <b>"offer_price"</b> no debe ser modificada. Al realizarse la solicitud de actualización, se vuelve a calcular el valor a partir del <code>price</code> y <code>offer</code> que se le asignen.</li>
</ul>

<h3>Eliminar un producto (DELETE):</h3>
<p>Elimina un producto de la DB según la ID proporcionada. Si la ID no existe, recibirá un error en la solicitud. Si se realizó correctamente, recibirá un estatus 200 informando que la acción fue ejecutada con éxito.</p>
<p><b>Endpoint:</b><br>
/product/:id</p>
<p><b>Ejemplo:</b><br>
/product/1</p>

<h2>Categorias</h2>

<h3>Obtener todas las Categorias (GET):</h3>
<p>Obtiene un listado de todas las categorías ordenadas por ID.</p>
<p><b>Endpoint:</b><br>
/category</p>

<h3>Agregar una nueva Categoria (POST):</h3>
<p>Agrega una nueva categoría siempre que esa categoría no exista ya en la DB. El valor de la marca es pasado por el body del JSON.</p>
<p><b>Endpoint:</b><br>
/category</p>
<p><b>Ejemplo:</b></p><br>
<pre>
<code>{
  "brand":"motorola"
}</code>
</pre>
<p><b>Importante:</b> brand es una propiedad tipo <code>varchar</code> con una capacidad de 60 caracteres. La marca enviada siempre va a ser en minúscula independientemente de cómo fue escrito por el usuario.</p>

<h3>Borrar Categorias (DELETE):</h3>
<p>Borra la marca proporcionada por el parámetro de la solicitud. Antes de proceder, se verifica que la marca sea correcta.</p>
<p><b>Endpoint:</b><br>
/product/:brand</p>
<p><b>Ejemplo:</b><br>
/category/motorola</p>
<p><b>Importante:</b> Se recomienda antes hacer una solicitud GET "Obtener todas las categorias" para saber cuál marca desea borrar. Solo se eliminarán las marcas que no contengan ningún producto asociado.</p>







