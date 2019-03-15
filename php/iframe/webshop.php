<html>
<head>
	<meta charset="UTF-8">
	<title>WebshopItems</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/main.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<div class="container" id="webshopItems">
	
	</div>

	<script>

				var actualPage;
                
                getPage(actualPage);

                function getPage(page)
                {
                    actualPage = page;
                    $.ajax({
                        url: '../../getmeals.php?page='+actualPage,
                  })
                    .done(function(res) {
                        $("html").find("#webshopItems").html(res);
                  })
                }

                function next()
                {

                    actualPage++;
                    $.ajax({
                        url: '../../getmeals.php?page='+actualPage,
                    })
                    .done(function(res) {
                        $("html").find("#webshopItems").html(res);
                    })
                }


                function previous()
                {
                    if (actualPage > 1) 
                    {
                        actualPage--;  
                   $.ajax({
                    url: '../../getmeals.php?page='+actualPage,
                })
                   .done(function(res) {
                    $("html").find("#webshopItems").html(res);
                }) 
                    }
               }

               document.write(actualPage);

	</script>
</body>
</html>