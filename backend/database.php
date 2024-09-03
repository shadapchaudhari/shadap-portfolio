<?php

class Database
{
    public $hostname;
    public $username;
    public $password;
    public $database;
    public $connection;

    public $messages = "amitkasabe";

    public $message = array();
    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Content-Type: application/json');
    }
    function __construct()
    {

        $this->setCorsHeaders();
        // echo $this->testVar;
        $env = parse_ini_file('.env');
        $this->hostname = $env['hostname'];
        $this->username = $env['username'];
        $this->password = $env['password'];
        $this->database = $env['DB'];


        // exit();        
        $this->connection = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        if (!$this->connection) {
            $this->message = ['message' => "Could not connect to database"];
        }

        // Set CORS headers for all responses

    }



    public function insert($data, $table, $param = null)
    {

        $columns = array_keys($data);
        $columns = implode(', ', $columns);
        $values = implode(", ", $data);
        // echo $values;
        $quotedData = array_map(function ($value) {
            return "'$value'";
        }, $data);

        // Use implode to join the quoted values with a comma and space
        $values = implode(", ", $quotedData);
        $insert = "INSERT INTO $table ($columns) values ($values)";
        echo $insert;
        $queryExecution = mysqli_query($this->connection, $insert);

        if ($queryExecution) {
            return "yes";
        } else {
            return "no";
        }
    }

    public function select($tableName, $param, $condition = null, $order = null)
    {

        $select = "SELECT $param from $tableName";

        $collectData = mysqli_query($this->connection, $select);
        // echo $collectData;

        $data = array(); // Initialize an array to store fetched data

        while ($row = mysqli_fetch_assoc($collectData)) {
            $data[] = $row;
        }

        return $data;
    }

    public function delete($tableName, $condition)
    {
        $delete = "DELETE FROM $tableName WHERE $condition";
        $deleteExecution = mysqli_query($this->connection, $delete);
        if ($deleteExecution) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update($tableName, $values)
    {
        // "UPDATE $table SET c1 = v1"

        $result = "";
        foreach ($values as $key => $value) {
            $result .= "$key = '$value', ";
        }

        // Remove the trailing comma and space
        $result = rtrim($result, ", ");


        $update = "UPDATE $tableName SET $result";
        $execute = mysqli_query($this->connection, $update);
        if ($execute) {
            return 1;
        } else {
            return 0;
        }
    }
}

$input = file_get_contents('php://input');
$input = json_decode($input, true);



$database = new Database();
$database->insert($input, "users");
