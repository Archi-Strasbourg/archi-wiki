Documentation {#mainpage}
=======
Cette page a pour but d'expliquer le minimum du connaissances du code nécessaire pour contribuer à ArchiWiki.
Des connaissances de base en PHP, MySQL et HTML sont requises.

Une description d'ArchiWiki est disponible sur [cette page](md_README.html).

Utilisation de Git
=======
L'ensemble du code est disponible [sur GitHub](https://github.com/Archi-Strasbourg/archi-wiki). Il est donc nécessaire d'utiliser Git pour contribuer.
(Si vous ne savez pas utiliser Git, vous pouvez suivre [ce cours en ligne](https://try.github.io/).)

Le modèle de développement est basé sur [GitFlow](http://nvie.com/posts/a-successful-git-branching-model/).
La branche _master_ est la branche stable et correspond à ce qui est en ligne sur http://archi-strasbourg.org/.
Le développement se fait donc sur la branche _dev_ pour les modifications mineures ou sur une branche dédiée pour les modifications majeures.
Une fois poussées sur la branche _dev_, les modifications sont testées sur http://archi-strasbourg.org/test/.
S'il n'y a pas de bugs ou de régressions, ces modifications sont ensuite fusionnées dans la branche _master_.

Installation
=======
Afin de travailler en local sur le code, il faut tout d'abord cloner le dépôt :

    git clone https://github.com/Archi-Strasbourg/archi-wiki.git

puis passer sur la branche _dev_ :

    git checkout dev


Il faut ensuite importer la base de données MySQL. Un dump de la structure de la base est disponible dans le fichier ```ARCHI_V2.sql``` mais le mieux est encore de demander un dump complet à un administrateur du site.

Il faut ensuite créer le fichier ```config.php``` :

    cp includes/framework/config.template.php includes/framework/config.php
    
puis l'éditer afin de renseigner les informations de connexion à la base de données.

Si ArchiWiki n'est pas installé à la racine du serveur mais dans un sous-dossier, il faut éditer le fichier ```.htaccess``` et modifier l'instruction ```RewriteBase``` comme suit :

    RewriteBase /mon/sous/dossier/


Classes Archi
=======
La plupart des fonctions sont organisées dans un ensemble de classes dont le nom commence par Archi.
La documentation de ces classes est disponible [ici](@ref Classes).

Classe Config
=======
La classe Config est la classe dont héritent toutes les [classes Archi](@ref Classes).
Elle contient des fonctions permettant de récupérer des éléments utiles comme l'URL de base du site, le chemin du dossier racine, etc.

Modules
=======
La plupart du code est situé dans le dossier [modules](@ref modules), qui contient lui-même trois modules : [archi](@ref modules/archi), [header](@ref modules/header) et [footer](@ref modules/footer).
Chaque module contient un fichier ```index.php``` ainsi qu'un dossier ```template```. Le fichier ```index.php``` va charger les différents templates en fonction de la page sur laquelle se trouve l'utilisateur.

Les modules [header](@ref modules/header) et [footer](@ref modules/footer) contiennent les templates de l'en-tête et du pied de page du site.

Le module [archi](@ref modules/archi) contient quant à lui les [classes Archi](@ref Classes) ainsi que les templates de la plupart des pages du site.
Le fichier [index.php](@ref modules/archi/index.php) sert ici à appeler les fonctions des [classes Archi](@ref Classes) en fonction de la page ou de l'action demandée par l'utilisateur (via un paramètre GET). Ces différentes fonctions se chargent ensuite de récupérer les informations nécessaire dans la abse de données et d'afficher le template correspond à la page demandée.

Système de templates
=======
Archi-Wiki utilise un système de template proche de [Smarty](http://www.smarty.net/).

La classe Template est utilisée pour charger les templates.
On crée d'abord une instance en précisant dans quel modules chercher les templates :

    $t=new Template('modules/header/templates/');
    
Puis on indique les templates à charger grace à la fonction [set_filenames](@ref Template::set_filenames) :

    $t->set_filenames((array('header'=>'header.tpl')));
    
Il est ensuite possible de transmettre des variables au template à l'aide de la fonction [assign_vars](@ref Template::assign_vars) :

    $t->assign_vars(
        array(
            'var1'=>'lorem',
            'var2'=>'ipsum'
        )
    );

Enfin, on parse le template et on renvoit le HTML au navigateur :

    ob_start();
    $t->pparse('header');
    $html=ob_get_contents();
    ob_end_clean();


Les templates en eux-mêmes sont des fichiers ```.tpl``` contenant du HTML. On peut récupérer les variables transmises [assign_vars](@ref Template::assign_vars) avec en utilisant cette syntaxe :
    
    {var1}


Il est également possible de rendre certains blocs conditionnels comme ceci :

    < !-- BEGIN nomDuBloc -->
    <div>
        Lorem ipsum
    </div>
    < !-- END nomDuBloc -->

(Un espace a été ajouté entre ```<``` et ```!``` pour des questions d'affichage, mais il s'agit bien de commentaires HTML classiques.)

Par défaut le bloc ne sera pas affiché. Pour l'activer depuis PHP, il faut utiliser la fonction [assign_block_vars](@ref Template::assign_block_vars) :
    
    $t->assign_block_vars('nomDuBloc', array());
    


Base de données
=======
ArchiWiki utilise une base de données MySQL.
Un schéma de la base de données est disponible dans ```doc/MCD.mwb```. (Le fichier s'ouvre avec [MySQL Workbench](https://www.mysql.fr/products/workbench/)).

La classe ConnexionBdd est utilisée pour se connecter à la base.
Les requêtes se font comme suit :

    $config->connexionBdd->requete($marequete);

(```$config``` étant ici une instance de la classe Config ou d'une des [classes Archi](@ref Classes) et ```$marequete``` étant une chaîne contenant une requête en langage SQL.)

Une fois la requête effectuée, le résultat se récupère avec la fonction [mysql_fetch_assoc](http://php.net/manual/fr/function.mysql-fetch-assoc.php) :

    $res = $config->connexionBdd->requete($marequete);
    while($row = mysql_fetch_assoc($res)) {
        var_dump($row);
    }

Attention à bien utiliser [mysql_real_escape_string](http://php.net/manual/fr/function.mysql-real-escape-string.php) pour sécuriser les requêtes.

CSS
=======
La plupart du CSS se trouve dans ```css/default.css```.
Il est recommandé de mettre tout le CSS dans ce fichier et d'éviter au maximum les balises et attributs ```style```.

Conventions de code
=======
La plupart du code est écrit sans conventions. Cependant, un travail d'uniformisation a été commencé.

Dans la mesure du possible, il serait bien que le code PHP respect les [PEAR Coding Standards](http://pear.php.net/manual/en/standards.php) et que le code CSS respecte les recommandations de [CSSLint](https://github.com/CSSLint/csslint/wiki).

Le HTML devra bien évidemment être valide HTML5.

Pour finir, c'est loin d'être le cas, mais ce serait bien que le JavaScript respecte les recommandations de [JSLint](http://jslint.com/).

Logs
=======
Les mails envoyés par ArchiWiki sont enregistrés dans des fichiers de log dans le dossier ```logs```.
Chaque ligne de fichier de log contient un tableau JSON avec divers informations sur le mail envoyés.
