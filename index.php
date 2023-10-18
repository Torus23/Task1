<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lab 2 &#9979; Game List Webpage</title>
</head>
<body>
    <?php

    class Game{
        public $title;
        public $genre;
        public $year;
        function __construct($title,$genre,$year){
            $this->title=$title;
            $this->genre=$genre;
            $this->year=$year;
        }
        function __toString(){
            return (string) "<td>".$this->title."</td>"."<td>".$this->genre."</td>"."<td>".$this->year."</td>";
        }
    }    
    $val = [new Game("Baldur's Gate 3","Role-Playing Game",2023),new Game("Total War: WARHAMMER III","Strategy",2022)
    ,new Game("Minecraft","Sandbox",2009),new Game("Baldur's Gate 2","Role-Playing Game",2000)
    ,new Game("The Elder Scrolls V: Skyrim","Role-Playing Game",2011),new Game("Divinity: Original Sin 2","Role-Playing Game",2017)
    ,new Game("Halo 2","First-person Shooter",2004),new Game("The Curse of Monkey Island","Adventure",1997)
    ,new Game("Final Fantasy XVI","Action Role-Playing Game",2023),new Game("Age of Mythology","Strategy",2002)];

    myGame($val);
    
    function myGame($list){
        echo"<h1>Logan's Favourite Games</h1>";
	    echo"<table>";
        echo"<tr>";
        echo"<th>Title</th>";
        echo"<th>Genre</th>";
        echo"<th>Year</th>";
        echo"</tr>";
        foreach($list as $item){
        echo"<tr>";
        echo  $item ;
        echo"</tr>";   
        }
        echo"</table>";
    }
    ?>
</body>
</html>