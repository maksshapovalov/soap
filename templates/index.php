<html>
<head>
<meta charset="utf-8">
<title>File Upload</title>
<style type="text/css">
table {
		font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
		font-size: 14px;
		border-collapse: collapse;
		text-align: center;
}
th, td:first-child {
		background: #AFCDE7;
		color: white;
		padding: 10px 20px;
}
th, td {
		border-style: solid;
		border-width: 0 1px 1px 0;
		border-color: white;
}
td {
		background: #D8E6F3;
}
th:first-child, td:first-child {
		text-align: left;
}
</style>
</head>
<body>

<form method="post" action="index.php" enctype="multipart/form-data">

<input type="file" id="download_file" name="download_file">
<input type="submit" value="Upload">
<input type="hidden" name="check" value="sent">
</form>

<?php if ($message):?>
<?=$message;?>
<?php endif;?>

<?php if ($files):?>
<?php $i=0;?>
<h3>Загруженные файлы</h3>
<table>
<tr>
	<td>№</td>
	<td>File name</td>
	<td>File Size</td>
	<td>Command</td>
</tr>
<?php foreach($files as $file=>$size){ $i++; ?>
	<tr>
		<td><?=$i?></td>
		<td><?=$file?></td>
		<td><?=$size?></td>
		<td>
			<form action="index.php">
				<input type="hidden" name="delete" value="<?=$file?>">
				<input type="submit" value="Удалить">
			</form>
		</td>
	</tr>
<?php } ?>
</table>
<?php endif;?>
</body>
</html>
