<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?= isset($title) ? $title : '' ?></title>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        
        <!-- Chargement de la bibliothèque Vision.js -->
		<script type="text/javascript" src="script/vendor/vision/utility-0.2.js"></script>
		<script type="text/javascript" src="script/vendor/vision/webComponents-0.3.js"></script>
		<script type="text/javascript" src="script/vendor/vision/widgets-0.1.js"></script>
		<script type="text/javascript" src="script/vendor/vision/lazydata-0.3.js"></script>
		<script type="text/javascript" src="script/vendor/vision/lazyload-0.2.js"></script>
        <script type="text/javascript" src="script/vendor/vision/galerie-1.1.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
        <script type="text/javascript" src="script/vendor/Ajax.js"></script>
        
        <script type="text/javascript" src="script/drop-down.js"></script>
	</head>

    <body>
        <div class="l-container">   
            <header class="header">
                <input type="checkbox" class="l-header__btn--right is-toggle-right">
                <a class="l-header__btn--right header__btn" aria-label="Skip to main navigation"><i class="icon icon--menu" aria-hidden></i></a>
                <a class="l-header__btn--right header__btn--close"><i class="icon icon--time" aria-hidden></i></a>
                
                <input type="checkbox" class="l-header__btn--left is-toggle-left">
                <a class="l-header__btn--left header__btn" aria-label="Skip to navigation user"><i class="icon icon--user" aria-hidden></i></a>
                <a class="l-header__btn--left header__btn--close"><i class="icon icon--time" aria-hidden></i></a>
                
                <a class="header__logo" href="#"><img src="imgs/logo.png" alt="Le logo de Retro-Poste" srcset="imgs/logo.svg"/></a>

                <div class="search drop-down">
                    <form method="GET" role="search">
                        <div class="search__bar">
                            <label data-menu="filter" class="search__btn search__btn--filter drop-down__btn"><i class="icon icon--filter"></i><i class="icon icon--caret-down"></i></label>
                            
                            <input data-menu="suggestion" class="search__input" type="text" autocomplete="off"/>
                            <button class="search__btn" type="submit" title="Rechercher"><i class="icon icon--search"></i></button>
                        </div>
                    
                        <div class="drop-down__sub-list">
                            <div class="drop-down__sub" id="filter">
                                <div>Résultat 1</div>
                                <div>Résultat 2</div>
                            </div>
                            
                            <div class="drop-down__sub" id="suggestion"></div>
                        </div>
                    </form>

                    <div class="login-register">
                        <a href="#inscription">S'inscrire</a>
                        <a href="#connexion">Se connecter</a>
                    </div>
                </div>
                
                <nav class="l-nav l-nav--secondary nav">
                    <a class="nav__close"></a>
                    
                    <ul class="nav__menus menus">
                        <li><a href="#page-statique">Tanguy Bazire<i class="icon icon--user" aria-hidden></i></a></li>
                        <li><a href="#page-statique">Tableau de bord</a></li>
                        <li><a href="#for-buisiness">Deconnexion</a></li>
                    </ul>
                </nav>

                <nav class="l-nav l-nav--main nav">
                    <a class="nav__close"></a>
                
                    <ul class="nav__menus menus">
                        <li><a href="#communaute"><span>Communauté</span></a></li>
                        <li><a href="#page-statique">Page statique</a></li>
                        <li><a href="#page-statique">Page statique</a></li>
                        <li><a href="#a-propos-de-nous">A propos de nous</a></li>
                        <li><a class="special-link" href="#for-buisiness">For buisiness</a></li>
                    </ul>
                </nav>
            </header>

            <?= $content ?>
        
            <footer class="footer">
                Tous droits réservés - 2018 - Bazire Tanguy, <a href="#">Condition général d'utilisation</a>, <a href="#">Mention Légales</a>
            </footer>
		</div>
        
        <script type="text/javascript" src="script/search.js"></script>
        
        <?php if(isset($scripts)) : ?>
            <?php foreach ($scripts as $script) : ?>
                <script type="text/javascript" src="script/<?= $script ?>.js"></script>
            <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>