<?php

class QueryBuilder
{
    protected $con;
    protected $tables = array();

    public function __construct(mysqli $con)
    {
        $this->con = $con;
        $tables = mysqli_query($con, "SHOW tables");

        while ($table = mysqli_fetch_row($tables)) {
            $this->tables[] = $table[0];
        }
    }
    
    public function selectAll($table)
    {
        if (in_array($table, $this->tables)) {
            $rows = mysqli_query($this->con, "SELECT * FROM {$table}");

            $result = array();
            while ($row = mysqli_fetch_assoc($rows)) {
                $result[] = $row;
            }
            
            return $result;
        }
    }

    public function selectById($table, $id)
    {
        if (in_array($table, $this->tables)) {
            $statement = mysqli_prepare(
                $this->con,
                "SELECT * FROM {$table} WHERE id = ?"
            );
            $statement->bind_param("i", $id);
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
        }
    }

    public function selectFieldsById($table, $fields, $id)
    {
        if (in_array($table, $this->tables)) {
            $statement = mysqli_prepare(
                $this->con,
                "SELECT * FROM {$table} WHERE id = ?"
            );
            $statement->bind_param("i", $id);
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
        }
    }

    public function selectWhere($table, $types, $content)
    {
        if (in_array($table, $this->tables) && count($content) > 0) {
            $query = "SELECT * FROM {$table} WHERE";
            $keys = implode("=? AND ", array_keys($content));
            $query .= " {$keys}=?;";
            $statement = mysqli_prepare($this->con, $query);
            $statement->bind_param($types, ...array_values($content));
               
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
        }
    }

    public function selectFieldsWhere($table, $fields, $types, $content)
    {
        if (in_array($table, $this->tables) && count($content) > 0) {
            $fields = implode(', ', $fields);
            $query = "SELECT {$fields} FROM {$table} WHERE";
            $keys = implode("=? AND ", array_keys($content));
            $query .= " {$keys}=?;";
            $statement = mysqli_prepare($this->con, $query);
            $statement->bind_param($types, ...array_values($content));
               
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
        }
    }

    public function insert($table, $types, $content)
    {
        if (in_array($table, $this->tables) && count($content) > 0) {
            $query = "INSERT INTO {$table}";
            $keys = implode(", ", array_keys($content));
            $query .= " ({$keys}) VALUES (?";
            for ($i = 0; $i < count($content) - 1; $i++) {
                $query .= ", ?";
            }
            $query .= ");";

            $statement = mysqli_prepare($this->con, $query);
            $statement->bind_param($types, ...array_values($content));
            $statement->execute();

            return $statement->insert_id;
        }
    }

    public function update($table, $id, $types, $content)
    {
        if (in_array($table, $this->tables) && count($content) > 0) {
            $query = "UPDATE {$table} SET ";
            $keys = implode("=? , ", array_keys($content));
            $query .= " {$keys}=? WHERE id = ?";
            $statement = mysqli_prepare($this->con, $query);

            $content['id'] = & $id;
            $types .= 'i';

            $statement->bind_param($types, ...array_values($content));
            $statement->execute();

            return $statement->insert_id;
        }
    }

    public function deleteById($table, $id)
    {
        if (in_array($table, $this->tables)) {
            $statement = mysqli_prepare(
                $this->con,
                "DELETE FROM {$table} WHERE id = ?"
            );
            $statement->bind_param("i", $id);
            $statement->execute();
        }
    }
}
