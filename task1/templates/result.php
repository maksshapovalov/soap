<?php if ($data['message']!==true):?>
	<h3><?=$data['message'];?></h3>
<?php endif;?>
<?php if (isset($data['Title'])):?>
	<h3><?=$data['Title'];?></h3>
	<p>Soap Result: <?=$data['Soap'];?></p>
	<p>Curl Result: <?=$data['Curl'];?></p>
<?php endif;?>