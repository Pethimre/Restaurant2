<html>
<head>
	<meta charset="UTF-8">
	<title>kek</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
	<style>
		
.header
{
	text-decoration: none;
	text-align: center;
	background-color: transparent;
}

/* Float four columns side by side per row */
.column {
  float: right;
  /*width: 25%;*/
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  border-radius: 15px;
  padding: 16px;
  background-color: rgba(255,255,255,.5);
}

.noteDate
{
	float: right!important;
	text-align: right;
	padding-right: 0 auto;
	padding-top: 10px;
}

.noteTitle
{
	text-align: center;
}

.noEffect
{
	/*background-color: transparent;*/
	border: none;
	box-shadow: none;
	text-shadow: none;
}

.content
{
	-webkit-box-shadow: inset 3px 2px 18px 1px rgba(0,0,0,0.75);
	-moz-box-shadow: inset 3px 2px 18px 1px rgba(0,0,0,0.75);
	box-shadow: inset 3px 2px 18px 1px rgba(0,0,0,0.75);
}

	</style>
</head>
<body style="background-color: whitesmoke;">
		<div class="col-lg-12" style="display: flex!important;">
		<div class="container">
		      <div class="row">
         <div class="column">
            <div class="card" style="border: 2px solid white;">
            	<div style="display: inline;">
            		<button class="btn-sm btn-primary" style="width: 5vw; height: 5vh;"><i class="fal fa-edit"></i></button>
               		<small class="noteDate"><?php echo date("Y-m-d H:i:s"); ?></small>
            	</div>
               
               <h3 class="noteTitle">Title</h3>
               <p class="noteContent">bekjvdkvadkvladv;ladkvkdbvkjdabvkjdbvjkdbskvb DSKJVBskdjBVkjDSBVKJDVBJSKDVbDSJVBDSJBVJ</p>
            </div>
         </div>
      </div>
      <br>

	</div>	
	
</div>
</body>
</html>