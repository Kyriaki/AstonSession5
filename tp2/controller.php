<?php

	session_start();
	
	if (isset($_POST['book']))
	{

		addBook($_POST['book']);

	}

	if (isset($_POST['bookToDel']))
	{
		deleteBook($_POST['bookToDel']);
	}

	if (isset($_POST['bookToModif']) && isset($_POST['newName']))
	{
		modifyBook($_POST['bookToModif'], $_POST['newName']);
	}

	$books = getBooks();

?>