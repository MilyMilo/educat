<?php

namespace EduCat\Core\Models;

use EduCat\Core\App;

/**
 * Model is the standalone, makeshift QueryBuilder
 * 
 * To use it just extend from this class, and use ModelFactory to create a instance of your model.
 */
abstract class Model
{
    public function __construct(\PDO $pdo, $table_name)
    {

        $this->pdo = $pdo;
        $this->table_name = $table_name;
        $this->property_prefix = "db_";

        // TODO: Move this to just be an array in object? 
        // TODO: How to do relations?
        // This gets all properties of $this whose name starts with db_ (that's how we determine which are DB types)
        $db_properties = array_filter(array_keys(get_object_vars($this)), [$this, '_is_db_property']);

        // Now we get the valid column names from our properties 
        $this->properties = array_map([$this, '_strip_db_prefix'], $db_properties);
        $this->columns = join(", ", $this->properties);
    }

    /**
     * Create a model using passed data.
     * Columns have to be a valid model property otherwise they will be ignored
     * All of the required columns have to be supplied, to use auto-increment pass NULL
     * Columns that have a default value, or are nullable do not have to be passed
     *
     * Example:
     * $News->create([
     *  "id" => NULL,
     *  "is_published" => TRUE,
     *  "title" => "New post",
     * ])
     * 
     * @param mixed[] $data Associative array of column names to column values
     * @return mixed Exec result
     */
    public function create($data)
    {
        $selected_cols = array_filter($data, [$this, "_is_col_name"], ARRAY_FILTER_USE_KEY);
        $parametrized_cols = array_map(function ($col_name) {
            return ":" . $col_name;
        }, array_keys($selected_cols));

        $cols = join(", ", array_keys($selected_cols));
        $params = join(", ", $parametrized_cols);

        $stmt = "INSERT INTO $this->table_name ($cols) VALUES ($params)";
        return $this->_exec($stmt, $selected_cols);
    }

    /**
     * Select all rows from model's table
     * 
     * @return mixed[] Resulting rows
     */
    public function select_all()
    {
        return $this->_fetch(
            "SELECT $this->columns FROM $this->table_name"
        );
    }

    /**
     * Select rows from model's table where $conditions are met
     * $conditions keys will be joined using $conditional to form a WHERE query
     * they have to be a valid model property otherwise they will be ignored
     * 
     * Example:
     * $News->select_where(["is_published" => TRUE])
     * $News->select_where(["is_published" => TRUE, "author" => "admin"], "OR")
     * 
     * @param mixed[] $conditions Associative array of column name to column value
     * @param string (optional) $conditional String to join the query conditions ("AND" - default / "OR")
     * @return mixed[] Resulting rows
     */
    public function select_where($conditions, $conditional = "AND")
    {
        $stmt = "SELECT $this->columns FROM $this->table_name " . $this->_build_where_statement($conditions, $conditional);

        return $this->_fetch(
            $stmt,
            $conditions
        );
    }

    public function select_one_where($conditions, $conditional = "AND")
    {
        $stmt = "SELECT $this->columns FROM $this->table_name " . $this->_build_where_statement($conditions, $conditional) . " LIMIT 1";

        return $this->_fetch(
            $stmt,
            $conditions
        )[0];
    }

    /**
     * Select single record with the id of $id
     * 
     * @param string|int $id id of the row to be retrieved  
     * @return mixed Resulting object
     */
    public function select_by_id($id)
    {
        return $this->select_where(["id" => $id])[0];
    }

    /**
     * Update rows from model's table where $conditions are met
     * $conditions keys will be joined using $conditional to form a WHERE query
     * they have to be a valid model property otherwise they will be ignored
     * 
     * Example:
     * $News->update_where(["title" => "New Title!"], ["is_published" => TRUE])
     * $News->update_where(["title" => "New Title!"], ["is_published" => TRUE, "author" => "admin"], "OR")
     * 
     * @param mixed[] $props Associative array of column name to new column value
     * @param mixed[] $conditions Associative array of column name to column value
     * @param string (optional) $conditional String to join the query conditions ("AND" - default / "OR")
     * @return mixed[] Resulting rows
     */
    public function update_where($props, $conditions, $conditional = "AND")
    {
        $stmt = "UPDATE $this->table_name SET ";
        $stmt .= $this->_build_kv_mapping($props) . " ";
        $stmt .= $this->_build_where_statement($conditions, $conditional);
        return $this->_exec($stmt, array_merge($props, $conditions));
    }

