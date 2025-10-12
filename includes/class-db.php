<?php
/**
 * Database Class
 * 
 * Handles all database operations using PDO
 */
class Database {
    private $connection;
    private static $instance = null;
    
    /**
     * Get database instance (Singleton pattern)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Private constructor - establishes database connection
     */
    private function __construct() {
        // Check if database constants are defined
        if (!defined('DB_HOST') || !defined('DB_NAME') || !defined('DB_USER') || !defined('DB_PASS')) {
            throw new Exception('Database configuration not found. Please define DB_HOST, DB_NAME, DB_USER, and DB_PASS in config.php');
        }
        
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            $this->handleError($e);
        }
    }
    
    /**
     * Connect to database (already connected in constructor)
     */
    public function connect() {
        return $this->connection !== null;
    }
    
    /**
     * Disconnect from database
     */
    public function disconnect() {
        $this->connection = null;
    }
    
    /**
     * Execute a query with optional parameters
     * 
     * @param string $sql SQL query
     * @param array $params Parameters for prepared statement
     * @return PDOStatement|false
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->handleError($e);
            return false;
        }
    }
    
    /**
     * Get a single row
     */
    public function getRow($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }
    
    /**
     * Get multiple rows
     */
    public function getResults($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }
    
    /**
     * Get a single value
     */
    public function getVar($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchColumn() : false;
    }
    
    /**
     * Insert data into a table
     * 
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @return int Last insert ID
     */
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $this->query($sql, $data);
        return $this->connection->lastInsertId();
    }
    
    /**
     * Update data in a table
     * 
     * @param string $table Table name
     * @param array $data Data to update
     * @param array $where Where conditions
     * @return int Number of affected rows
     */
    public function update($table, $data, $where) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(', ', $set);
        
        $whereClause = [];
        foreach ($where as $key => $value) {
            $whereClause[] = "$key = :where_$key";
            $data["where_$key"] = $value;
        }
        $whereClause = implode(' AND ', $whereClause);
        
        $sql = "UPDATE $table SET $set WHERE $whereClause";
        $stmt = $this->query($sql, $data);
        return $stmt ? $stmt->rowCount() : false;
    }
    
    /**
     * Delete data from a table
     * 
     * @param string $table Table name
     * @param array $where Where conditions
     * @return int Number of affected rows
     */
    public function delete($table, $where) {
        $whereClause = [];
        $params = [];
        
        foreach ($where as $key => $value) {
            $whereClause[] = "$key = :$key";
            $params[$key] = $value;
        }
        $whereClause = implode(' AND ', $whereClause);
        
        $sql = "DELETE FROM $table WHERE $whereClause";
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() : false;
    }
    
    /**
     * Add/Create a new table
     * 
     * @param string $tableName Table name
     * @param array $columns Column definitions
     * @return bool Success status
     */
    public function addTable($tableName, $columns) {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (";
        $columnDefs = [];
        
        foreach ($columns as $name => $def) {
            $columnDefs[] = "$name $def";
        }
        
        $sql .= implode(', ', $columnDefs);
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        return $this->query($sql) !== false;
    }
    
    /**
     * Remove/Drop a table
     * 
     * @param string $tableName Table name
     * @return bool Success status
     */
    public function removeTable($tableName) {
        $sql = "DROP TABLE IF EXISTS $tableName";
        return $this->query($sql) !== false;
    }
    
    /**
     * Update table structure (add column)
     * 
     * @param string $tableName Table name
     * @param string $columnName Column name
     * @param string $columnDef Column definition
     * @return bool Success status
     */
    public function updateTable($tableName, $columnName, $columnDef) {
        $sql = "ALTER TABLE $tableName ADD COLUMN $columnName $columnDef";
        return $this->query($sql) !== false;
    }
    
    /**
     * Check if a table exists
     * 
     * @param string $tableName Table name
     * @return bool
     */
    public function tableExists($tableName) {
        $sql = "SHOW TABLES LIKE :table";
        $stmt = $this->query($sql, ['table' => $tableName]);
        return $stmt && $stmt->rowCount() > 0;
    }
    
    /**
     * Get the raw PDO connection
     * 
     * @return PDO
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Handle database errors
     */
    private function handleError($e) {
        if (DEBUG) {
            die("Database Error: " . $e->getMessage());
        } else {
            error_log("Database Error: " . $e->getMessage());
            die("A database error occurred. Please try again later.");
        }
    }
    
    // Prevent cloning and unserializing
    private function __clone() {}
    private function __wakeup() {}
}

/**
 * Global helper function to get database instance
 */
function db() {
    return Database::getInstance();
}
