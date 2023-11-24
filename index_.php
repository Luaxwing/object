<?php

class Animal{
    public $name;

    // public function __construct($name){
        // echo "hi";
    //     $this->name=$name;
    // }

    // private $name;
    public function setName($name){
        $this->name=$name;
    }
    public function getName($name){
        return $this->name;
    }
    

}

echo "<hr>";
// $animal=new Animal('阿明');
 //實體化
$animal=new Animal;
echo $animal->name;
echo "<hr>";

// $animal->getName('小花');
// echo $animal->getName('小葵');



$animal->setName('小花');
echo $animal->name;
echo "<br>";

// $animal->name='阿忠';
// echo $animal->name;
// echo "<br>";

