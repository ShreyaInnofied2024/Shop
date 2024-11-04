<?php

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct()
  {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  public function query($sql)
  {
    $this->stmt = $this->dbh->prepare($sql);
  }



  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }


  public function execute()
  {
    return $this->stmt->execute();
  }

  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  public function delete($table, $conditions)
  {
    $conditionString = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));

    $sql = "DELETE FROM {$table} WHERE {$conditionString}";
    $this->query($sql);

    foreach ($conditions as $column => $value) {
      $this->bind(":$column", $value);
    }

    return $this->execute();
  }

  public function select($table, $columns = '*', $conditions = [])
  {
    $columnString = is_array($columns) ? implode(', ', $columns) : $columns;

    $sql = "SELECT {$columnString} FROM {$table}";

    if (!empty($conditions)) {
      $conditionString = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
      $sql .= " WHERE {$conditionString}";
    }

    $this->query($sql);

    foreach ($conditions as $column => $value) {
      $this->bind(":$column", $value);
    }

    return $this->resultSet();
  }

  public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data))); 
        $this->query("INSERT INTO $table ($columns) VALUES ($placeholders)");

        $this->bindParams($this->stmt, $data); 
        return $this->execute(); 
    }

    public function update($table, $data, $where)
    {
        $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $this->query("UPDATE $table SET $set WHERE $where");

        $this->bindParams($this->stmt, $data); 
        return $this->execute();
    }

    private function bindParams($stmt, $data)
    {
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value); 
        }
    }

    public function beginTransaction() {
      $this->dbh->beginTransaction();
  }

  // Commit the current transaction
  public function commit() {
      $this->dbh->commit();
  }

  // Roll back the current transaction
  public function rollBack() {
      $this->dbh->rollBack();
  }

  public function lastInsertId() {
    return $this->dbh->lastInsertId();
}
}
