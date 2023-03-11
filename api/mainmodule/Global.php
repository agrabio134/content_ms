<?php

class GlobalMethods {
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function executeQuery($sql)
    {
        $data = array();
        $errmsg = "";
        $code = 0;

        try {
            $result = $this->pdo->query($sql)->fetchAll();
            if ($result) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                $code = 200;
                return array("code" => $code, "data" => $data);
            } else {
                $errmsg = 'No data found';
                $code = 404;
            }
        } catch(\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }
        return array("code" => $code, "errmsg" => $errmsg);
    }
    
    public function returnPayload($payload, $remarks, $message, $code)
    {
        $status = array("remarks" => $remarks, "message" => $message);
        http_response_code($code);
        return array("status" => $status, "payload" => $payload, "timestamp" => date_create());
    }
    
    public function insert($table_name, $data)
    {
        $fields = array_keys($data);
        $values = array_values($data);

        try {
            $counter = 0;
            $sql_str = "INSERT INTO $table_name (";
            foreach ($fields as $value) {
                $sql_str .= $value;
                $counter++;
                if ($counter < count($fields)) {
                    $sql_str .= ", ";
                }
            }
            $sql_str .= ") VALUES (" . str_repeat('?, ', count($values) - 1) . "?)";
            $sql = $this->pdo->prepare($sql_str);
            $sql->execute($values);
            return array("code" => 200, "remarks" => "success");
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }
        return array("code" => $code, "errmsg" => $errmsg);
    }
    
    public function update($table_name, $data, $condition_string)
    {
        $fields = array_keys($data);
        $values = array_values($data);

        // try
        try {
            $counter = 0;
            $sql_str = "UPDATE $table_name SET ";
            foreach ($fields as $index => $value) {
                if ($value === "recno_fld") {
                    continue;
                }
                $sql_str .= " $value = ?,";
            }
            $sql_str = rtrim($sql_str, ',');
            $sql_str .= " WHERE recno_fld = ?";
            $values[] = $data['recno_fld'];
            $sql = $this->pdo->prepare($sql_str);
            $sql->execute($values);
            return array("code" => 200, "remarks" => "success");
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }
        // return whatever..
        return array("code" => $code, "errmsg" => $errmsg);
    }
    public function delete($table_name, $condition_string){
        // sql stuff
        $sql = "DELETE FROM $table_name ";
        // if we have something delete it..
        if($condition_string!=null){
            $sql .= " WHERE {$condition_string}";
        }
        // try sql if worked..
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            return array("status code"=>200, "remarks"=>"deleted successfully!");
        }
        // catch errors..
        catch(Exception $e){
            $errmsg = $e->getMessage();
            $code = 403;
        }
        // return if worked and if not return error message..
        return array("code"=>$code, "errmsg"=>$errmsg);
    }
}
?>