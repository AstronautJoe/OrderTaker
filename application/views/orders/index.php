<!DOCTYPE html>
<html>
	<head>
		<title>Ajax Ordertaker v1</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/stylesheet.css">
		<!--Google font-->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<script type="text/javascript">
/* 			Get the id attribute of the form and change it into a form with textbox value of the order_content.
			Probably will need to make a another method for this only. */
			$(document).ready(function(){
				/* Once document is ready make a request to get all orders via url, response should by default be HTML*/

				$(document).on('submit', 'form', function(){
					var form = $(this); /* store form and place it everytime */
					$.post(form.attr('action'), form.serialize(), function(res){
						$('div.orders').html(res);
					});

					return false;
					console.log("show the orders!");
				});

				/* Change contents of clicked section/order into update order mode */
				$(document).on('click', 'p.order_content', function(){
					var target = $(this); /* To prevent querying the dom multiple times */
					var order_id = target.attr('order_id');
					var url = '<?=base_url();?>Orders/show_update_form/' + order_id;
					$.get(url, function(res){
						target.replaceWith(res);
					});

					return false;
				});


				$('form').submit();
			});
		</script>
	</head>
	<body class="index">
	<h1>Order Queue:</h1>

	<div class="messages">
	</div>
		
	
	<div class="orders">
	</div>

		<form class="add" method="post" action="<?=base_url()?>orders/add_order">
			<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">			
			<input type="text" name="order_content" placeholder="Type customers order here:"><input type="submit" value="submit">
		</form>
		
	</body>
</html>