# 🏙️ VilleFacile

Application web en PHP avec architecture MVC et base de données MySQL — consultation et gestion des services proposés par les villes.

---

## Fonctionnalités

- 🔍 Consulter les services proposés par une ville
- ➕ Ajouter un service à une ville
- 🗑️ Supprimer un service

---

## Architecture

Le projet suit une architecture **MVC (Modèle - Vue - Contrôleur)** :

```
VilleFacile/
├── index.php          # Contrôleur frontal
├── controleurs/       # Contrôleurs
├── vues/              # Vues PHP
├── modele/            # Accès à la base de données
├── inc/               # Configuration et routes
│   ├── config-bd.example.php
│   ├── config-bd.php  # ⚠️ Non versionné
│   ├── routes.php
│   └── includes.php
├── css/               # Styles
├── img/               # Images
└── bd.sql             # Structure de la base de données
```

---

## Installation

### 1. Cloner le dépôt
```bash
git clone https://github.com/camille-daclin/VilleFacile.git
cd VilleFacile
```

### 2. Configurer la base de données
```bash
cp inc/config-bd.example.php inc/config-bd.php
```
Puis remplis tes identifiants dans `inc/config-bd.php` :
```php
define('SERVEUR', 'localhost');
define('UTILISATRICE', 'ton_login');
define('MOTDEPASSE', 'ton_mot_de_passe');
define('BDD', 'ta_base');
```

### 3. Importer la base de données
```bash
mysql -u ton_login -p ta_base < bd.sql
```

### 4. Lancer le projet
Place le dossier dans ton serveur local (XAMPP, MAMP, etc.) et accède à :
```
http://localhost/VilleFacile
```

---

## Technologies

- PHP
- MySQL
- HTML / CSS
- Architecture MVC

---

## Auteur

**Daclin Camille** — `p2210064`
