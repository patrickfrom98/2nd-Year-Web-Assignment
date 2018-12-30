<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Product | Bookshelf</title>
		<!--External stylesheet links-->
		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/details.css">
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
		if (isset($_GET['id'])) {
			$bookid = $_GET['id'];
			
			try {
				$pdo = new PDO("mysql:host=localhost; dbname=", "", "");
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				//Gets book info
				$prep_stmt=$pdo->prepare("SELECT * FROM Book WHERE bookid=:id");
				$prep_stmt->bindValue(':id', $bookid);
				$prep_stmt->execute();
				$book=$prep_stmt->fetch();
				
				//Gets author info
				$prep_stmt=$pdo->prepare("SELECT Author.authorid, fname, lname, dob, locality, description, Author.image
										  FROM Author
											  INNER JOIN Contributor
												  ON Author.authorid = Contributor.authorid
											  INNER JOIN Book
												  ON Contributor.bookid = Book.bookid
										  WHERE Book.bookid=:id");
				$prep_stmt->bindValue(':id', $bookid);
				$prep_stmt->execute();
				$authors=$prep_stmt->fetchAll();
				
				//Review Info
				$prep_stmt=$pdo->prepare("SELECT * FROM Review WHERE bookid = :id ORDER BY rating DESC LIMIT 10");
				$prep_stmt->bindValue(':id', $bookid);
				$prep_stmt->execute();
				$reviews=$prep_stmt->fetchAll();
				
				
				//Gets similar products info - BUG FIX
				//Checks author query succeeds before looking for additonal titles by author
				/*if ($authors) {
					//Gets all books by author of book on details.php
					$prep_stmt=$pdo->prepare("SELECT * FROM book
											  WHERE book.bookid IN(SELECT contributor.bookid 
																	FROM contributor 
																	WHERE contributor.authorid IN(:authors)
																		AND bookid != :id");
						
					$prep_stmt->bindValue(':id', $bookid);
					$prep_stmt->bindValue(':authors', $authors[0]['authorid']);
					$prep_stmt->execute();
					$products=$prep_stmt->fetchAll();
				}*/
			} catch (PDOException $e) {
				echo 'Connection error: ' . $e->getMessage();
				exit();
			}

			$pdo = null;
		}
		?>
		
		<style>body{background-color:#F4F4F4;}</style>
	</head>
	<body>
		<header>
			<ul class="gradient">
			  <!--<li><img src="../res/img/book-logo.png" style="width: 70px; height: 70px; padding: 0px; margin: 0px;">--></li>
			  <li style="padding-top: 10px;"><a href="design.php"><i class="fa fa-paint-brush fa-2x"></i> Design</a></li>
			  <li style="padding-top: 10px;"><a href="index.php"><i class="fa fa-search fa-2x"></i> Search</a></li>
			</ul>
		</header>
		<div class="container" style="background-color: #F4F4F4;">
			<div class="row" style="display:block; margin: 50px auto 0px auto; padding: 0; background-color:white; border-top-left-radius: 5px; border-top-right-radius: 5px; box-shadow: 5px 7px 5px #aaaaaa; border-bottom: 2px solid #f2f2f2">
					<img class="book-image" src="<?php echo "{$book['image']}";?>" alt="Bookshelf" />
			</div>
			<div class="row" style="text-align:center; margin: 0px auto 50px auto; padding-top: 0; padding-bottom: 50px; background-color:white; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; box-shadow: 5px 5px 5px #aaaaaa;">
				<h1 class="book-heading"><?php echo "{$book['title']}"; ?></h1>
				<h3 class="book-subheading"><strong>Category:</strong> <?php echo "{$book['category']}"; ?></h3>
				<br />
				<h3 class="book-subheading"><strong>Publisher:</strong> <?php echo "{$book['publisher']}"; ?></h3>
				<h3 class="book-subheading"><strong>ISBN 13:</strong> <?php echo "{$book['isbn']}"; ?></h3>
				<h3 class="book-subheading"><strong>Width:</strong> <?php echo "{$book['width']}"; ?></h3>
				<h3 class="book-subheading"><strong>Height:</strong> <?php echo "{$book['height']}"; ?></h3>
				<h3 class="book-subheading"><strong>Style:</strong> <?php echo "{$book['style']}"; ?></h3>
				<h3 class="book-subheading"><strong>Pages:</strong> <?php echo "{$book['pages']}"; ?></h3>
			</div>
			<!--Create div for each author of book-->
			<?php
				foreach ($authors as $author) {
					echo "<div class='row' style='box-shadow: 0px 5px 5px #aaaaaa; background-color:#fff; width:100%; height: auto; padding-bottom: 50px; clear:left; text-align:center;'>";
						echo "<h1 style='padding: 40px 0px 0px 0px;'>About {$author['fname']} {$author['lname']}</h1>";
						echo "<h4 style='padding: 0px 0px 0px 0px;'>Born {$author['dob']}, {$author['locality']}</h4>";
						echo "<img src='{$author['image']}' style='padding: 0px 0px 20px 0px;' />";
						echo "<p style='width:60%; margin: auto;' style='padding: 0px 0px 40px 0px;'>{$author['description']}</p>";
					echo "</div>";
				}
			?>
			<div class="row" style="background-color: #f2f2f2; width: 55%; margin: 50px auto 0px auto;  min-height: 160px; padding: 0px 50px; clear:left; text-align:center;">
				<h1 style="padding: 20px 0px;">Reviews</h1>
				<?php 
					if ($reviews) {
						foreach ($reviews as $review) {
							echo "<div style='margin-bottom: 20px; box-shadow: 5px 5px 5px #aaaaaa; background-color: white; padding: 20px; border-radius: 5px; border: 2px solid white;; width: 100%; min-height: 100px;'>";
							echo "<h3 style='padding: 10px; font-family: Julius Sans One, sans-serif; color: #004770;'>'{$review['review']} <strong>{$review['rating']}/5</h3><p> - {$review['reviewer']}, {$review['reviewdate']}</strong></p>";
							echo "</div><br />";
						}
					} else { echo "<h1 style='font-size:25px;'>There are no reviews for this book yet</h1>"; }
				?>
			</div>
		</div>
	</body>
</html>
