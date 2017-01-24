<?php

	class Fight {

		private $fighter1;
		private $fighter2;

		function __construct(){
			$this->fighter1 = new Fighter(2, 120, 'Hubert');
			$this->fighter2 = new Fighter(8, 22, 'Michel');
		}

		function fight(){
			echo "Battoru! <br/>";
			echo $this->fighter1->getName()."'s health : ".$this->fighter1->getHealth()." / ".$this->fighter2->getName()."'s health : ".$this->fighter2->getHealth()."<br/>";
			while ((!$this->fighter1->isKill()) && (!$this->fighter2->isKill())) {
				echo $this->fighter1->getName()." attacks!<br/>";
				$this->fighter1->hit($this->fighter2);
				echo $this->fighter2->getName()." attacks!<br/>";
				$this->fighter2->hit($this->fighter1);
				echo $this->fighter1->getName()."'s health : ".$this->fighter1->getHealth()." / ".$this->fighter2->getName()."'s health : ".$this->fighter2->getHealth()."<br/>";
			}
		}

	}



	class Fighter {
		private $strength;
		private $health;
		private $exp;
		private $name;

		function __construct($strength, $health, $name){
			$this->strength = $strength;
			$this->health = $health;
			$this->name = $name;
			$this->exp = 0;
		}

		function getStrength(){return $this->strength;}
		function getXP(){return $this->exp;}
		function getName(){return $this->name;}
		function getHealth(){return $this->health;}
		function setStrength($strength){$this->strength = $strength;}
		function setXP($exp){$this->exp = $exp;}
		function setName($name){$this->name = $name;}
		function setHealth($health){$this->health = $health;}

		function hit($enemy){
			$enemy->setHealth($enemy->getHealth()-$this->getStrength());
		}

		function win(){
			$this->setXP($this->getXP()+100);
		}

		function isKill(){
			if ($this->getHealth() <= 0) {
				return true;
			}
			else return false;
		}

		function __destruct(){

		}
	}



	//main
	$fight = new Fight();
	$fight->fight();

?>