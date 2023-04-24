		<form class="update" method="post" action="<?=base_url();?>orders/update/<?=$order['id']?>">
			<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
			<input type="text" name="order_content" value="<?=$order['order_content']?>">
			<input type="submit" value="Update">
		</form>