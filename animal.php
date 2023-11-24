<?php

class Animal{
    
    

}

interface says{
    function b();
}



class Dog extends Animal implements says{

    function b(){
        return "汪";
    }

}

class Cat extends Animal implements says{

    function b(){
        return "喵";
    }


}

$dog=new Dog;
$cat=new Cat;

echo "狗叫".'"'.$dog->b().'"';
echo "<br>";
echo "貓叫".'"'.$cat->b().'"';

