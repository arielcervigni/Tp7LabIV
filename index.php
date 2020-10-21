<?php

    require_once ("Models\Player.php");
    use Models\Player as Player;

    define("DB_HOST", "localhost");
    define("DB_NAME", "tp7");
    define("DB_USER", "root");
    define("DB_PASS", "");

    /*define("DB_HOST" , "181.31.70.211");
    define("DB_NAME" , "mydatabase");
    define("DB_USER" , "Ariel");
    define("DB_PASS" , "12345");*/

    $players = array ();
    $playersLeidos = array();
    $player = new Player ();

    $player->setCodePlayer("");
    $player->setFirstName("Matias");
    $player->setLastName("Portela");
    $player->setEmail("matiasportela@gmail.com");
    $player->setHoursPlayed("4.2");
    array_push($players, $player);

    grabar($player);
    $playersLeidos = leer();
    echo "<br> Listado de Players: <br>";
    mostrar($playersLeidos);


    echo "<br> Ahora actualizo el codePlayer 2, con 8 horas de juego <br>";
    #grabar($player);
    update(2,8);
    $playersLeidos = leer();
    mostrar($playersLeidos);

    #Si lo prueban, no va a funcionar porque el 5 ya no existe. Se va a agregar el 6. 

    echo "<br> Ahora borro el codePlayer 5 <br>";
    delete(5);
    $playersLeidos = leer();
    mostrar($playersLeidos);


    function grabar($player){
    try {
        $pdo = new PDO ("mysql:host=" .DB_HOST."; dbname=". DB_NAME , DB_USER , DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert  statement;

        $insertStatement = $pdo->prepare("INSERT INTO players (codePlayer, firstName, lastName, email, hoursPlayed)
                                          VALUES (:codePlayer, :firstName, :lastName, :email, :hoursPlayed)");

        $insertStatement->bindParam(":codePlayer", $player->getCodePlayer());
        $insertStatement->bindParam(":firstName", $player->getFirstName());
        $insertStatement->bindParam(":lastName", $player->getLastName());
        $insertStatement->bindParam(":email", $player->getEmail());
        $insertStatement->bindParam(":hoursPlayed", $player->getHoursPlayed());

        $insertStatement->execute();

    } catch (PDOException $PDOEx) {
        echo $PDOEx->getMessage();
    }

    }

    
    function leer (){  
    try {
        $pdo = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //Execute SELECT statement
        $selectStatement = $pdo->prepare("SELECT codePlayer, firstName, lastName, email, hoursPlayed FROM players");

        $selectStatement->execute();

        $result = $selectStatement->fetchAll();

        $playersLeidos = mapear($result);

        return $playersLeidos;


    } catch (PDOException $PDOEx) {
        echo $PDOEx->getMessage();
    }
    }

    function mapear ($value)
    {
        $value = is_array($value) ? $value : [];

        $resp = array_map(function ($p){ return new Player ($p['codePlayer'], $p['firstName'], $p['lastName'],
                               $p['email'], $p['hoursPlayed']);}, $value);

       return $resp;

    }

    function mostrar ($players)
    {
        foreach ($players as $player)
                {
                    echo "<br>CodePlayer: " . $player->getCodePlayer();
                    echo "<br>Nombre: " . $player->getFirstName();
                    echo "<br>Apellido: " . $player->getLastName();
                    echo "<br>Email: " . $player->getEmail();
                    echo "<br>Horas Jugadas: " . $player->getHoursPlayed(). "<br>"; 
                }
    }

    function update ($codePlayer, $nuevasHoras) 
    {
        $players = leer();
        $playersModificado = array();

            try {
                $pdo = new PDO ("mysql:host=" .DB_HOST."; dbname=". DB_NAME , DB_USER , DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $insertStatement = $pdo->prepare("UPDATE players SET hoursPlayed = $nuevasHoras where codePlayer = $codePlayer");
                $insertStatement->execute();

        
            } catch (PDOException $PDOEx) {
                echo $PDOEx->getMessage();
            }
                
    }
        
    function delete ($codePlayer)
    {
        try {
            $pdo = new PDO ("mysql:host=" .DB_HOST."; dbname=". DB_NAME , DB_USER , DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $insertStatement = $pdo->prepare(" DELETE from players WHERE codePlayer = $codePlayer ");
            $insertStatement->execute();
    
        } catch (PDOException $PDOEx) {
            echo $PDOEx->getMessage();
        }

    }

?>