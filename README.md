# Legendary & Mythical Pokemon Catalogue

A comprehensive web-based catalogue exclusively featuring Legendary and Mythical Pokemon from all 9 generations.

## Quick Start

```bash
# Build and start containers
docker compose up --build

# Find your assigned ports
docker compose ps

# Access the site
http://localhost:[32770] - Gotta add later.
```

## Project Structure

```
legendary-mythical-pokemon-catalogue/
├── compose.yml              (Docker Compose File)
├── Dockerfile               
├── apache-dirlist.conf      
├── init.sql                 (Database)
├── private/                 (Private PHP files)
│   ├── connect.php          (mysqli connection)
│   ├── authentication.php
│   ├── functions.php
│   ├── prepared.php
│   └── validation.php
└── html/                    (Public web files)
    ├── index.php            (Homepage)
    ├── browse.php           (Main listing)
    ├── view.php             (Pokemon details)
    ├── add.php              (Add Pokemon)
    ├── edit.php             (Edit Pokemon)
    ├── delete.php           (Delete Pokemon)
    ├── delete-confirmation.php
    ├── login.php            (User login)
    ├── logout.php           (User logout)
    ├── admin.php            (Admin dashboard)
    ├── team_builder.php     (Team analysis)
    ├── includes/
    │   ├── header.php
    │   └── footer.php
    └── images/
        └── pokemon/
```

## Database

- **Name**: dmit2025
- **User**: student
- **Password**: student
- **Connection**: mysqli via private/connect.php

## Challenge Features

1. **Multi-Image Gallery (#4)** - Multiple images per Pokemon
2. **Tagging System (#6)** - Normalized tags with junction table
3. **Team Builder (#15)** - Advanced team analysis (custom challenge)

## Technologies

- PHP 8.4
- MySQL 8.0
- Bootstrap 5.3.7
- Docker & Docker Compose

## Access

- **Website**: http://localhost:[32770] - Gotta add later.
- **phpMyAdmin**: http://localhost:[32769] - Gotta add later.
  - Username: student
  - Password: student

## Data Source

**Serebii.net** - https://www.serebii.net/pokemon/all.shtml (for an easy overview with all necessary information - got to type the pokemon name since no filter available)
**Legends & Mythicals** - https://www.serebii.net/pokemon/legendary.shtml (for viewing current legendaries and mythicals available)
