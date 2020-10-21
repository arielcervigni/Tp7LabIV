<?php 

    namespace Models;
    
    class Player {

        private $codePlayer;
        private $firstName;
        private $lastName;
        private $email;
        private $hoursPlayed;

        public function __construct($codePlayer="" , $firstName="", $lastName="", $email="", $hoursPlayed=0) 
        {
            $this->codePlayer = $codePlayer;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->hoursPlayed = $hoursPlayed;
        }
        
        public function getCodePlayer () { return $this->codePlayer; }
        public function getFirstName () { return $this->firstName; }
        public function getLastName () { return $this->lastName; }
        public function getEmail () { return $this->email; }
        public function getHoursPlayed () { return $this->hoursPlayed; }

        public function setCodePlayer ($codePlayer) { $this->codePlayer = $codePlayer; }
        public function setFirstName ($firstName) { $this->firstName = $firstName; }
        public function setLastName ($lastName) { $this->lastName = $lastName; }
        public function setEmail ($email) { $this->email = $email; }
        public function setHoursPlayed ($hoursPlayed) { $this->hoursPlayed = $hoursPlayed; }


    }
?>