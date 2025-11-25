# Legendary & Mythical Pokemon Catalogue

A comprehensive web-based catalogue exclusively featuring Legendary and Mythical Pokemon from all 9 generations (Kanto through Paldea).

## Project Structure

```
legendary-mythical-pokemon-catalogue/
│
├── 📄 README.md                     ← You are here
├── 📄 .gitignore                    ← Git ignore rules
├── 📄 .dockerignore                 ← Docker ignore rules
├── 🐳 compose.yml                   ← Docker Compose configuration
├── 🐳 Dockerfile                    ← PHP 8.4 Apache image build
├── 📄 public.conf                   ← Apache configuration
│
├── 📁 data/                         ← Database files
│   ├── 📄 init.sql                  ← Database initialization (add your data here)
│   ├── 📄 connect.php               ← Database connection
│   └── 📄 complete_pokemon_data.sql ← Reference: All 95 Pokemon
│
└── 📁 html/                         ← Web application  
    ├── 📄 index.php                 ← Main catalogue page
    ├── 📄 detail.php                ← Pokemon details
    ├── 📄 create.php                ← Add Pokemon
    ├── 📄 edit.php                  ← Edit Pokemon
    ├── 📄 delete.php                ← Delete Pokemon
    ├── 📄 search.php                ← Search/filter page
    ├── 📄 team_builder.php          ← Team builder feature
    │
    ├── 📁 includes/                 ← Reusable components
    │   ├── 📄 header.php            ← Page header (Bootstrap navbar)
    │   ├── 📄 footer.php            ← Page footer (Bootstrap footer)
    │   └── 📄 filter.php            ← Filter component
    │
    └── 📁 images/                   ← Pokemon sprites
        └── 📄 README.md             ← Image naming guide
```

## Database Credentials

- **Username**: `student`
- **Password**: `student`
- **Database**: `legendary_pokemon_catalogue`
- **Root Password**: `studentpass`

## Features

### Core Features
- Browse all Legendary & Mythical Pokemon
- View detailed information for each Pokemon
- Create, Read, Update, Delete (CRUD) operations
- Search and filter by multiple criteria
- **Bootstrap 5.3.2 styling** (no custom CSS needed!)

### Challenge Features

1. **Multi-Image Gallery (#4)**
   - Regular, shiny, and alternate form sprites
   - Toggle between different forms

2. **Tagging System (#6)**
   - Organized by legendary groups (Legendary Birds, Weather Trio, etc.)
   - Filter by tags and classifications

3. **Team Builder with Stats Analysis (#15 - Custom Challenge)**
   - Select up to 6 Pokemon
   - Calculate average stats
   - Show type distribution
   - Analyze team weaknesses
   - Display strongest in each category

## Quick Start

### 1. Build and Start Containers
```bash
docker compose up --build
```

### 2. Find Your Port
Docker will assign random ports. Check with:
```bash
docker compose ps
```

Look for output like:
```
NAME                   PORTS
legendary-web-1        0.0.0.0:54321->80/tcp
legendary-mysql-1      0.0.0.0:54322->3306/tcp
legendary-phpmyadmin-1 0.0.0.0:54323->80/tcp
```

### 3. Access Application
- **Main Site**: http://localhost:54321 (use your assigned port)
- **phpMyAdmin**: http://localhost:54323 (use your assigned port)
  - Username: `student`
  - Password: `student`

## Docker Commands

```bash
# Build and start containers
docker compose up --build

# Start containers (after first build)
docker compose up

# Start in detached mode (background)
docker compose up -d

# Stop containers
docker compose down

# View logs
docker compose logs
docker compose logs web
docker compose logs mysql

# Rebuild from scratch
docker compose down
docker compose up --build

# Check running containers and ports
docker compose ps

# Access MySQL directly
docker compose exec mysql mysql -u student -pstudent legendary_pokemon_catalogue

# Access web container shell
docker compose exec web bash
```

## Development Workflow

### Adding Pokemon Data
1. Open `data/init.sql`
2. Add INSERT statements after the table creation
3. **OR** copy from `data/complete_pokemon_data.sql` (has all 95 Pokemon)
4. Rebuild: `docker compose down && docker compose up --build`

### Editing PHP Files
1. Edit files in `html/` folder
2. Save changes
3. Refresh browser (changes appear immediately, no restart needed)

### Adding Images
1. Place sprites in `html/images/`
2. Follow naming convention: `pokemon_name.png`, `pokemon_name_shiny.png`

## Bootstrap 5.3.2

This project uses **Bootstrap 5.3.2** via CDN (no custom CSS file needed!):

### Included:
- ✅ Bootstrap CSS
- ✅ Bootstrap Icons  
- ✅ Bootstrap JS (for mobile navbar)
- ✅ Responsive grid system
- ✅ Pre-styled components (cards, forms, buttons, alerts)

### Example Classes Used:
```php
<div class="col-lg-4 col-md-6">               // Responsive columns
<div class="card h-100 shadow-sm">            // Card with shadow
<span class="badge bg-primary">Fire</span>    // Badge
<button class="btn btn-success">Add</button>  // Button
<div class="alert alert-danger">Warning</div> // Alert
```

See `BOOTSTRAP_GUIDE.md` for complete reference.

## Database Schema

### Pokemon Table Columns:
- `id` - Primary key (AUTO_INCREMENT)
- `name`, `pokedex_number` - Basic info
- `type1`, `type2` - Pokemon types
- `classification` - Legendary/Mythical/Ultra Beast
- `generation`, `region` - Generation info
- `hp`, `attack`, `defense`, `sp_attack`, `sp_defense`, `speed`, `base_stat_total` - Stats for Team Builder
- `regular_image`, `shiny_image`, `has_alternate_forms`, `alternate_form_images` - Multi-Image Gallery
- `description`, `lore_story`, `how_to_obtain` - Descriptions
- `legendary_group`, `tags` - Tagging System
- `abilities`, `signature_move`, `height_m`, `weight_kg` - Additional info
- `is_event_exclusive`, `games_available` - Availability
- `date_added`, `last_updated` - Metadata

## Data Source

All Pokemon data sourced from [Serebii.net](https://www.serebii.net/pokemon/all.shtml)

~95 Legendary & Mythical Pokemon from Generations 1-9 included in reference file.

## Technologies

- **Backend**: PHP 8.4
- **Database**: MySQL 8.0
- **Web Server**: Apache 2.4
- **Containerization**: Docker & Docker Compose
- **Frontend**: Bootstrap 5.3.2 (CDN)

## Troubleshooting

### Port Already in Use
Compose uses `"0:80"` which assigns random available ports. Check `docker compose ps` for actual ports.

### Database Not Loading
```bash
docker compose down
docker compose up --build
# Wait 30 seconds for init.sql to run
```

### Changes Not Showing
- PHP changes: Just refresh browser
- SQL changes: `docker compose down && docker compose up --build`
- Docker config changes: `docker compose down && docker compose up --build`

### Can't Connect to Database
Check that service name is `mysql` (not `db` or `localhost`):
```php
$host = 'mysql';  // Must match service name in compose.yml
```

## Team Members
- [Your names here]

## Course Information
- **Course**: DMIT2025 - Web Application Development
- **Professor**: [Professor name]
- **Semester**: [Semester/Year]

## License
Educational project for course requirements.
