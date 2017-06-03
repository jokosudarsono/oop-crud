<?php

namespace App\Libraries;

use \PDO;
use \App\Interfaces\CrudAble as CrudAble;

class Crud implements CrudAble
{
    private $db;
    private $field;
    private $table;

    /**
     * Object Constructor
     *
     * @param array $config PDO Configuration
     */
    public function __construct($config)
    {
        $this->db = new PDO($config['driver'], $config['user'], $config['password'], $config['option']);
    }

    /**
     * Set Table yang akan digunakan
     *
     * @param string
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * Setter Nama Field
     * @param  string
     */
    public function where($field)
    {
        $this->field = $field;
    }

    /**
     * Menambah Data Baru
     *
     * @param array
     */
    public function create(array $data)
    {
        if (is_array($data) && !empty($data)) {

            try {
                $field = array_keys($data);
                $bind = array();

                foreach ($field as $item) {
                    $bind[":$item"] = $data[$item];
                }

                $statement = $this->db->prepare('INSERT INTO ' . $this->table .'(' . implode(', ', $field) . ')VALUES(:' . implode(', :', $field) . ')');

                $statement->execute($bind);

            } catch (PDOException $e) {
                echo 'Kesalahan ! ' . $e->getMessage();
            }

        } else {
            die('Format data salah');
        }
    }

    /**
     * Mengambil Data dari Database
     *
     * @param integer
     * @return Object
     */
    public function read($id)
    {
        try {
            $statement = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $this->field . '=:param');
            $statement->bindParam(':param', $id);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo 'Kesalahan ! ' . $e->getMessage();
        }
    }

    /**
     * Update Data
     *
     * @param integer
     * @param array
     */
    public function update($id, array $data)
    {
        if (is_array($data) && !empty($data) && !empty($id)) {

            try {
                $field = array_keys($data);
                $bind = array();
                $count = 0;
                $sql = 'UPDATE ' . $this->table . ' SET ';

                foreach ($field as $item) {
                    $bind[":$item"] = $data[$item];

                    if ($count > 0) {
                        $sql .= ', ';
                    }
                    $sql .= $item . '=:' . $item;
                    $count++;
                }

                $bind[":$this->field"] = $id;
                $sql .= ' WHERE ' . $this->field . '=:' . $this->field;

                $statement = $this->db->prepare($sql);
                $statement->execute($bind);

            } catch (PDOException $e) {
                echo 'Kesalahan ! ' . $e->getMessage();
            }

        } else {
            die('Format Data Salah!');
        }
    }

    /**
     * Menghapus Data dari Database
     *
     * @param integer
     */
    public function delete($id)
    {
        try {
            $statement = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->field . '=:param');
            $statement->bindParam(':param', $id);
            $statement->execute();

        } catch (PDOException $e) {
            echo 'Kesalahan ! ' . $e->getMessage();
        }
    }
}
