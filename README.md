# Riot Games App

#### Objective
Create a "mini app" that allows a player to view their most recent League of Legends games and view their stats.

#### What it does
The home page (SITE_ROOT/) shows a list of the last 10 games played, and each list item is clickable to a more detailed page of the game's statistics.

The API (SITE_ROOT/api) allows for calls to be to the API model to pull in data from the Riot API and store within the database.

#### Structure
```
.
├── app
│   ├── logs
│   │   └── app.log
│   ├── schemas
│   │   └── schema.sql
│   ├── src
│   │   ├── config
│   │   │   └── config.php
│   │   ├── container.php
│   │   ├── Controllers
│   │   │   ├── HomeController.php
│   │   │   ├── MatchController.php
│   │   │   └── RiotAPIController.php
│   │   ├── Models
│   │   │   ├── ChampionsModel.php
│   │   │   ├── ItemsModel.php
│   │   │   ├── MatchesModel.php
│   │   │   ├── MatchListModel.php
│   │   │   ├── RiotModel.php
│   │   │   └── SummonerSpellsModel.php
│   │   └── routes.php
│   └── templates
│       ├── api.phtml
│       ├── home.phtml
│       └── match.phtml
├── composer.json
├── composer.lock
├── composer.phar
├── public
│   ├── css
│   │   ├── main.css
│   │   ├── normalize.css
│   │   └── skeleton.css
│   ├── index.php
│   └── scripts
├── README.md

```

#### Notes
While the site leverages the Slim PHP micro framework to allow rapid prototyping without having to build a routeing solution, all other code and structure was coded and defined by me.
