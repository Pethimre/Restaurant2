<?php 
  
  session_start();

  error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  require_once "db.php";
  $db = db::get();
  $id = $_SESSION["id"];
  $id = (int)$id;

  $selectString = "SELECT * FROM nutrients WHERE food_id='$id'";
  $allnutrient = $db->getArray($selectString);

?>

<html>
<head>
  <meta charset="UTF-8">
  <title>table</title>
  <link rel="stylesheet" href="iframe/table.css">
  <meta http-equiv="Cache-Control" content="no-store" />
  <style>
    body
    {
      margin-top: 0 auto;
      padding-top: 0 auto;
    }
  </style>

</head>
<body>
  <?php if(count($allnutrient) == 0): ?>
    No available nutrition table for this meal.
  <?php endif; ?>

 <?php 
      if(count($allnutrient) > 0):
      foreach($allnutrient as $nutrients): 
?>
<?php $calories = ($nutrients["fat"] * 9) + ($nutrients["carb"] * 4) + ($nutrients["protein"] * 4); $percentage = $calories / 2000 * 100; ?>
<section class="performance-facts">
  <header class="performance-facts__header">
    <h1 class="performance-facts__title">Nutrition Facts</h1>
  </header>
  <table class="performance-facts__table">
    <thead>
      <tr>
        <th colspan="3" class="small-info">
          Average Amount Per Serving
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th colspan="2">
          <b>Calories</b>
        </th>
        <td>
          <?php echo $calories; ?> kcal <?php echo (floor($percentage)); ?>%*
        </td>
      </tr>
      <tr class="thick-row">
        <td colspan="3" class="small-info">
          <b>Daily Value*</b>
        </td>
      </tr>
      <tr>
        <th colspan="2">
          <b>Fat</b>
        </th>
        <td>
          <b><?php echo $nutrients["fat"]; ?>g</b>
        </td>
      </tr>
      <tr>
        <td class="blank-cell">
        </td>
        <th>
          Saturated Fat
        </th>
        <td>
          <b><?php echo $nutrients["sat_fat"]; ?>g</b>
        </td>
      </tr>
      <tr>
        <td class="blank-cell">
        </td>
      </tr>
      <tr>
        <th colspan="2">
          <b>Sodium</b>
        </th>
        <td>
          <b><?php echo $nutrients["sodium"]; ?>g</b>
        </td>
      </tr>
      <tr>
        <th colspan="2">
          <b>Carbohydrates</b>
        </th>
        <td>
          <b><?php echo $nutrients["carb"]; ?>g</b>
        </td>
      </tr>
      <tr>
        <td class="blank-cell">
        </td>
        <th>
          Fiber
        </th>
        <td>
          <b><?php echo $nutrients["fiber"]; ?>g</b>
        </td>
      </tr>
      <tr>
        <td class="blank-cell">
        </td>
        <th>
          Sugars
        </th>
        <td>
          <b><?php echo $nutrients["sugar"]; ?>g </b>
        </td>
      </tr>
      <tr class="thick-end">
        <th colspan="2">
          <b>Protein</b>
        </th>
        <td>
          <b><?php echo $nutrients["protein"]; ?>g</b>
        </td>
      </tr>
    </tbody>
  </table>
  
  <table class="performance-facts__table--grid">
    <tbody>
      <tr>
        <td colspan="2">
          
        </td>
        <td>
         
        </td>
      </tr>
      <tr class="thin-end">
        <td colspan="2">
          
        </td>
        <td>
          
        </td>
      </tr>
    </tbody>
  </table>
  
  <p class="small-info">* Percent Daily Values are based on a 2,000 calorie diet. Your daily values may be higher or lower depending on your calorie needs:</p>
  
  <table class="performance-facts__table--small small-info">
    <thead>
      <tr>
        <td colspan="2"></td>
        <th></th>
        <th>Less than</th>
        <th>At least:</th>
      </tr> 
    </thead>
    <tbody>
      <tr>
        <th colspan="2">Total Calories</th>
        <td></td>
        <td><?php echo $calories * 1.1 ; ?>kcal</td>
        <td><?php echo $calories; ?>kcal</td>
      </tr>
      <tr>
        <th colspan="2">Total Fat</th>
        <td></td>
        <td><?php echo ($nutrients["sat_fat"] + $nutrients["fat"]) * 1.1; ?>g</td>
        <td><?php echo $nutrients["fat"] + $nutrients["sat_fat"]; ?>g</td>
      </tr>
      <tr>
        <td class="blank-cell"></td>
        <th>Saturated Fat</th>
        <td></td>
        <td><?php echo $nutrients["sat_fat"] * 1.1; ?>g</td>
        <td><?php echo $nutrients["sat_fat"]; ?>g</td>
      </tr>
      <tr>
        <th colspan="2">Cholesterol</th>
        <td></td>
        <td><?php echo $nutrients["cholesterol"] * 1.1; ?>g</td>
        <td><?php echo $nutrients["cholesterol"]; ?>g</td>
      </tr>
      <tr>
        <th colspan="2">Sodium</th>
        <td></td>
        <td><?php echo $nutrients["sodium"] * 1.1; ?>g</td>
        <td><?php echo $nutrients["sodium"]; ?>g</td>
      </tr>
      <tr>
        <th colspan="3">Carbohydrate</th>
        <td><?php echo $nutrients["carb"] * 1.1; ?>g</td>
        <td><?php echo $nutrients["carb"]; ?>g</td>
      </tr>
      <tr>
        <td class="blank-cell"></td>
        <th colspan="2">Dietary Fiber</th>
        <td><?php echo $nutrients["fiber"] * 1.1; ?>g</td>
        <td><?php echo $nutrients["fiber"]; ?>g</td>
      </tr>
    </tbody>
  </table>
  
  <p class="small-info">
    Total calories: <?php echo $calories; ?> kcal
  </p>
  <p class="small-info text-center">
    Fat 9
    &bull;
    Carbohydrate 4
    &bull;
    Protein 4
  </p>
  
</section>

<?php 
  endforeach;
  endif;
 ?>

</body>
</html>