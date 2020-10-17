<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MODEL.
 */

include '../exception/MyException.php';
include '../format/Format.php';
include '../logicBusiness/User.php';
include '../logicBusiness/Videogame.php';
include '../validate/Check.php';
include '../accessData/ManagerConexionDB.php';
include '../accessData/ManagerUser.php';
include '../accessData/ManagerPlatform.php';
include '../accessData/ManagerGenre.php';
include '../accessData/ManagerVideogame.php';


 class Model {

    private static $INSTANCE = null;     //self
    private $username;                  //string

    private function Model() {
        $this->username = null;
    }

    public static function getInstance(): self {
        if(self::$INSTANCE === null) {
            self::$INSTANCE = new Model();
        }
        return self::$INSTANCE;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }

    public function check(string $username, string $password): bool {
        return ManagerUser::getInstance()->check($username, $password);
    }

    public function insertVideogame(Videogame $object): bool {
        return ManagerVideogame::getInstance()->insert($object);
    }

    public function updateVideogame(Videogame $object): bool {
        return ManagerVideogame::getInstance()->update($object);
    }

    public function deleteVideogame(int $id): bool {
        return ManagerVideogame::getInstance()->delete($id);
    }

    public function consultVideogame(int $id): Videogame {
        return ManagerVideogame::getInstance()->consult($id);
    }

    public function listVideogame() {
        return ManagerVideogame::getInstance()->list();
    }

    public function listGenre() {
        return ManagerGenre::getInstance()->list();
    }

    public function listPlatform() {
        return ManagerPlatform::getInstance()->list();
    }

 } //END CLASS

 ?>