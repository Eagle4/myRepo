<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 03/04/2015
 * Time: 10:25
 */


require_once '..\config.php';


class DAO extends PDO {

    private static $_instance;

    /* Constructeur : héritage public obligatoire par héritage de PDO */
    public function __construct( ) {

    }
    // End of PDO2::__construct() */

    /* Singleton */
    public static function getInstance() {

        if (!isset(self::$_instance)) {

            try {

                self::$_instance = new PDO(SQL_CONF, SQL_USERNAME, SQL_PASSWORD);
                self::$_instance->query("SET CHARACTER SET utf8");

            } catch (PDOException $e) {
                echo $e;
            }
        }
        return self::$_instance;
    }
    // End of PDO::getInstance() */
}

// end of file */