<?php
/**
 * Gestion des pages
 * 
 * PHP Version 5.3.3
 * 
 * @category Admin
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * 
 * */
echo "<h2>"._("Gestion des pages")."</h2>";

if (isset($_GET['delete'])) {
    $page=new archiPage($_GET['delete']);
    $page->delete();
}
$listPages=archiPage::getList(LANG);

echo "<ul>";
foreach ($listPages as $page) {
    echo "<li><a href='index.php?archiAffichage=editPage&idPage=".
    $page["id"]."&langPage=".$page["lang"]."'>".stripslashes($page["title"]).
    "</a> <small>(<a href='index.php?archiAffichage=adminPages&amp;delete=".
    $page["id"]."'>"._('Supprimer')."</a>)</small></li>";
}
echo "</ul>";
echo "<a href='index.php?archiAffichage=editPage&new=".true."'>".
_("Ajouter une page")."</a>";
?>
