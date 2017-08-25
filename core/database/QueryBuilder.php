<?php

class QueryBuilder
{
    protected $con;
    protected $tables;

    public function __construct(mysqli $con)
    {
        $this->con = $con;
        $tables = mysqli_query($con, "SHOW tables");
        $this->tables = mysqli_fetch_row($tables);
    }
    
    public function selectAll($table)
    {
        if(in_array($table, $this->tables))
        {
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
        if(in_array($table, $this->tables))
        {
            $statement = mysqli_prepare($this->con, "SELECT * FROM {$table} WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();

            return $statement->get_result()->fetch_assoc();
            
        }
    }

    public function selectWhere($table, $types, $content)
    {
        if(in_array($table, $this->tables))
        {
            $dbColumns = mysqli_query($this->con, "SHOW columns FROM {$table}");
            
            $columns = array();
            while ($row = mysqli_fetch_assoc($dbColumns))
            {
                if($row["Key"] != "PRI")
				    $columns[] = $row["Field"];
            }

            $query = "SELECT * FROM {$table} WHERE";            
            
            $values = array();
            foreach($columns as $column)
            {
                if(array_key_exists($column, $content))
                {
                    $values[$column] = $content[$column];
                }
            }

            if(count($values) > 0)
            {
                $keys = implode("=? AND ", array_keys($values));
                $query .= " {$keys}=?;";
                
                $statement = mysqli_prepare($this->con, $query);

                $params[] = & $types;

                $values = array_values($values);
                for($i = 0; $i < count($values); $i++){
                    $params[] = & $values[$i];
                }

                call_user_func_array(array($statement, 'bind_param'), $params);

                $statement->execute();

                return $statement->get_result()->fetch_assoc();
            }
            
        }
    }

    public function insert($table, $types, $content)
    {
        if(in_array($table, $this->tables))
        {
            $dbColumns = mysqli_query($this->con, "SHOW columns FROM {$table}");
            
            $columns = array();
            while ($row = mysqli_fetch_assoc($dbColumns))
            {
                if($row["Key"] != "PRI")
				    $columns[] = $row["Field"];
            }

            $query = "INSERT INTO {$table}";
            
            $values = array();
            foreach($columns as $column)
            {
                if(array_key_exists($column, $content))
                {
                    $values[$column] = $content[$column];
                }
            }

            if(count($values) > 0)
            {
                $keys = implode(", ", array_keys($values));
                $query .= " ({$keys}) VALUES (?";
                for($i = 0; $i < count($values) - 1; $i++){
                    $query .= ", ?";
                }
                $query .= ");";

                $statement = mysqli_prepare($this->con, $query);

                $params[] = & $types;

                 $values = array_values($values);
                for($i = 0; $i < count($values); $i++){
                    $params[] = & $values[$i];
                }

                call_user_func_array(array($statement, 'bind_param'), $params);

                $statement->execute();

                 return $statement->insert_id;
            }
        }
    }

    public function update($table, $idType, $id, $types, $content)
    {
        if(in_array($table, $this->tables))
        {
            $types .= $idType;

            $dbColumns = mysqli_query($this->con, "SHOW columns FROM {$table}");
            
            $condition;

            $columns = array();
            while ($row = mysqli_fetch_assoc($dbColumns))
            {
                if($row["Key"] != "PRI")
                {
                    $columns[] = $row["Field"];
                }
                else
                {
                    $condition = " WHERE {$row["Field"]} = ?";
                }
				   
            }

            $query = "UPDATE {$table} SET ";
            
            $values = array();
            foreach($columns as $column)
            {
                if(array_key_exists($column, $content))
                {
                    $values[$column] = $content[$column];
                }
            }

            if(count($values) > 0)
            {
                $keys = implode("=? , ", array_keys($values));
                $query .= " {$keys}=? {$condition}";

                $statement = mysqli_prepare($this->con, $query);

                $params[] = & $types;

                $values = array_values($values);
                for($i = 0; $i < count($values); $i++){
                    $params[] = & $values[$i];
                }
                $params[] = & $id;

                call_user_func_array(array($statement, 'bind_param'), $params);

                $statement->execute();

                return $statement->insert_id;
            }
        }
    }

    public function deleteById($table, $id)
    {
        if(in_array($table, $this->tables))
        {
            $statement = mysqli_prepare($this->con, "DELETE FROM {$table} WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
        }
    }
}