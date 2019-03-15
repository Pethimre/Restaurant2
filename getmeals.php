<?php 

session_start();
error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
require_once "php/db.php";
$db = db::get();

require_once "paginator.php";

$currentPage = $_GET["page"];
$currentPage = (int)$currentPage;
$selectfoods2 = "SELECT * FROM foods WHERE class = 'webshop'";
$numberOfRows = $db->numrows($selectfoods2);

$pg = new Paginator($numberOfRows, $currentPage);
			if ($currentPage < 2) {
				$pg->from = 0;
			}
			else
			{
				$pg->from = ($currentPage - 1) * $pg->step;
			}
			
$foods = $db->getArray($selectfoods2." LIMIT ".$pg->from.", ".$pg->step);

?>

<div class="row menu">
	<div class="col-md-10 col-md-offset-1 col-sm-9 col-sm-offset-2 col-xs-12">

		<?php foreach ($foods as $food): ?>
		
			<div class="container col-md-6" style="width: 50%;">
				<div class="jumbotron" style="border-radius: 15px; background-color: #8BC34A;">
					<img src="images/featured/<?php echo $food['imgpath']; ?>" style="border-radius: 50%;" align="left" height="100vh" width="100wv" alt="">
					<h3 class="webshop" onclick="window.location.href='php/foodform.php?foodid=<?php echo $food["id"]; ?>'"><?php echo $food['name']; ?></h3>
					<label for="" style="margin-left: 25%;" class="text-center"><?php echo $food["price"]." HUF"; ?></label>
					<?php if($_SESSION["username"] == "admin"): ?>
						<input type="button" class="btn btn-danger" name="removeWebshop" style="margin-left: 10%;" onclick="window.location.href='php/delete.php?foodid=<?php echo $food['id'];?>'" value="Remove"><br>
					<?php endif; ?>

					<?php if(isset($_SESSION["username"]) && $_SESSION["username"] != "admin") : ?>
						<form action="php/addtocart.php?item=<?php echo $food["id"]; ?>" method="post">
							<input type="submit" class="btn btn-success" value="Add to Cart">
							<input type="number" min="1" max="99" name="foodQuantity" value="1">
						</form>
					<?php endif; ?>

					<?php if(!(isset($_SESSION["username"]))): ?>
						<input type="button" class="btn btn-primary" style="margin-left: 10%;" onclick="window.location.href='register.php'" value="Login for Shopping"><br>
					<?php endif; ?>
				</div>
			</div>
		
		<?php endforeach; ?>
	</div>
</div>

<div id="moreMenuContent"></div>
<div class="text-center">
	<?php echo $pg->getPaginator(); ?>
</div>