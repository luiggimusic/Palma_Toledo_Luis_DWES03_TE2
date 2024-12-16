<?php

/** Definición del modelo con su tipo de dato e importo el fichero JSON
 **/
class Movement
{
    private int $id;
    private string $productCode;
    private string $productNAme;
    private string $fromBatchNumber;
    private string $toBatchNumber;
    private string $fromLocation;
    private string $toLocation;
    private int $quantity;
    private string $movementId;
    private string $movementDate;

    // Constructor para inicializar propiedades

    public function __construct(
        int $id,
        string $productCode,
        string $productNAme,
        string $fromBatchNumber,
        string $toBatchNumber,
        string $fromLocation,
        string $toLocation,
        int $quantity,
        string $movementId,
        string $movementDate
    ) {
        $this->id = $id;
        $this->productCode = $productCode;
        $this->productNAme = $productNAme;
        $this->fromBatchNumber = $fromBatchNumber;
        $this->toBatchNumber = $toBatchNumber;
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->quantity = $quantity;
        $this->movementId = $movementId;
        $this->$movementDate = $movementDate;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getProductCode()
    {
        return $this->productCode;
    }
    public function getProductName()
    {
        return $this->productNAme;
    }
    public function getFromBatchNumber()
    {
        return $this->fromBatchNumber;
    }
    public function getToBatchNumber()
    {
        return $this->toBatchNumber;
    }
    public function getFromLocation()
    {
        return $this->fromLocation;
    }
    public function getToLocation()
    {
        return $this->toLocation;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getMovementId()
    {
        return $this->movementId;
    }
    public function getMovementDate()
    {
        return $this->movementDate;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }
    public function setProductName($productNAme)
    {
        $this->productNAme = $productNAme;
    }
    public function setFromBatchNumber($fromBatchNumber)
    {
        $this->fromBatchNumber = $fromBatchNumber;
    }
    public function setToBatchNumber($toBatchNumber)
    {
        $this->toBatchNumber = $toBatchNumber;
    }
    public function setFromLocation($fromLocation)
    {
        $this->fromLocation = $fromLocation;
    }
    public function setToLocation($toLocation)
    {
        $this->toLocation = $toLocation;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function setMovementId($movementId)
    {
        $this->movementId = $movementId;
    }
    public function setMovementDate($movementDate)
    {
        $this->movementDate = $movementDate;
    }

    public static function getFilePath()
    { // Por visualización he creado esta función decodificando el JSON y poder usarlo en las otras funciones
        return __DIR__ . '/../models/data/movement.json'; // Ruta del archivo JSON
    }

    private static function datosJsonParseados()
    { // Por visualización he creado esta función decodificando el JSON y poder usarlo en las otras funciones
        return json_decode(self::getAll(), true);
    }

    // Método estático getAll para obtener todos los datos del JSON
    public static function getAll()
    {
        $filePath = self::getFilePath(); // Ruta del archivo JSON
        $jsonData = file_get_contents($filePath); // Leo el archivo JSON
        return $jsonData; // Retorno el array con los datos
    }

    public static function getById($id)
    {
        $dataArray = self::datosJsonParseados();
        $result = getElementById($dataArray, $id);
        if (!$result) {
            echo "Movimiento no encontrado";
        } else {
            echo $result;
        };
    }
    public static function getByData($data)
    {
        $dataArray = self::datosJsonParseados();

        // Filtro datos
        // Serán opcionales todas las opciones de búsqueda, filtrándose según se le pasen los criterios
        $filteredData = array_filter($dataArray, function ($item) use ($data) {

            // Verifico coincidencia de productCode para que muestre todos los elementos en caso  que no se asigne ningún valor ['productCode'] === ''
            // Lo mismo sucederá con los siguientes criterios de búsqueda
            $matchProductCode = !isset($data['productCode']) ||
                $data['productCode'] === '' ||
                (isset($item['productCode'], $data['productCode']) &&
                    $item['productCode'] === $data['productCode']);

            $matchFromBatchNumber = !isset($data['fromBatchNumber']) ||
                $data['fromBatchNumber'] === '' ||
                (isset($item['fromBatchNumber'], $data['fromBatchNumber']) &&
                    $item['fromBatchNumber'] === $data['fromBatchNumber']);

            $matchToBatchNumber = !isset($data['toBatchNumber']) ||
                $data['toBatchNumber'] === '' ||
                (isset($item['toBatchNumber'], $data['toBatchNumber']) &&
                    $item['toBatchNumber'] === $data['toBatchNumber']);

            $matchFromLocation = !isset($data['fromLocation']) ||
                $data['fromLocation'] === '' ||
                (isset($item['fromLocation'], $data['fromLocation']) &&
                    $item['fromLocation'] === $data['fromLocation']);

            $matchToLocation = !isset($data['toLocation']) ||
                $data['toLocation'] === '' ||
                (isset($item['toLocation'], $data['toLocation']) &&
                    $item['toLocation'] === $data['toLocation']);

            $matchQuantity = !isset($data['quantity']) ||
                $data['quantity'] === '' ||
                (isset($item['quantity'], $data['quantity']) &&
                    $item['quantity'] === $data['quantity']);

            $matchMovementId = !isset($data['movementId']) ||
                $data['movementId'] === '' ||
                (isset($item['movementId'], $data['movementId']) &&
                    $item['movementId'] === $data['movementId']);

            $matchMovementDate = !isset($data['movementDate']) ||
                $data['movementDate'] === '' ||
                (isset($item['movementDate'], $data['movementDate']) &&
                    $item['movementDate'] === $data['movementDate']);

            return $matchProductCode && $matchMovementId && $matchFromBatchNumber && $matchToBatchNumber && $matchFromLocation
                && $matchToLocation &&  $matchQuantity &&  $matchMovementDate;
        });

        if (empty($filteredData)) {
            echo "No se encontraron movimientos.";
            return;
        }

        // Convierto el resultado filtrado a JSON
        $result = json_encode(array_values($filteredData), JSON_PRETTY_PRINT);

        // Muestro el resultado
        echo $result;
    }

    public static function create($newData)
    {
        $movementDataArray = self::datosJsonParseados();
        $productsDataArray = Product::datosJsonParseados();


        // Convertir arrays a objetos Product
        $productObjectsArray = [];
        foreach ($productsDataArray as $productData) {
            $productObjectsArray[] = new Product(
                $productData['id'],
                $productData['productCode'],
                $productData['productName'],
                $productData['batchNumber'],
                $productData['location'],
                $productData['quantity'],
                $productData['category']
            );
        }


        // Verifico que exista stock exactamente en la ubicación que se indica
        foreach ($productObjectsArray as $product) {
            if (

                $product->getProductCode() === $newData['productCode']
                && $product->getBatchNumber() === $newData['fromBatchNumber']
                && $product->getLocation() === $newData['fromLocation']
            ) {
                // Validar si hay suficiente cantidad
                if ($product->getQuantity() >= $newData['quantity']) {
                    // Restar la cantidad solicitada
                    $newQuantity = $product->getQuantity() - $newData['quantity'];
                    $product->setQuantity($newQuantity);

                    var_dump($product->getQuantity());

                    $success['quantity'] = 'Stock actualizado correctamente';
                } else {
                    // Error: stock insuficiente
                    $arrayErrores['quantity'] = 'No hay stock suficiente para mover';
                    break; // Salimos del bucle si hay un error
                }
            }
        }

        var_dump($productObjectsArray);




        $arrayErrores = validacionesDeMovement($newData);

        if (!existsObjectId($productsDataArray, $newData['productCode'], 'productCode')) { // Verifica si el producto está registrado en product.json
            $arrayErrores["productCode"] = 'El producto no está registrado';
        }











        if (count($arrayErrores) > 0) { // Si el array de errores es mayor que 0, entonces  creo un array asociativo que mostrará la respuesta
            print_r($arrayErrores);
        } else {
            $newId = nextId($movementDataArray); // Llamo a la función nextId para asignarle un id correcto al nuevo objeto

            // Creo un objeto de la clase y asigno los datos con setters
            $newElement = new self($newId, '', '', '', '', '', '', 0, '', ''); // Inicializo el objeto con el nuevo ID
            $newElement->setProductCode($newData['productCode']);
            $newElement->setProductName($newData['productName']);
            $newElement->setFromBatchNumber($newData['fromBatchNumber']);
            $newElement->setToBatchNumber($newData['toBatchNumber']);
            $newElement->setFromLocation($newData['fromLocation']);
            $newElement->setToLocation($newData['toLocation']);
            $newElement->setQuantity($newData['quantity']);
            $newElement->setMovementId($newData['movementId']);
            $newElement->setMovementDate($newData['movementDate']);

            // Convierto el objeto de la clase a un array para guardarlo en el JSON
            $movementDataArray[] = [
                'id' => $newElement->getId(),
                'productCode' => $newElement->getProductCode(),
                'productName' => $newElement->getProductName(),
                'fromBatchNumber' => $newElement->getFromBatchNumber(),
                'toBatchNumber' => $newElement->getToBatchNumber(),
                'fromLocation' => $newElement->getFromLocation(),
                'toLocation' => $newElement->getToLocation(),
                'quantity' => $newElement->getQuantity(),
                'movementId' => $newElement->getMovementId(),
                'movementDate' => $newElement->getMovementDate(),
            ];




            // Convertir array de objetos a array asociativo 
            // $productsDataArray = []; 
            foreach ($productObjectsArray as $product) {
                $productsDataArrayUpdated[] = [
                    'id' => $product->getId(),
                    'productCode' => $product->getProductCode(),
                    'productName' => $product->getProductName(),
                    'batchNumber' => $product->getBatchNumber(),
                    'location' => $product->getLocation(),
                    'quantity' => $product->getQuantity(),
                    'category' => $product->getCategory()
                ];
            }



            // Ejemplo de llamada a la función
            $results = self::saveData($movementDataArray, $productsDataArrayUpdated);
            if ($results['movementsSaved'] && $results['productSaved']) {
                echo "Datos guardados correctamente.";
            } else {
                echo "Error al guardar los datos.";
            }



            // // Guardo en el JSON de movimientos
            // $newJsonDataMovements = json_encode($dataArray, JSON_PRETTY_PRINT);
            // return file_put_contents(self::getFilePath(), $newJsonDataMovements) !== false;



            // // Guardo en el JSON de producto
            // $newJsonDataProduct = json_encode($productsDataArray, JSON_PRETTY_PRINT);
            // return file_put_contents(Product::getFilePath(), $newJsonDataProduct) !== false;
        }
    }






    public static function saveData($movementDataArray, $productsDataArray)
    {
        // Guardar en el JSON de movimientos
        $newJsonDataMovements = json_encode($movementDataArray, JSON_PRETTY_PRINT);
        $resultMovements = file_put_contents(self::getFilePath(), $newJsonDataMovements) !== false;
        var_dump($resultMovements);

        // Guardar en el JSON de producto
        $newJsonDataProduct = json_encode($productsDataArray, JSON_PRETTY_PRINT);
        $resultProduct = file_put_contents(Product::getFilePath(), $newJsonDataProduct) !== false;


        // Devolver resultados de ambas operaciones
        return [
            'movementsSaved' => $resultMovements,
            'productSaved' => $resultProduct
        ];
    }
}

/*********** Funciones necesarias ***********/

















function validacionesDeMovement($data)
{
    // Valido los datos insertados en body (formulario) y voy completando el array $arrayErrores con los errores que aparezcan
    // En el caso de producto, fromBatchNumber, location y quantity pueden estar vacíos; especialmente cuando se trata de un producto nuevo
    $arrayErrores = array();
    if (empty($data["productCode"])) {
        $arrayErrores["productCode"] = 'El Código del producto es obligatorio';
    }
    if (empty($data["productName"])) {
        $arrayErrores["productName"] = 'El nombre del producto es obligatorio';
    }
    if (empty($data["fromBatchNumber"])) {
        $arrayErrores["fromBatchNumber"] = 'El lote de origen es obligatorio';
    }
    if (empty($data["toBatchNumber"])) {
        $arrayErrores["toBatchNumber"] = 'El lote de destino es obligatorio';
    }
    if (empty($data["fromLocation"])) {
        $arrayErrores["fromLocation"] = 'La ubicación de origen es obligatoria';
    }
    if (empty($data["toLocation"])) {
        $arrayErrores["toLocation"] = 'La ubicación de destino es obligatoria';
    }
    if (empty($data["quantity"])) {
        $arrayErrores["quantity"] = 'La cantidad es obligatoria';
    }
    if (empty($data["movementId"])) {
        $arrayErrores["movementId"] = 'El tipo de movimiento es obligatorio';
    }
    if (empty($data["movementDate"])) {
        $arrayErrores["movementDate"] = 'La fecha del movimiento es obligatoria';
    }
    return $arrayErrores;
}
