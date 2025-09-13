# 🎓 Système de Matchmaking Studena

Un système intelligent de mise en relation entre tuteurs et étudiants basé sur les matières enseignées, les niveaux scolaires et les disponibilités.

## 📋 Table des matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Structure du projet](#structure-du-projet)
- [API](#api)
- [Tests](#tests)
- [Déploiement](#déploiement)
- [Contribution](#contribution)
- [Licence](#licence)

## 🎯 Aperçu

Studena Matchmaking est une application web développée avec Laravel qui permet de créer des correspondances optimales entre des tuteurs et des étudiants. Le système utilise un algorithme de compatibilité avancé qui prend en compte :

- **Les matières enseignées** par les tuteurs
- **Les niveaux scolaires** (Collège, Lycée, Terminale, Université)
- **Les disponibilités** horaires communes
- **Les préférences** et priorités des étudiants

### Exemple de fonctionnement

**Entrée :**
- **Tuteurs :** Ahmed (Mathématiques, Lycée, Lundi 18h-20h), Sarah (Physique, Collège & Lycée, Mercredi 14h-16h)
- **Étudiants :** Ali (Mathématiques, Lycée, Lundi 18h-20h), Yasmine (Physique, Collège, Mercredi 14h-16h)

**Sortie :**
- **Ali → Ahmed** (match parfait : matière + niveau + disponibilité)
- **Yasmine → Sarah** (match parfait)

## ✨ Fonctionnalités

### 🎯 Fonctionnalités principales
- **Dashboard moderne** avec statistiques en temps réel
- **Gestion des tuteurs** avec profils détaillés
- **Gestion des étudiants** avec préférences
- **Algorithme de matchmaking** intelligent
- **Calendrier des disponibilités** interactif
- **Système de rapports** et statistiques
- **Interface responsive** et moderne

### 🔧 Fonctionnalités avancées
- **Score de compatibilité** (0-100%)
- **Matchs parfaits** et partiels
- **Gestion des matières** et niveaux scolaires
- **Export/Import** des données
- **Système de messages** (en développement)
- **Paramètres configurables**

##  Technologies utilisées

- **Backend :** PHP 8.3+, Laravel 12.x
- **Base de données :** MySQL 8.0+
- **Frontend :** Bootstrap 5.3, Blade Templates
- **Icônes :** Bootstrap Icons
- **CSS :** Dégradés modernes, animations CSS
- **JavaScript :** Vanilla JS (pas d'AJAX pour la simplicité)

## 🚀 Installation

### Prérequis
- PHP 8.3 ou supérieur
- Composer
- MySQL 8.0 ou supérieur
- Node.js et NPM (optionnel)

### 1. Cloner le projet
```bash
git clone https://github.com/votre-username/studena-matchmaking.git
cd studena-matchmaking
```

### 2. Installer les dépendances
```bash
composer install
npm install  # Optionnel pour les assets
```

### 3. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configuration de la base de données
Modifiez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studena_matchmaking
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Exécuter les migrations
```bash
php artisan migrate
```

### 6. Seeder les données d'exemple
```bash
php artisan db:seed
```

### 7. Démarrer le serveur
```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## ⚙️ Configuration

### Variables d'environnement importantes

```env
# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studena_matchmaking
DB_USERNAME=root
DB_PASSWORD=

# Application
APP_NAME="Studena Matchmaking"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Cache et sessions
CACHE_DRIVER=file
SESSION_DRIVER=file
```

## 📖 Utilisation

### 1. Accès au dashboard
- Ouvrez `http://localhost:8000`
- Le dashboard affiche les statistiques générales

### 2. Ajouter des tuteurs
- Cliquez sur "Tuteurs" dans la sidebar
- Cliquez sur "Ajouter un tuteur"
- Remplissez les informations (nom, email, matières, niveaux, disponibilités)

### 3. Ajouter des étudiants
- Cliquez sur "Étudiants" dans la sidebar
- Cliquez sur "Ajouter un étudiant"
- Remplissez les informations (nom, email, niveau, matières demandées, disponibilités)

### 4. Lancer le matchmaking
- Cliquez sur "Matchmaking" dans la sidebar
- Cliquez sur "Lancer l'analyse"
- Consultez les résultats avec les scores de compatibilité

### 5. Consulter les rapports
- Cliquez sur "Rapports" dans la sidebar
- Visualisez les statistiques détaillées
- Exportez les données si nécessaire

## 📁 Structure du projet
