<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * USER CLASS.
 */


class User {

    private $username; //string
    private $password; //string

    public function __construct(string $username = null, string $password = null) {
        $this->username = $username;
        $this->password = $password;
    }
    
    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function __tostring(): string {
        $result = "<p>";
        foreach($this as $property => $value) {
            $result.= sprintf(Format::GET_FORMAT_OUTPUT_OBJECT(), strtoupper($property), $value);
        }
        return $result.="</p>";
    }

    public function equal($object): bool {
        try {
        if(isset($object)) {
            return ($this->getUsername() === $object->getUsername() && $this->getPassword() === $object->getPassword());
        }
        throw new MyException(MyException::GET_ERROR_NULL_REFERENCE());
        } catch(MyException $ex) {
            MyException::SHOW_ERROR($ex);
        }
        return false;
    }

    public function clone(): ?self {
       return unserialize(serialize($this));
    }

} //END CLASS

?>