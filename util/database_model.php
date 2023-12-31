<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


/** The class which is used for easy interacting with a database */
class DatabaseModel {
    protected mysqli $db;
    protected array $props;
    protected string $current_table = '';

    function __construct() {
        $this->props = [
            "host" => $_ENV["DB_HOST"],
            "user" => $_ENV["DB_USER"],
            "password" => $_ENV["DB_PASSWORD"],
            "name" => $_ENV["DB_NAME"],
            "port" => $_ENV["DB_PORT"]
        ];

        $this->db = new mysqli(...array_values($this->props));

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    /**
     * The function sets the current table to be used.
     * @param string $table A string that represents the name of the table that you want to use.
     */
    public function use_table(string $table): void {
        try {
            $this->current_table = $table;
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
    }

    /**
     * The function retrieves specified fields from the current table in a database and returns the
     * results as an associative array.
     *
     * @param string[] ...$fields List of field which you want to select from the table.
     *
     * @return array An array of rows fetched from the database table. Each row is represented as an
     * associative array, where the keys are the field names specified in the function arguments and the
     * values are the corresponding values from the database table.
     */
    public function get(string ...$fields): array {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }
            if(in_array("date", $fields)){
                $result = $this->db->query("SELECT " . join(", ", $fields) . " FROM {$this->props['name']}.{$this->current_table} ORDER BY date DESC" );
            } else{
                $result = $this->db->query("SELECT " . join(", ", $fields) . " FROM {$this->props['name']}.{$this->current_table}" );
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
        return array();
    }

    public function getQuery(string $query): array {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }

            $result = $this->db->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
        return array();
    }

    /**
     * The function finds records in a specified database table based on a given condition and returns the
     * selected fields as an array.
     *
     * @param string $condition The condition parameter is a string that represents the condition to be
     * used in the WHERE clause of the SQL query. It specifies the criteria that the rows must meet in
     * order to be included in the result set.
     *
     * @return array An array of rows from the database table that match the given condition.
     */
    public function find(string $condition): array {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }

            $result = $this->db->query("SELECT * FROM {$this->props['name']}.{$this->current_table} WHERE {$condition}");
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
        return array();
    }

    /**
     * The function creates a new record in a specified database table with the given data.
     *
     * @param array $record An associative array that contains the data to be inserted into
     * the database table. The keys of the array represent the column names, and the values
     * represent the corresponding values to be inserted into those columns.
     */
    public function create(array $record): void {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }

            $columns = join(", ", array_keys($record));
            $values = join(", ", array_map(fn ($item) => "'{$item}'", array_values($record)));

            $this->db->query("INSERT INTO {$this->current_table} ({$columns}) VALUES ({$values});");
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
    }

    public function update(array $record, string $condition): void {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }

            $updates = [];
            foreach ($record as $key => $value) {
                $updates[] = "$key = '$value'";
            }

            $updatesString = join(", ", $updates);

            $this->db->query("UPDATE {$this->current_table} SET $updatesString WHERE $condition;");
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
    }

    public function delete(string $condition): void {
        try {
            if ($this->current_table == '') {
                throw new Exception("The table is not specified! Please open some database table to work with");
            }
            $this->db->query("DELETE FROM {$this->current_table} WHERE $condition;");
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }
    }


    /**
     * Get all records from a database table.
     * @return array All the data from the database table.
     */
    public function all(): array {
        return $this->get("*");
    }
}