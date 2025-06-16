let page = 1; // Page actuelle pour la pagination des animés

function loadAnime(page = 1, query = '') {
    // Construction de l'URL à utiliser selon s'il y a une recherche (query) ou non
    const url = query
        ? `https://api.jikan.moe/v4/anime?q=${encodeURIComponent(query)}&limit=24`
        : `https://api.jikan.moe/v4/anime?page=${page}&limit=24`;

    // Requête à l'API Jikan
    fetch(url)
        .then(res => res.json()) // Conversion de la réponse en JSON
        .then(data => {
            const container = document.getElementById('posts-anime'); // Conteneur HTML pour les animés
            container.innerHTML = ''; // Vide le conteneur avant d'afficher les nouveaux résultats

            const titre = document.getElementById('anime-title'); // Élément titre (non utilisé ici)

            data.data.forEach(anime => {
                // Création d'un élément div pour chaque animé
                const div = document.createElement('div');
                div.className = 'post'; // Classe CSS

                // Ajout du contenu HTML dans la div : titre, image, résumé
                div.innerHTML = `
                    <h2>${anime.title}</h2>
                    <img src="${anime.images.jpg.image_url}" alt="${anime.title}">
                    <p>${anime.synopsis ? anime.synopsis.substring(0, 250) + '…' : 'Pas de synopsis disponible.'}</p>
                `;
                container.appendChild(div); // Ajoute l'élément au DOM
            });
        });
}

// Dictionnaire de traduction français → japonais
const traductions = {
  "Publication": "パブリッシング",
  "Bienvenue sur BlogAnime !": "BlogAnime へようこそ！",
  "Administrateur": "管理者",
  "Vous n'êtes pas connecté.": "ログインしていません。",
  "Animes": "アニメ",
  "Page précédente":"前のページ",
  "Page suivante":"次のページ",
  "Déconnexion":"断線",
  "Connexion":"接続",
  "Inscription":"登録",
  "Faire un post":"ポスト",
  "Modifier un post":"投稿を編集する",
  "Supprimer un post":"投稿を削除する",
  "Rechercher":"を検索",
  "Tous les types":"あらゆる種類の",
  "Série TV":"テレビ番組",
  "Film":"膜",
  "OVA":"卵子",
  "ONA":"オナ",
  "Spécial":"特別",
  "Musique":"音楽",
  "Rechercher un animé...":"アニメーションを検索してください。。。",
  "Mon Profile":"私のプロフィール"
};

function traduire(versJaponais) {
  const elements = document.querySelectorAll(".traductible"); // Tous les éléments à traduire

  elements.forEach(el => {
    // Si l'élément a un placeholder (ex : champ de recherche)
    if (el.placeholder !== undefined) {
      const original = el.placeholder.trim(); // Texte d'origine
      if (versJaponais) {
        el.dataset.original = original; // Sauvegarde dans un attribut data
        if (traductions[original]) {
          el.placeholder = traductions[original]; // Remplacement si une traduction existe
        }
      } else {
        if (el.dataset.original) {
          el.placeholder = el.dataset.original; // Restauration
        }
      }
    } else {
      // Sinon on gère le texte visible (ex : <p>, <h1>)
      const texte = el.textContent.trim();
      if (versJaponais) {
        el.dataset.original = texte;
        if (traductions[texte]) {
          el.textContent = traductions[texte]; // Traduction
        }
      } else {
        if (el.dataset.original) {
          el.textContent = el.dataset.original; // Restauration
        }
      }
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const bouton = document.getElementById("easter-egg"); // Bouton secret
  const langue = localStorage.getItem("langue"); // Langue mémorisée

  if (langue === "jp") {
    traduire(true); // Appliquer directement la traduction
  }

  if (bouton) {
    bouton.addEventListener("click", () => {
      const nouvelleLangue = localStorage.getItem("langue") === "jp" ? "fr" : "jp";
      localStorage.setItem("langue", nouvelleLangue); // Mémorisation
      traduire(nouvelleLangue === "jp"); // Appliquer la nouvelle langue
    });
  }
});

function loadArticles() {
  // Requête pour charger les articles depuis le backend (PHP)
  fetch('articles.php')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('pagination'); // Conteneur des articles

      data.forEach(post => {
        const div = document.createElement('div'); // Création d'une div par article
        div.className = 'post';
        div.innerHTML = `
          <h2>${post.title}</h2>
          <p>${post.content.replace(/\n/g, '<br>')}</p>
          <small>Par ${post.author} le ${post.created_at}</small>
        `;
        container.appendChild(div); // Ajout dans le DOM
      });
    });
}

const toggleBtn = document.getElementById('toggle-theme'); // Bouton thème clair/sombre
const body = document.body;

// Appliquer le thème sombre s'il est stocké dans localStorage
if (localStorage.getItem("theme") === "dark") {
  body.classList.add("dark-mode");
  toggleBtn.textContent = "Mode clair"; // Changer le texte du bouton
}

toggleBtn.addEventListener("click", () => {
  body.classList.toggle("dark-mode"); // Ajoute/enlève le mode sombre
  const isDark = body.classList.contains("dark-mode");
  toggleBtn.textContent = isDark ? "Mode clair" : "Mode sombre"; // Mise à jour du bouton
  localStorage.setItem("theme", isDark ? "dark" : "light"); // Sauvegarde
});

window.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form'); // Formulaire de recherche
    const searchInput = document.getElementById('search-input'); // Champ de recherche

    searchForm.addEventListener('submit', e => {
        e.preventDefault(); // Empêche le rechargement de la page
        const query = searchInput.value.trim(); // Récupère la recherche
        if (query.length > 0) {
            loadAnime(1, query); // Charge les animés selon la recherche
        }
    });

    loadArticles(); // Chargement initial des articles
    loadAnime(page); // Chargement initial des animés
});

