# Challenge Features - Legendary & Mythical Pokemon Catalogue

## Challenge Feature #1: Multi-Image Gallery (Challenge #4)
**Location**: view.php
**Implementation**: 
- Pokemon have multiple images: regular, shiny, and alternate forms (we didnt use alternate forms because we already have too many but it is in the code but not the sql)
- Separate columns in database: `fullsize_image`, `thumbnail_image`, `shiny_image`
- Animated star toggle in top-left corner switches between normal/shiny versions
- Shiny badge appears when viewing shiny variant
- Images stored in organized directories: fullsize/, thumbnails/

## Challenge Feature #2: Normalized Tagging System (Challenge #6)
**Location**: Database schema (init.sql / CREATE TABLE statements)
**Implementation**:
- Separate `tags` table for tag definitions
- Junction table `pokemon_tags` linking Pokemon to tags
- Allows many-to-many relationships (one Pokemon can have multiple tags)
- Tags include: type-based, generation-based, classification categories
- Can be expanded without modifying main Pokemon table

## Challenge Feature #3: Team Builder - Advanced Analysis (Custom Challenge #15)
**Location**: team_builder.php
**Implementation**:
- Users can select up to 6 Pokemon to build a team
- Team analysis features:
  * Total stats calculation across all team members
  * Type distribution chart showing team composition
  * Weakness/resistance analysis by type
  * Individual Pokemon cards with quick stats
- Session-based storage (persists across pages)
- Add/remove Pokemon from team on any page