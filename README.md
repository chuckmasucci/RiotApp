# League of Legends App

#### Objective
I wanted to build a "mini app" which leveraged an API and allowed me to store that data in a local database for later reuse. So with that in mind I decided to use the very robust Riot API to gather League of Legends game and static data info in order to show off a player's most recent games and statistics.

There is still a lot more which can be done with this site, but I wanted to make sure I was able to build a functional full-stack PHP app, even though it's very minimal in it's current state.

#### What it does
The home page (SITE_ROOT/) shows a list of the last 10 games played, and each list item is clickable to a more detailed page of the game's statistics.

The API (SITE_ROOT/api) allows for calls to be made to the various API models to pull in data from the [Riot API](https://developer.riotgames.com/) and store the data within the database.

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

#### Technology
* Developed on a LAMP (Linux, Apache 2.4, MySQL 5.7, PHP 7) environment
* Developed on Linux Mint 18.1.
* Hosted on Ubuntu 16.4 (WIP).

#### Notes
* While the site leverages the [Slim micro framework](https://www.slimframework.com/) to allow rapid prototyping without having to build a routing solution, all other code and site structure were coded and defined by me.
* Leveraging the [Skeleton](https://github.com/dhg/Skeleton) boilerplate for quick HTML & CSS prototyping.
