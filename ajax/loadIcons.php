<?php
include_once '../coreSettings.php';
include_once BASE_PATH.'/main/main-class.php';

$main = new main();

$publicIcons = $main->getAllIconsWithCatId();

echo "<div class='sh_item' >";
$i=0;
foreach ( $publicIcons as $one_row )
{
	$i++;
	echo "<a target='blank' href=\"".$one_row[3]."\" title=\"".$one_row[1]."\" class=\"tileIcon\" style=\"background: url('".$one_row[13]."') no-repeat scroll center top transparent;\"><span></span><div class=\"sh_iconDesc\">".$one_row[1]."</div></a>";
	if(($i%28) == 0)
		echo "</div><div class='sh_item' >";
}
echo "</div>";

?>