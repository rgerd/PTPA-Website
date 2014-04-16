<?php $page_title = "Event!"; include 'view/header.php'; ?>
		<div id="hello_world_div">
			<?php
				$message = "Hello world!!";
				$tag = "h1";
                echo "<".$tag.">".$message."</".$tag.">";
			?>
		</div>
<?php include 'view/event.php'; ?>

<?php include 'view/footer.php'; ?>
