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

    public function __construct(int $id, string $productCode, string $productNAme, string $fromBatchNumber,string $toBatchNumber,
     string $fromLocation,string $toLocation,int $quantity, string $movementId,string $movementDate)
    {
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

    private static function getFilePath()
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

    public static function create($newData)
    {
        $dataArray = self::datosJsonParseados();

        $arrayErrores = validacionesDeMovement($newData);

        // if (existsObjectid($dataArray, $newData['productCode'], 'productCode')) {
        //     $arrayErrores["productCode"] = 'El código de producto ya está registrado';
        // }
        if (count($arrayErrores) > 0) { // Si el array de errores es mayor que 0, entonces  creo un array asociativo que mostrará la respuesta
            print_r($arrayErrores);
        } else {
            $newId = nextId($dataArray); // Llamo a la función nextId para asignarle un id correcto al nuevo objeto

            // Creo un objeto de la clase y asigno los datos con setters
            $newElement = new self($newId, '', '', '', '', '', '',0,'',''); // Inicializo el objeto con el nuevo ID
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
            $dataArray[] = [
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
            // Guardo en el JSON
            $newJsonData = json_encode($dataArray, JSON_PRETTY_PRINT);
            return file_put_contents(self::getFilePath(), $newJsonData) !== false;
        }
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
