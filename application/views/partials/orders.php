<?php
	if(isset($orders)){
		$displayNum = 1; /* This is so that regardless of record deletion, display num will be in perfect ascending order. */
		foreach($orders as $order){	
?>	<section>
		<form class="remove" method="post" action="<?=base_url();?>orders/remove/<?=$order['id']?>">
			<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
			<input type="submit" value="X">
		</form>

		<h2><?=$displayNum;?></h2>

		<p order_id="<?=$order['id']?>" class="order_content"><?=$order['order_content']?></p>
	</section>
<?php	$displayNum++;
		}
	}
?>