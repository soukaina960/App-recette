<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMeal-Planner - Repas sains & intelligents</title>
    <meta name="description" content="Application desktop gratuite qui génère automatiquement vos repas sains et équilibrés.">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Alpine.js (pour les modals) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Scroll fluide partout */
        html { scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }

        /* Navbar fixe */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 50; }

        /* Hero plein écran */
        .hero-section { height: 100vh; min-height: 600px; }
        .hero-image {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; object-position: center;
        }

        /* Logo rond + animation */
        .logo-container {
            width: 80px; height: 80px; border-radius: 50%; overflow: hidden;
            border: 4px solid #10b981; transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .logo-container:hover {
            transform: scale(1.15) rotate(8deg);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.5);
            border-color: #059669;
        }
        .logo-img { width: 100%; height: 100%; object-fit: cover; }

        /* Boutons téléchargement */
        .dl-btn:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 25px 50px rgba(34, 197, 94, 0.4);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar avec modals -->
    <nav class="navbar bg-white shadow-xl" x-data="{ loginOpen: false, registerOpen: false }">
        <div class="max-w-screen-2xl mx-auto px-6">
            <div class="flex justify-between items-center py-5">
                <div class="flex items-center">
                    <div class="logo-container">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="SmartMeal-Planner" class="logo-img">
                    </div>
                    <span class="ml-4 text-2xl font-bold text-green-600">SmartMeal-Planner</span>
                </div>

                <div class="flex items-center space-x-5">

                    <button @click="registerOpen = true" 
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-7 py-3 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        S'inscrire
                    </button>

                    <button @click="loginOpen = true"
                            class="border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-white font-semibold px-7 py-3 rounded-xl transition">
                        Se connecter
                    </button>

                    <!-- Modal Register -->
                    <div x-show="registerOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60" 
                         @click.outside="registerOpen = false" x-cloak>
                        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-green-700">Créer votre compte</h3>
                                <button @click="registerOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="firstname" placeholder="Prénom" required class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                    <input type="text" name="lastname" placeholder="Nom" required class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                </div>
                                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                <input type="password" name="password" placeholder="Mot de passe (8+ caractères)" required minlength="8" class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="number" name="height" placeholder="Taille (cm)" required step="1" class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                    <input type="number" name="weight" placeholder="Poids (kg)" required step="0.1" class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition transform hover:scale-105">
                                    Créer mon compte
                                </button>
                            </form>
                            <p class="text-center text-sm text-gray-600 mt-4">
                                Déjà un compte ? 
                                <button @click="registerOpen = false; loginOpen = true" class="text-green-600 font-bold hover:underline">Se connecter</button>
                            </p>
                        </div>
                    </div>

                    <!-- Modal Login -->
                    <div x-show="loginOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60" 
                         @click.outside="loginOpen = false" x-cloak>
                        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-green-700">Connexion</h3>
                                <button @click="loginOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                <input type="password" name="password" placeholder="Mot de passe" required class="w-full px-4 py-3 border border-green-300 rounded-xl focus:outline-none focus:border-green-500">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition transform hover:scale-105">
                                    Se connecter
                                </button>
                            </form>
                            <p class="text-center text-sm text-gray-600 mt-4">
                                Pas encore de compte ? 
                                <button @click="loginOpen = false; registerOpen = true" class="text-green-600 font-bold hover:underline">S'inscrire</button>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative hero-section overflow-hidden">
        <img src="{{ asset('images/healty.jpg') }}" alt="Repas sains" class="hero-image">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60 flex items-center justify-center">
            <div class="text-center text-white px-6">
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold leading-tight mb-6 drop-shadow-2xl">
                    Healthy Food,<br><span class="text-green-400 drop-shadow-lg">Healthy Life</span>
                </h1>
                <p class="text-2xl sm:text-3xl md:text-4xl font-light max-w-4xl mx-auto leading-relaxed opacity-95 drop-shadow-xl mb-10">
                    Une alimentation saine n’est pas un régime,<br>
                    <span class="text-green-300 font-medium">c’est un mode de vie.</span>
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="#download" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold text-2xl px-16 py-6 rounded-full transition transform hover:scale-105 shadow-2xl">
                        Télécharger gratuitement
                    </a>
                    <a href="#discover" class="text-white border-2 border-white hover:bg-white hover:text-green-600 font-bold text-xl px-12 py-6 rounded-full transition">
                        Découvrir l’app
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Bienvenue -->
    <section id="discover" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">Bienvenue sur SmartMeal-Planner</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-12">
                Rejoignez des milliers de personnes qui ont déjà transformé leur alimentation et leur vie.
            </p>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-green-50 rounded-2xl hover:bg-green-100 transition">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">Nutrition Optimale</h3>
                    <p class="text-gray-700">Des repas équilibrés pour booster votre énergie</p>
                </div>
                <div class="p-8 bg-green-50 rounded-2xl hover:bg-green-100 transition">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">Recettes Faciles</h3>
                    <p class="text-gray-700">Prêtes en moins de 30 minutes</p>
                </div>
                <div class="p-8 bg-green-50 rounded-2xl hover:bg-green-100 transition">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">100% Naturel</h3>
                    <p class="text-gray-700">Sans additifs, sans compromis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Téléchargement -->
    <section id="download" class="py-24 bg-gradient-to-b from-green-50 via-green-100 to-emerald-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-5xl md:text-6xl font-black text-green-900 mb-6">
                Téléchargez <span class="text-green-600">SmartMeal-Planner</span><br>
                <span class="text-3xl md:text-4xl font-bold text-green-800">Gratuit • Sans inscription • Toutes plateformes</span>
            </h2>
            <p class="text-xl text-green-700 max-w-3xl mx-auto mb-16 font-medium">
                Disponible sur Windows, macOS et Linux • Fonctionne 100 % hors ligne
            </p>

            <div class="grid md:grid-cols-3 gap-10 max-w-4xl mx-auto">
                <a href="https://your-link.com/SmartMeal-Planner-Windows.exe" class="dl-btn group bg-white rounded-3xl p-10 shadow-2xl border-4 border-green-700 hover:bg-green-700 transition-all duration-300 transform hover:-translate-y-3">
                    <i class="fab fa-windows text-6xl text-green-700 group-hover:text-white mb-4"></i>
                    <h3 class="text-2xl font-bold text-green-900 group-hover:text-white">Windows</h3>
                    <p class="text-green-600 group-hover:text-green-100">.exe • 64-bit</p>
                </a>
                <a href="https://your-link.com/SmartMeal-Planner-macOS.dmg" class="dl-btn group bg-white rounded-3xl p-10 shadow-2xl border-4 border-green-700 hover:bg-green-700 transition-all duration-300 transform hover:-translate-y-3">
                    <i class="fab fa-apple text-6xl text-green-700 group-hover:text-white mb-4"></i>
                    <h3 class="text-2xl font-bold text-green-900 group-hover:text-white">macOS</h3>
                    <p class="text-green-600 group-hover:text-green-100">.dmg • Intel & Apple Silicon</p>
                </a>
                <a href="https://your-link.com/SmartMeal-Planner-Linux.AppImage" class="dl-btn group bg-white rounded-3xl p-10 shadow-2xl border-4 border-green-700 hover:bg-green-700 transition-all duration-300 transform hover:-translate-y-3">
                    <i class="fab fa-linux text-6xl text-green-700 group-hover:text-white mb-4"></i>
                    <h3 class="text-2xl font-bold text-green-900 group-hover:text-white">Linux</h3>
                    <p class="text-green-600 group-hover:text-green-100">.AppImage • Universel</p>
                </a>
            </div>

            <p class="mt-12 text-sm font-medium text-green-700">
                Version 1.5.2 • 24 novembre 2025 • 100 % sécurisé • Aucune inscription requise
            </p>
        </div>
    </section>

    <!-- Footer vert premium -->
    <footer class="bg-gradient-to-r from-green-800 via-green-700 to-emerald-800 text-white">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="logo-container mr-4">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="SmartMeal-Planner" class="logo-img">
                        </div>
                        <span class="text-2xl font-bold text-green-300">SmartMeal-Planner</span>
                    </div>
                    <p class="text-green-100 text-sm leading-relaxed">
                        L’application desktop intelligente qui crée automatiquement vos repas sains et délicieux.
                    </p>
                    <p class="text-green-200 text-xs mt-6">© 2025 SmartMeal-Planner. Tous droits réservés.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-300 mb-5">Fonctionnalités</h3>
                    <ul class="space-y-3 text-green-100 text-sm">
                        <li class="hover:text-white transition">Génération automatique de recettes</li>
                        <li class="hover:text-white transition">Calcul calories & macros</li>
                        <li class="hover:text-white transition">Liste de courses intelligente</li>
                        <li class="hover:text-white transition">Plans hebdomadaires</li>
                        <li class="hover:text-white transition">Mode hors ligne 100%</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-300 mb-5">Support</h3>
                    <a href="mailto:support@smartmealplanner.com" class="text-green-100 hover:text-white underline text-sm">
                        support@smartmealplanner.com
                    </a>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-300 mb-5">Télécharger l’app</h3>
                    <a href="#download" class="inline-block bg-white hover:bg-green-50 text-green-700 font-bold px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition">
                        Télécharger maintenant
                    </a>
                </div>
            </div>
            <div class="border-t border-green-600 mt-12 pt-8 text-center">
                <p class="text-green-200 text-xs">
                    Conçu avec passion pour une alimentation plus saine • 
                    <span class="text-white font-medium">Mangez mieux. Vivez mieux.</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Script pour scroll fluide parfait (même sur Safari) -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 90,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
        <!-- Scroll smooth parfait (fonctionne partout, même Safari/iOS) -->
    <script>
        // Active le scroll natif smooth
        document.documentElement.style.scrollBehavior = 'smooth';

        // Solution de secours pour tous les liens # (au cas où le CSS ne passe pas)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 100,   // 100px de marge pour la navbar fixe
                        behavior: 'smooth'
                    });

                    // Met à jour l’URL sans recharger la page
                    history.pushState(null, null, targetId);
                }
            });
        });
    </script>
    

</body>
</html>

</body>
</html>