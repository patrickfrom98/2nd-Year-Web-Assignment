<!DOCTYPE html>
<html lang="en">
	<head>
		<title>A bit about database design | Bookshelf</title>

		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/design.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Patrick Thompson, 2nd Year Computing Student, University of Huddersfield">
		<meta name="keywords" content="business books, self-help books, search business books, business books to read">
		<meta name="description" content="Search business books through Bookshelf. We sell business, economics, finance,
									      psychology, philosophy and self-help books.">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<?php
		try {
			$pdo = new PDO("mysql:host=localhost; dbname=u1756102", "u1756102", "08nov98");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$resultset = $pdo->query("SELECT * FROM Book");
			$books = $resultset->fetchAll();
			
			$resultset = $pdo->query("SELECT * FROM Author");
			$authors = $resultset->fetchAll();
			
			$resultset = $pdo->query("SELECT * FROM Contributor ORDER BY bookid ASC");
			$contributors = $resultset->fetchAll();
			
			$resultset = $pdo->query("SELECT * FROM Review ORDER BY bookid ASC");
			$reviews = $resultset->fetchAll();
		} catch (PDOException $e) {
			echo 'Connection error: ' . $e->getMessage();
			exit();
		}

		$pdo = null;
		?>
	</head>
	<body style="background-color: #f2f2f2;">
		<header>
			<ul class="gradient">
			  <!--<li><img src="../res/img/book-logo.png" style="width: 70px; height: 70px; padding: 0px; margin: 0px;">--></li>
			  <li style="padding-top: 10px;"><a href="design.php"><i class="fa fa-paint-brush fa-2x"></i> Design</a></li>
			  <li style="padding-top: 10px;"><a href="index.php"><i class="fa fa-search fa-2x"></i> Search</a></li>
			</ul>
		</header>
		<div class="container">
			<div class="row" style="background-color: #f2f2f2;">
				<h1 class="main-heading">Business Books Search Engine</h1>
				<h6 class="description">A bit about my chosen scenario...</h6>
				<br />
				<br />
				<p>My chosen scenario was to develop a simple search engine for fictitious company called Bookshelf.
				   Bookshelf sells business, finance and self-help books to the mass market.</p>
				<br />
				<p>The search engine is able to search the companies database of books by title.
				   Additonal filters are available to narrow down search results with users have the ability to filter by book category.</p>
				<br />
				<br />
				<br />
				<br />
				<h1>Class Diagram</h1>
				<img src="../res/img/classdiagram.PNG" />
				<br />
				<br />
				<br />
				<br />
				<h1>Physical Data Model</h1>
				<img src="../res/img/database.PNG" />
				<br /><br /><br /><br />
				<br /><h1>Author</h1>
				<table>
				  <tr>
					<th>authorid</th>
					<th>fname</th>
					<th>lname</th> 
					<th>dob</th>
					<th>locality</th>
					<th>description</th>
					<th>image</th>
				  </tr>
					<?php
						if ($authors) {
							foreach ($authors as $author) {
								echo "<tr>";
								echo "<td>".$author['authorid']."</td>
									  <td>".$author['fname']."</td>
									  <td>".$author['lname']."</td>
									  <td>".$author['dob']."</td>
									  <td>".$author['locality']."</td>
									  <td>".$author['description']."</td>
									  <td>".$author['image']."</td>";
								echo "</tr>";
							}
						} else { echo "No data rows to report"; }
					?>
				</table>
				<br /><br /><br /><br />
				<br /><h1>Book</h1>
				<table>
				    <tr>
					    <th>bookid</th>
						<th>title</th>
						<th>category</th> 
						<th>pages</th>
						<th>isbn</th>
						<th>publisher</th>
						<th>width</th> 
						<th>height</th>
						<th>style</th> 
						<th>image</th>
				    </tr>
					<?php
						if ($books) {
							foreach ($books as $book) {
								echo "<tr>";
								echo "<td>".$book['bookid']."</td>
									  <td>".$book['title']."</td>
									  <td>".$book['category']."</td>
									  <td>".$book['pages']."</td>
									  <td>".$book['isbn']."</td>
									  <td>".$book['publisher']."</td>
									  <td>".$book['width']."</td>
									  <td>".$book['height']."</td>
									  <td>".$book['style']."</td>
									  <td>".$book['image']."</td>";
								echo "</tr>";
							}
						} else { echo "No data rows to report"; }
					?>
				</table>
				<br /><br /><br /><br />
				<br /><h1>Contributor</h1>
				<table>
				    <tr>
					    <th>bookid</th>
						<th>authorid</th>
					</tr>
					<?php
						if ($contributors) {
							foreach ($contributors as $contributor) {
								echo "<tr>";
								echo "<td>".$contributor['bookid']."</td>
									  <td>".$contributor['authorid']."</td>";
								echo "</tr>";
							}
						} else { echo "No data rows to report"; }
					?>
				</table>
				<br /><br /><br /><br />
				<br /><h1>Review</h1>
				<table>
					<tr>
						<th>bookid</th>
						<th>reviewdate</th>
						<th>reviewer</th>
						<th>review</th>
						<th>rating</th>
					</tr>
					<?php
						if ($reviews) {
							foreach ($reviews as $review) {
								echo "<tr>";
								echo "<td>".$review['bookid']."</td>
									  <td>".$review['reviewdate']."</td>
									  <td>".$review['reviewer']."</td>
									  <td>".$review['review']."</td>
									  <td>".$review['rating']."</td>";
								echo "</tr>";
							}
						} else { echo "No data rows to report"; }
					?>
				</table>
			</div>
		</div>
	</body>
</html>