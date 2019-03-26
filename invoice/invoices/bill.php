<?php
	
	error_reporting(E_ALL & ~E_ALL);
	session_start();
	require_once "../../php/db.php";
	$db = db::get();

	$now = date("Y-m-d");
	$order = $_GET["order"];
	$total = 0;

	$selectUserDataQuery = "SELECT `Fullname`,`PhoneNo`,`email`, addresses.shipping_address, addresses.billing_address FROM `users` LEFT JOIN addresses ON addresses.username = users.username WHERE users.username = '".$_SESSION["username"]."'";
	$userData = $db->getArray($selectUserDataQuery);

	foreach ($userData as $user) {
		$fullname = $user["Fullname"];
		$phone = $user["PhoneNo"];
		$email = $user["email"];
		$shipping = $user["shipping_address"];
		$billing = $user["billing_address"];
	}

	 $selectOrderedItemsQuery = "SELECT * FROM orders WHERE id =".$order;
      $orders = $db->getArray($selectOrderedItemsQuery);

      foreach ($orders as $order) {
        $tmp = $order["items"];
        $total = $order["total"];
        $progress = $order["progress"];
        $orderid = $order["id"];
        $orderedAt = $order["ordered_at"];
      }

      $list = explode(",", $tmp);

require dirname(__DIR__) . DIRECTORY_SEPARATOR . "invoicr.php";
$invoice = new Invoicr();

$invoice->set("company", [
	"eatwell.png", 
	"Eatwell", 
	"Hengersor Street, Budapest, Pest megye, 1184",
	"Phone: +36 70 526 0239 | Mailbox: 1124",
	"https://eatwell.com",
	"info@eatwell.com"
]);

$invoice->set("invoice", [
	["Invoice Id", $orderid],
	["Order Placed at", "<br>".$orderedAt],
	["Order Placed By", "<br>".$fullname],
	["Bill printed at", $now]
]);

$invoice->set("billto", [
	"",
	$fullname,
	$billing
]);

$invoice->set("shipto", [
	"",
	$fullname,
	$shipping
]);

	for ($i=0; $i < count($list); $i++){
        $selectOrderedItemsQuery = "SELECT cart.food_id, cart.quantity, cart.subtotal, foods.name, foods.price FROM cart LEFT JOIN foods ON cart.food_id = foods.id WHERE cart.id =".$list[$i];
        $getOrderedElement = $db->getArray($selectOrderedItemsQuery);
        
        foreach ($getOrderedElement as $element)
        {
        	$elementname = $element["name"];
        	$elementquantity = $element["quantity"];
        	$elementprice = $element["price"];
        	$elementsubtotal = $element["subtotal"];

        	$invoice->add("items", [$elementname,"", $elementquantity,$elementprice." HUF", $elementsubtotal." HUF"]);
        }
        
    }

foreach ($items as $i) { $invoice->add("items", $i); }

$invoice->set("totals", [
	["SUB-TOTAL", $total],
	["", ""],
	["GRAND TOTAL", $total]
]);

$invoice->set("notes", [
	"Thank you for choosing us!",
	"Hope we will meet again!"
]);

$invoice->template("apple");

/*****************************************************************************/
// 3B - OUTPUT IN HTML
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
 #$invoice->outputHTML();
// $invoice->outputHTML(1);
// $invoice->outputHTML(2, "invoice.html");
// $invoice->outputHTML(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.html");
/*****************************************************************************/
// 3C - PDF OUTPUT
// DEFAULT DISPLAY IN BROWSER | 1 DISPLAY IN BROWSER | 2 FORCE DOWNLOAD | 3 SAVE ON SERVER
// $invoice->outputPDF();
 $invoice->outputPDF(1);
// $invoice->outputPDF(2, "invoice.pdf");
// $invoice->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.pdf");
/*****************************************************************************/
// 3D - DOCX OUTPUT
// DEFAULT FORCE DOWNLOAD| 1 FORCE DOWNLOAD | 2 SAVE ON SERVER
// $invoice->outputDOCX();
// $invoice->outputDOCX(1, "invoice.docx");
// $invoice->outputDOCX(2, __DIR__ . DIRECTORY_SEPARATOR . "invoice.docx");
/*****************************************************************************/
?>