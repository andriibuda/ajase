<?php

namespace Drupal\ajase;

use Drupal\Core\Database\Connection;

/**
 * This is used to build query access.
 *
 * @ingroup ajase
 */
class AjaseDbLogic {

    /**
     * Database Connection.
     *
     * @var \Drupal\Core\Database\Connection
     */
    protected $database;

    /**
     * Construct object
     */
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    /**
     * Add new record
     */
    public function add($latitude, $longitude)
    {
        if (empty($latitude) || empty($longitude)) {
            return false;
        }
        $query = $this->database->insert('ajase');
        $query->fields(array(
            'latitude' => $latitude,
            'longitude' => $longitude,
        ));
        return $query->execute();
    }

    /**
     * Get record from database by Id
     */
    public function getById($id = NULL, $reset = FALSE)
    {
        $query = $this->database->select('ajase');
        $query->fields('ajase', array('id', 'latitude', 'longitude'));
           if ($id) {
               $query->condition('id', $id);
           }
        $result = $query->execute()->fetchAll();
        if (count($result)) {
            if ($reset) {
                $result = reset($result);
            }
            return $result;
        }
        return FALSE;
    }

    /**
     * Get all records for database
     */
    public function getAll()
    {
        return $this->getById();
    }
}
