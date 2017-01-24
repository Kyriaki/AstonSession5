<?php


	define("DB", 'zabooks');
	define("HOST", 'localhost');
	define("USER", 'root');
	define("PASS", '');



	function dbConnect(){
		$db = mysqli_connect(HOST, USER, PASS, DB);
		return $db;
	}

	function getBooks(){
		$db = dbConnect();
		$sql = "SELECT name FROM books";
		$result = mysqli_query($db, $sql);
		$books = array();
		$i=0;

		while($res = $result->fetch_array(MYSQLI_ASSOC)){
			$books[$i] = $res;
			$i++;
		}
		
		return $books;
	}

	function check($name)
	{
		$check = true;
		$books = getBooks();
		foreach ($books as $book) {
			if($book['name'] == $name){
				$check = false;
			}
		}
		return $check;
	}

	function addBook($name){

		if (check($name)){

			$db = dbConnect();
			$sql = "INSERT INTO books (name) VALUES ('$name')";

			if($result = mysqli_query($db, $sql)){
				$_SESSION['addString'] = "Book succesfully added!";
				$_SESSION['addType'] = "label label-success";
			}
			else{
				$_SESSION['addString'] = "Error adding book";
				$_SESSION['addType'] = "label label-danger";
			}
		}
		else
		{
			$_SESSION['addString'] = 'Book already in database';
			$_SESSION['addType'] = "label label-danger";
		}
	}

	function modifyBook($name, $newName)
	{
		if (check($newName)){

			$db = dbConnect();
			$sql = "UPDATE books SET name = '$newName' WHERE name = '$name'";

			if ($res = mysqli_query($db, $sql))
			{
				$_SESSION['modString'] = "Book succesfully modified!";
				$_SESSION['modType'] = "label label-success";
			}
			else
			{
				$_SESSION['modString'] = "Book couldn't be modified";
				$_SESSION['modType'] = "label label-danger";
			}
		}
		else
		{
			$_SESSION['modString'] = "Book couldn't be modified";
			$_SESSION['modType'] = "label label-danger";
		}
	}

	function deleteBook($name)
	{
		$db = dbConnect();
		$sql = "DELETE FROM books WHERE name = '$name'";
		if ($res = mysqli_query($db, $sql))
		{
			$_SESSION['delString'] = "Book succesfully deleted!";
			$_SESSION['delType'] = "label label-success";
		}
		else
		{
			$_SESSION['delString'] = "Book couldn't be deleted";
			$_SESSION['delType'] = "label label-danger";
		}
	}


?>