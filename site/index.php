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
    <title>Vite & Gourmand - Accueil</title>

</head>

<?php
    // Connexion à la base de données
    $connexionBdd = new PDO('mysql:host=localhost;dbname=viteetgourmand;charset=utf8', 'root', '');
?>

<body>
    <header>
       <img class="logo-header" src="img/logoblanc_cercle_transparent_150.png">
       <ul class="nav-classic">
            <li class="active"><a href="">ACCUEIL</a></li>
            <li><a href="">NOS MENUS</a></li>
            <li><a href="">CONNEXION</a></li>
            <li><a href="">CONTACT</a></li>
       </ul>
            <button id="boutonHamburger"><img class="picto-hamburger" src="img/picto_hamburger.png" ></button>
                <ul id="navHamburger" class="hidden">
                    <li class="active"><a href="">ACCUEIL</a></li>
                    <li><a href="">NOS MENUS</a></li>
                    <li><a href="">CONNEXION</a></li>
                    <li><a href="">CONTACT</a></li>
                </ul>
       </div>
       <img class="logo-header-2" src="img/logoblanc_cercle_transparent_150.png">
    </header>
    <main>

        <section class="hero" id="accueil">
            <div class="carousel">
                <div class="carousel-logo">
                    <img src="img/logoblanc_cercle_transparent.png" alt="Logo">
                </div>
                <div class="carousel-track">
                    <img src="img/img-carousel-1.jpg" alt="Image 1">
                    <img src="img/img-carousel-2.jpg" alt="Image 2">
                    <img src="img/img-carousel-3.jpg" alt="Image 3">
                </div>
            </div>
        </section>

        <section class="notre-histoire" id="notre-histoire">
            <div class="titreh1">
                <div class="trait"></div>
                <h1>Notre Histoire</h1>
                <div class="trait"></div>
            </div>
            <h2>"25 ans d'amour du goût et du partage."</h2>
            <div class ="contenue-histoire">
                <img class="photo-histoire" src="img/photo_notreHistoire.jpg" alt="notre histoire">
                <div class="texte-histoire">
                    <p class="resume">
                        Installée à 
                        <b style="color:#BB8A23">Bordeaux depuis plus de 25 ans, Vite & Gourmand</b> est née de la passion de 
                        <b style="color:#BB8A23">Julie et José</b> pour la 
                        <b style="color:#BB8A23">cuisine faite maison</b>.
                    </p>
                    <p class="resume">   
                        <b>Leur ambition : </b> offrir une 
                        <b style="color:#BB8A23">gastronomie généreuse, soignée</b> et 
                        <b style="color:#BB8A23">profondément humaine.</b>
                    </p>
                    <p class="resume">
                        Ce qui a commencé comme une 
                        <b style="color:#BB8A23">aventure familiale</b> est devenu 
                        <b style="color:#BB8A23">une référence locale</b>.
                    </p>
                    <div class="CTANosmenus">
                        <h3>Pour toutes vos commandes</h3>
                        <button id="CTANosmenus" href="">Venez découvrir nos menus</button>
                    </div>
                </div>
            </div>
            <p class ="accroche-histoire">
                 “Qu’il s’agisse d’un <b>repas simple</b>, d’un <b>événement festif</b> ou d’une <b>grande célébration</b>,
                nous avons à cœur d’apporter une touche de <b><br>chaleur et de convivialité</b>, comme si chaque prestation était reçue <b>chez nous</b>.”
            </p>
        </section>

        <section class="notre-equipe" id="notre-equipe">
            <div class="titreh1-equipe">
                    <div class="trait"></div>
                    <h1>Notre Équipe</h1>
                    <div class="trait"></div>
            </div>
            <h2 class="h2-notreequipe">“Deux passionnés, une même vision : vous régaler.”</h2>
            <p class="accroche-equipe">Derrière Vite & Gourmand, Julie et José travaillent main dans la main pour proposer une cuisine faite maison, pleine de saveurs et adaptée à chaque événement.</p>
            <div class="photo-equipe">
                <div class="ensemble-portrait">
                    <img class="portrait" src="img/julie_cercle.png">
                    <p class="nom-portrait">Julie</p>
                    <p class="poste-portrait">Cheffe & Co-Fondatrice</p>
                </div>
                <div class="ensemble-portrait">
                    <img class="portrait" src="img/josé_cercle.png">
                    <p class="nom-portrait">José</p>
                    <p class="poste-portrait">Chef Exécutif & Co-Fondateur</p>
                </div>
            </div>
            <p class="resume-equipe">
                <b style="color:#BB8A23">Julie & José, le duo derrière Vite & Gourmand</b>
                Julie crée des 
                <b style="color:#BB8A23">souvenirs gourmands</b>, José garantit une 
                <b style="color:#BB8A23">cuisine généreuse et maîtrisée</b>. 
                <br>Ensemble, ils partagent une vision : une cuisine 
                <b style="color:#BB8A23">authentique, créative</b> qui transforme chaque événement en 
                <b style="color:#BB8A23">moment gourmand</b>.
            </p>
        </section>

        <section class="notre-signature" id="notre-signature">
            <div class="titreh1">
                <div class="trait-signature"></div>
                <h1 class=h1-notresignature>Notre Signature</h1>
                <div class="trait-signature"></div>
            </div>
            <h2 class="h2-notresignature">“L’expérience Vite & Gourmand, l’art du fait-maison .”</h2>
            <div class="ensemble-carte">
                <div class="carte">
                    <img class="image-carte" src="img/carte-signature-1.jpg">
                    <div class="texte-carte">
                        <h4>Nos prestations</h4>
                        <p class="accroche-carte">“Du repas simple aux grands événements,<br>nous cuisinons chaque moment.”</p>
                        <p class="resume-carte">
                            <b>Repas du quotidien, menus festifs , anniversaires ou réunions familiales</b> : Vite & Gourmand s’adapte à toutes vos envies avec des 
                            <b></b>plats généreux et savoureux</b>. 
                        </p>
                    </div>
                </div>
                <div class="carte">
                    <img class="image-carte" src="img/carte-signature-2.jpg">
                    <div class="texte-carte">
                        <h4>Nos saveurs</h4>
                        <p class="accroche-carte">“Des recettes saisonnières <br>qui évoluent avec vos envies.”</p>
                        <p class="resume-carte">Nos menus changent régulièrement pour 
                            <b>suivre les saisons et les tendances culinaires</b>. Toujours à base de
                            <b>produits frais</b>, nous allions créativité, goût et équilibre.
                        </p>
                    </div>
                </div>
                <div class="carte">
                    <img class="image-carte" src="img/carte-signature-3.jpg">
                    <div class="texte-carte">
                        <h4>Notre engagement</h4>
                        <p class="accroche-carte">“Qualité, simplicité, gourmandise <br>notre promesse depuis 25 ans.”</p>
                        <p class="resume-carte">Nous mettons tout en œuvre pour faire de 
                            <b>chaque repas un moment agréable et mémorable</b>. Un
                            <b>service chaleureux, professionnel et centré sur votre satisfaction</b>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="CTANosmenus">
                <h3 class="h3-signature">Pour toutes vos commandes</h3>
                <button class="signatute" id="CTANosmenus" href="">Venez découvrir nos menus</button>
            </div>
        </section>

        <section class="avis" id="avis">
            <div class="titreh1-equipe">
                    <div class="trait"></div>
                    <h1>Ils Nous Ont Fait Confiance</h1>
                    <div class="trait"></div>
            </div>
            <h2 class="h2-notreequipe">"De beaux moments partagés, de jolies rencontres… merci pour tout"</h2>

            <div class="ensemble-carte">
                <?php
                    $bddAvis=$connexionBdd->query(" SELECT * FROM avis "); 
                    $bddAvis->setFetchMode(PDO::FETCH_OBJ);
                    if ($resultatAvis = $bddAvis->fetch()){
                            do{
                                echo "<div class='carte-avis'>";
                                    echo "<div class='avis-nom'>".$resultatAvis->avis_nom."</div>";
                                    echo "<div class='avis-theme'>".$resultatAvis->avis_theme."</div>";
                                    echo "<div class='avis-note'>".$resultatAvis->avis_note."</div>";
                                    echo "<div class='avis-description'>".$resultatAvis->avis_description."</div>";
                                echo "</div>";  
                            }
                    while ($resultatAvis = $bddAvis->fetch());
                    $bddAvis->closeCursor();
                    } 
                ?>
            </div>
        </section>

    </main>
    <footer>
        <div class="info-entreprise">
            <div class="adresse">
                <div class="picto-footer" src="img/''"></div>
                <div class="titre-footer">Adresse</div>
                <div class="info-footer">27 Rue des Faures, 33000 Bordeaux</div>
            </div>
            <div class="tel">
                <div class="picto" src="img/''"></div>
                <div class="titre-footer">Téléphone</div>
                <div class="info-footer">05 56 87 42 13</div>
            </div>
            <div class="email">
                <div class="picto" src="img/''"></div>
                <div class="titre-footer">Email</div>
                <div class="info-footer">contact@vite&gourmand.com</div>
            </div>
            <div class="horaire">
                <div class="picto" src="img/''"></div>
                <div class="titre-footer">Horaire d'ouverture</div>
                <table class="horaire">
                    <tr>
                        <th>Lundi</th>
                        <th>9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>mardi</th>
                        <th>9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Mercredi</th>
                        <th>9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Jeudi</th>
                        <th>9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Vendredi</th>
                        <th>9h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Samedi</th>
                        <th>10h00-18h00</th>
                    </tr>
                    <tr>
                        <th>Dimanche</th>
                        <th>10h00-13h00</th>
                    </tr>
                </table>
            </div>
        </div>
        <img class="logo-footer" src="img/logoblanc_cercle_transparent_150.png">
        <div class="mentions">@Minibrute - 2026 - Tous droits réservés - <a href="">Mentions Légales</a> - <a href="">conditions générales de ventes</a> - <a href="">Gestion des cookies</a>     
    </footer>
    
</body>
    <script>
        const boutonHamburger = document.getElementById("boutonHamburger");
        const navHamburger = document.getElementById("navHamburger");

        boutonHamburger.addEventListener('click', () => {
        navHamburger .classList.toggle("hidden");
        });
    </script>

</html>