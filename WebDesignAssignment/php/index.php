<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Search your next business book to read | Bookshelf</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!--Meta info here-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Patrick Thompson, 2nd Year Computing Student, University of Huddersfield">
		<meta name="keywords" content="business books, self-help books, search business books, business books to read">
		<meta name="description" content="Search business books through Bookshelf. We sell business, economics, finance,
									      psychology, philosophy and self-help books.">
		
		<!--JQuery imports/links-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<?php
					if (isset($_POST['submit'])) {
						if (isset($_POST['title'])) {
							try {
								//Connects to database & sets up debugging mode
								$pdo = new PDO("mysql:host=localhost; dbname=u1756102", "u1756102", "08nov98");
								$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
								//Prepares correct query - based on selected filters
								if (isset($_POST['category']) && ($_POST['category'] != "all")) {
									$prep_stmt=$pdo->prepare("SELECT * FROM Book
															  WHERE title LIKE :title AND
																	category = :category");
									$prep_stmt->bindValue(':category', $_POST['category']);
								} else {
									$prep_stmt=$pdo->prepare("SELECT * FROM Book
															  WHERE title LIKE :title");
								}
						
								//Universal query preparation & execution
								$prep_stmt->bindValue(':title', "%{$_POST['title']}%");
								$prep_stmt->execute();
								$books=$prep_stmt->fetchAll();
								
								if ($books) {
									$noOfResults = (String) count($books);
								}
							}
							catch (PDOException $e) {
								echo 'Connection error: '.$e->getMessage();
								exit();
							}

							$pdo = null; 
						}
					}
				?>
	</head>
	<body style="background-color: #f2f2f2;">
		<header>
			<ul class="gradient">
			  <!--<li><img src="../res/img/book-logo.png" style="width: 70px; height: 70px; padding: 0px; margin: 0px;">--></li>
			  <li style="padding-top: 10px;"><a href="design.php"><i class="fa fa-paint-brush fa-2x"></i> Design</a></li>
			  <li style="padding-top: 10px;"><a href="index.php"><i class="fa fa-search fa-2x"></i> Search</a></li>
			</ul>
			<img src="../res/img/business-books.jpeg" alt="Bookshelf">
		</header>
		<div class="container">
			<div class="row" style="background-color: #f2f2f2;">
				<h1 class="main-heading">Search business books</h1>
				<p class="description">We stock business, economics, and finance books.</p>
			</div>
			<hr />
			<div class="row" style="background-color: #f2f2f2;">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<input type="text" class=" search-bar shadow" name="title" id="searchBox" placeholder="Search book by title" />
					<input type="submit" class="btn search-button shadow" value="Find Books" name="submit"/>
					<br />
					<br />
					<select class="search-category-filter shadow" name="category">
						<option value="all" selected>All Books</option>
						<option value="Business">Business</option>
						<option value="Self-Help">Self-Help</option>
					    <option value="Finance">Finance</option>
					</select>
				</form>
				<br />
			</div>
		</div>
		<div class="container" style="margin-top:-50px;">
			<div class="row" style="background-color: #f2f2f2;">
				<?php
					if (isset($noOfResults)) {
						echo "<h1 class='main-heading'>{$noOfResults} results for '<em>{$_POST['title']}</em>' in '<em>{$_POST['category']}</em>' books</h1>";
					}
				?>
			</div>
			<div class="row" style="background-color: #f2f2f2;">
				<?php
					if (isset($books)) {
						if ($books) {
							foreach ($books as $book) {
								echo "<a class='book-link' href='details.php?id={$book['bookid']}'>{$book['title']}</a><br />";
							}	
						} else {
							echo "<br /><h1>No books found. Try another search</h1>";
						}
					}
				?>
				<br />
			</div>
			<div style="width:100%; height:150px"></div>
		</div>
	</body>
</html>