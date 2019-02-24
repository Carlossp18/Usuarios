<?php

/**
 * Description of BBDD
 *
 * @author alumno
 */
class BBDD {

    //put your code here
    private $conexion;
    private $info;
    private $host;
    private $user;
    private $pass;
    private $bd;

    public function __construct($host = "127.0.0.1", $user = "root", $pass = "", $bd = "dwes") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->conexion = new mysqli($host, $user, $pass, $bd);
    }

    public function __toString() {
        return $this->info;
    }

    public function checkState() {
        if ($this->conexion->errno == 0) {
            $this->info = "Conexión establecida correctamente";
            return 1;
        } else {
            $this->info = "Ha habido un error estableciendo la conexión";
            return 0;
        }
    }

    public function selectQuery($select) {
        $result = $this->conexion->query($select);
        return $this->getValues($result);
    }

    public function modifyQuery($query) {
        $result = $this->conexion->query($query);
        var_dump($result);
        return $result;
    }

    private function getValues($result) {
        $values = [];
        while ($array = $result->fetch_row()) {
            array_push($values, $array);
        }
        return $values;
    }

    public function existeValue($campo, $value, $tabla, $campoComprobacion, $extra = "") {
        $sentencia = "select count($campo) from $tabla where $campoComprobacion='$value' $extra";
        $valor = $this->conexion->query($sentencia);
        $existe = $valor->fetch_row();
        return $existe[0];

//$tulbas = $valor->num_rows;
        //return $tulbas;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }

    /**
     * 
     * @param string $tableName
     * @return array
     */
    public function nombresCampos($tableName) {
        $campos = [];
        $sql = "SHOW COLUMNS FROM $tableName";
        $res = $this->conexion->query($sql);
        while ($row = $res->fetch_assoc()) {
            $campos[] = $row['Field'];
        }
        return $campos;
    }

    function getInfo() {
        return $this->info;
    }

    function getHost() {
        return $this->host;
    }

    function getUser() {
        return $this->user;
    }

    function getPass() {
        return $this->pass;
    }

    function getBd() {
        return $this->bd;
    }

    function setInfo($info) {
        $this->info = $info;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setBd($bd) {
        $this->bd = $bd;
    }

    function getConexion() {
        return $this->conexion;
    }

    function setConexion($conexion) {
        $this->conexion = $conexion;
    }

}
