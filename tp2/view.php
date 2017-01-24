<div class="container">
	<div class="col-md-12">
		<div class="box">							
			<div class="icon">
				<div class="image"><i class="fa fa-check"></i></div>
				<div class="info">
    				<h3 class="title">Add</h3>
    				<form action="index.php" name="add" method="POST">
						<input type="text" name="book" class="form-control"/>
						<input type="submit" name="add" value="Submit" class="col-md-12 btn btn-success"/>
						<span class= "<?php if(isset($_SESSION['addType'])) echo $_SESSION['addType'];  ?>"><?php if(isset($_SESSION['addString'])) echo $_SESSION['addString']; ?></span>
					</form>
				</div>
			</div> 
		</div>
	</div>
			

	<div class="col-md-12">
		<div class="box">							
			<div class="icon">
				<div class="image"><i class="fa fa-ban"></i></div>
				<div class="info">
					<h3 class="title">Delete</h3>

					<form action="index.php" name="del" method="POST">
						<select name="bookToDel" class="form-control">

						<?php 
							foreach ($books as $book) {
								echo "<option>" . $book['name'] . "</option>";
							}

						?>
								
						</select>
						<input type="submit" name="del" value="Submit" class="col-md-12 btn btn-danger" />
						<span class= "<?php if(isset($_SESSION['delType'])) echo $_SESSION['delType'];  ?>"><?php if(isset($_SESSION['delString'])) echo $_SESSION['delString']; ?></span>
					</form>
				</div>	
			</div> 
		</div>
	</div>

	<div class="col-md-12">
		<div class="box">							
			<div class="icon">
			    <div class="image"><i class="fa fa-flag"></i></div>
				<div class="info">
					<h3 class="title">Modify</h3>
					<form action="index.php" name="modify" method="POST">
						<select name="bookToModif" class="form-control">

						<?php 
							foreach ($books as $book) {
								echo "<option>" . $book['name'] . "</option>";
							}

						?>
							
						</select>
						<input type="text" name="newName" class="form-control"/>
						<input type="submit" class="col-md-12 btn btn-info" name="modif" value="Submit"/>
						<span class="<?php if(isset($_SESSION['modType'])) echo $_SESSION['modType'];  ?>"><?php if(isset($_SESSION['modString'])) echo $_SESSION['modString']; ?></span>
					</form>
				</div>
			</div> 
		</div>
	</div>
</div>
