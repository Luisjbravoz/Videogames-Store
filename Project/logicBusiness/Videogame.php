<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * VIDEOGAME CLASS.
 */


class Videogame implements JsonSerializable {

    private $id;             //integer
    private $title;          //string
    private $idPlatform;     //integer
    private $idGenre;        //integer
    private $price;          //float
    private $quantity;       //integer

    public function __construct(int $id = -1, string $title = null, int $idPlatform = -1, int $idGenre = -1, float $price = -1.0, int $quantity = -1) {
        $this->id = $id;
        $this->title = $title;
        $this->idPlatform = $idPlatform;
        $this->idGenre = $idGenre;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getIdPlatform(): int {
        return $this->idPlatform;
    }

    public function getIdGenre(): int {
        return $this->idGenre;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function setIdPlatform(int $idPlatform) {
        $this->idPlatform = $idPlatform;
    }

    public function setIdGenre(int $idGenre) {
        $this->idGenre = $idGenre;
    }

    public function setPrice(float $price) {
        $this->price = $price;
    }

    public function setQuantity(int $quantity) {
        $this->quantity = $quantity;
    }

    public function __tostring(): string {
        $result = "<p>";
        foreach($this as $propertie => $value) {
            $result.= sprintf(Format::GET_FORMAT_OUTPUT_OBJECT(), strtoupper($propertie), $value);
        }
        return $result.="</p>";
    }

    public function equal(Videogame $object): bool {
        try {
        if(isset($object)) {
            return ($this->getId() === $object->getId() && 
                    $this->getTitle() === $object->getTitle() &&
                    $this->getIdPlatform() === $object->getIdPlatform() &&
                    $this->getIdGenre() === $object->getIdGenre() &&
                    $this->getPrice() === $object->getPrice() &&
                    $this->getQuantity() === $object->getQuantity()
                   );
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
    
    public function jsonSerialize() {
        return
                ["id" => $this->id,
                 "title" => $this->title,
                 "idPlatform" => $this->idPlatform,
                 "idGenre" => $this->idGenre,
                 "price" => $this->price,
                 "quantity" => $this->quantity];

    }

} // END CLASS
?>