    /**
     * Update single record with the id of $id
     * 
     * @param mixed $props Associative array of column name to new column value
     * @param string|int $id id of the row to be updated
     * @return mixed Exec result
     */
    public function update_by_id($props, $id)
    {
        return $this->update_where($props, ["id" => $id]);
    }

    /**
     * Delete rows from model's table where $conditions are met
     * $conditions keys will be joined using $conditional to form a WHERE query
     * they have to be a valid model property otherwise they will be ignored
     * 
     * Example:
     * $News->delete_where(["is_published" => TRUE])
     * $News->delete_where(["is_published" => TRUE, "author" => "admin"], "OR")
     * 
     * @param mixed[] $conditions Associative array of column name to column value
     * @param string (optional) $conditional String to join the query conditions ("AND" - default / "OR")
     * @return mixed[] Exec results
     */
    public function delete_where($conditions, $conditional = "AND")
    {
        $stmt = "DELETE FROM $this->table_name " . $this->_build_where_statement($conditions, $conditional);
        return $this->_exec(
            $stmt,
            $conditions
        );
    }

    /**
     * Delete single record with the id of $id
     * 
     * @param string|int $id id of the row to be deleted
     * @return mixed Exec result
     */
    public function delete_by_id($id)
    {
        return $this->delete_where(["id" => $id]);
    }

    /**
     * This is a part of internal API
     */
    protected function _fetch($sql, $values = [])
    {
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute($values);
        } catch (\Exception $e) {
            if (App::get('config')['debug']) {
                $this->_dump_debug($e, $sql, $values);
                die();
            }
        }

        return $stmt->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * This is a part of internal API
     */
    protected function _exec($sql, $values = [])
    {
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($values);
        } catch (\Exception $e) {
            if (App::get('config')['debug']) {
                $this->_dump_debug($e, $sql, $values);
                die();
            }
        }

        return $stmt;
    }

    /**
     * This is a part of internal API
     */
    private function _is_db_property($property)
    {
        return has_prefix($property, $this->property_prefix);
    }

    /**
     * This is a part of internal API
     */
    private function _is_col_name($property)
    {
        return in_array($property, $this->properties, true);
    }

    /**
     * This is a part of internal API
     */
    private function _strip_db_prefix($property)
    {
        return strip_prefix($property, $this->property_prefix);
    }

    /**
     * This is a part of internal API
     */
    private function _build_where_statement($conditions, $conditional = "AND")
    {
        $stmt = "WHERE " . $this->_build_kv_mapping($conditions, $conditional);
        return $stmt;
    }

    /**
     * Build Key-Value Mappings for SQL queries
     * 
     * This build key->value sql statements out of supplied $props
     * Key should be a valid column name, existing in model's properties
     * If they are not, they will be omitted without an error!
     * 
     * Example:
     * _build_kv_mapping(["id" => "1", "is_published" => "1"])
     * will return "id = :id, is_published = :is_published"
     * 
     * By default it uses comma as a separator, however for joining in
     * WHERE queries it can also join using "AND" and "OR"
     * 
     * Example:
     * _build_kv_mapping(["id" => "1", "is_published" => "1"], "AND")
     * returns "id = :id AND is_published = :is_published"
     * 
     * This is a part of internal API
     * @param mixed[] $props Associative array or kv pairs to be joined
     * @param string (optional) $separator - String used to join kv pairs. Must be allowed ("," - default / "AND" / "OR")
     */
    private function _build_kv_mapping($props, $separator = ",")
    {
        $props = array_filter($props, [$this, "_is_col_name"], ARRAY_FILTER_USE_KEY);

        $allowed_separators = ["AND", "OR", ","];
        foreach ($props as $col_name => $col_value) {
            $stmt .= "$col_name = :$col_name";

            if ($col_name !== array_key_last($props)) {
                if (!in_array($separator, $allowed_separators, true))
                    $separator = ",";

                $stmt .= " $separator ";
            }
        }

        return $stmt;
    }

    /**
     * This is a part of internal API
     */
    private function _dump_debug($e, $sql, $values)
    {
        echo "<h4>SQL Error:</h4>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<h4>Query:</h4><pre>" . $sql . "</pre>";

        echo "<h4>Values:</h4><pre>";
        var_dump($values);
        echo "</pre>";

        echo "<h4>Backtrace:</h4>";
        echo "<pre>" . generate_call_tree($e) . "</pre>";
    }
}
