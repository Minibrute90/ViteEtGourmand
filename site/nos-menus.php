<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Vite & Gourmand - Nos menus</title>

</head>

<?php
    // Connexion à la base de données
    $connexionBdd = new PDO('mysql:host=localhost;dbname=viteetgourmand;charset=utf8', 'root', '');
?>

<body>
    <header>
       <img class="logo-header" src="img/logoblanc_cercle_transparent_150.png">
       <div class="nav-header">
            <ul class="nav-classic">
                <li><a href="index.php">ACCUEIL</a></li>
                <li class="active"><a href="nos-menus.php">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
        <button id="boutonHamburger"><img class="picto-hamburger" src="img/picto_hamburger.png" ></button>
            <ul id="navHamburger" class="hidden">
                <li><a href="index.php">ACCUEIL</a></li>
                <li class="active"><a href="nos-menus">NOS MENUS</a></li>
                <li><a href="#info">INFOS</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
       <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png">
    </header>
    <main>
        <div class="header-page-menu">
            <div class="filtre-menus">
                <div class="titre-filtre">Affinez votre recherche</div>
                <div class="price-filter">
                    <div class="price-values">
                        <span id="minPrice">270€</span>
                        <span id="maxPrice">800€</span>
                        <div class="range-slider">
                            <input type="range" id="rangeMin" min="0" max="10000" value="270">
                            <input type="range" id="rangeMax" min="0" max="10000" value="800">
                            <div class="slider-track"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="titre-page-menu">
                <h1 class="titre-page">NOS MENUS</h1>
                <div class="trait-titre-page"></div>
                <p class="titre-page">Marchandise enlevée au magasin.</br>
                Livraison : prix selon distance.</p>
             </div>
        </div>
        <section class="liste-menu">
            <?php
                $bddMenu=$connexionBdd->query(" SELECT * FROM menus "); 
                $bddMenu->setFetchMode(PDO::FETCH_OBJ);
                if ($resultatMenu = $bddMenu->fetch()){
                    do{
                        echo "<div class='bloc-menu'>";

                            echo "<div class='ensemble-titre-menu'>";
                                echo "<div class='titre-menu'>".$resultatMenu->titre."</div>";
                                echo "<button type='button' class='btContenueMenu' data-id='".$resultatMenu->menu_id."'>+</button>";
                            echo "</div>";

                            echo "<div class='trait-titre-menu'></div>";
                            echo "<div class='description-menu'>".$resultatMenu->description."</div>";
                            
                            echo "<div class='contenu-menu' id='contenu-".$resultatMenu->menu_id."' style='display:none;'>";
                                echo "<div class='galerie-menu'>";
                                    for ($p = 1; $p <= 3; $p++) {
                                        echo    "<img 
                                                class='img-menu'
                                                loading='lazy'
                                                src='menu_image.php?id={$resultatMenu->menu_id}&p=$p'
                                                alt='Menu " . htmlspecialchars($resultatMenu->titre) . " - photo $p'
                                                >";
                                            }
                                echo "</div>";

                                echo "<div class='rappel-menu'>";
                                    echo "<div>"; echo "Regime : ". $resultatMenu->regime; echo "</div>";
                                    echo "<div>"; echo "Le menu « ".$resultatMenu->titre." » est composé de :"; echo "</div>";
                                echo "</div>";

                                echo "<div class='detail-menu'>";
                                    echo "<div>"; echo "$resultatMenu->entree"; echo "</div>";
                                    echo "<div>"; echo "$resultatMenu->plat"; echo "</div>";
                                    echo "<div>"; echo "$resultatMenu->dessert"; echo "</div>";
                                echo "</div>";

                                echo "<div class='info-menu'>";
                                    echo "<div>"; echo "$resultatMenu->allergene"; echo "</div>";
                                    echo "<div>"; echo " Pour " . "$resultatMenu->Nombre_minimum_de_personnes" . " Participants."; echo "</div>";
                                    echo "<div>"; echo " Prix : " . "$resultatMenu->prix" . " €."; echo "</div>";
                                    echo "<div>"; echo "$resultatMenu->conditions"; echo "</div>";
                                    echo "<div>"; echo " il nous reste " . "$resultatMenu->stock" . " commandes."; echo "</div>";
                                echo "</div>";

                                echo "<div class='placement-CTA-page-menu'>";
                                    echo "<a class='CTA-page-menu' href='passerunecommande.php'>Commander</a>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        }
                    while ($resultatMenu = $bddMenu->fetch());
                    $bddMenu->closeCursor();
                    } 
                ?>
        </section>

        
    </main>
    <footer id="info">
        <div class="info-entreprise">
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_adresse.svg">
                <div class="titre-info">Adresse</div>
                <div class="info-info">27 Rue des Faures, 33000 Bordeaux</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_tel.svg">
                <div class="titre-info">Téléphone</div>
                <div class="info-info">05 56 87 42 13</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_email.svg">
                <div class="titre-info">Email</div>
                <div class="info-info">contact@vite&gourmand.com</div>
            </div>
            <div class="colonne-info">
                <img class="picto-info" src="img/picto_clock.svg">
                <div class="titre-info">Horaire d'ouverture</div>
                <table class="info-info">
                    <tr>
                        <th>Lundi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>mardi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Mercredi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Jeudi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Vendredi</th>
                        <th class="h">9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Samedi</th>
                        <th class="h">10h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Dimanche</th>
                        <th class="h">10h00-13h00</th>
                    </tr>
                </table>
            </div>
        </div>
        <img class="logo-footer" src="img/logoblanc_cercle_transparent_150.png">
        <div class="mentions">
           @Minibrute - 2026 - Tous droits réservés - <a href="">Mentions Légales</a> - <a href="">conditions générales de ventes</a> - <a href="">Gestion des cookies</a>
        </div> 
    </footer>
    
</body>
    <script>
        const boutonHamburger = document.getElementById("boutonHamburger");
        const navHamburger = document.getElementById("navHamburger");

        boutonHamburger.addEventListener('click', () => {
        navHamburger .classList.toggle("hidden");
        });
    </script>

    <script>
        document.querySelectorAll('.btContenueMenu').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const bloc = document.getElementById('contenu-' + id);

                const opened = bloc.style.display === 'block';
                bloc.style.display = opened ? 'none' : 'block';
                btn.textContent = opened ? '+' : '-';
            });
        });
    </script>

</html>