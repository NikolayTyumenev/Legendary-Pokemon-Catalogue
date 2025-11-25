-- ============================================
-- LEGENDARY & MYTHICAL POKEMON DATABASE
-- ALL GENERATIONS (1-9)
-- ============================================
-- Total: ~80-95 Legendary and Mythical Pokemon
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS legendary_pokemon_catalogue;
USE legendary_pokemon_catalogue;

-- Drop existing table
DROP TABLE IF EXISTS pokemon;

-- Create pokemon table
CREATE TABLE pokemon (
  -- PRIMARY KEY
  id INT AUTO_INCREMENT PRIMARY KEY,
  
  -- BASIC INFORMATION
  name VARCHAR(100) NOT NULL,
  pokedex_number INT NOT NULL,
  
  -- TYPES
  type1 VARCHAR(20) NOT NULL,
  type2 VARCHAR(20) NULL,
  
  -- CLASSIFICATION
  classification ENUM('Legendary', 'Mythical', 'Sub-Legendary', 'Ultra Beast', 'Paradox') NOT NULL,
  generation INT NOT NULL,
  region VARCHAR(50) NOT NULL,
  
  -- STATS (for Team Builder)
  hp INT NOT NULL,
  attack INT NOT NULL,
  defense INT NOT NULL,
  sp_attack INT NOT NULL,
  sp_defense INT NOT NULL,
  speed INT NOT NULL,
  base_stat_total INT NOT NULL,
  
  -- IMAGES (for Multi-Image Gallery)
  regular_image VARCHAR(255) NOT NULL,
  shiny_image VARCHAR(255) NULL,
  has_alternate_forms BOOLEAN DEFAULT FALSE,
  alternate_form_images TEXT NULL,
  form_descriptions TEXT NULL,
  
  -- DESCRIPTION & LORE
  description TEXT NOT NULL,
  lore_story TEXT NULL,
  how_to_obtain TEXT NULL,
  
  -- TAGGING SYSTEM
  legendary_group VARCHAR(100) NULL,
  tags TEXT NULL,
  
  -- ADDITIONAL INFO
  abilities TEXT NULL,
  signature_move VARCHAR(100) NULL,
  height_m DECIMAL(4,2) NULL,
  weight_kg DECIMAL(5,1) NULL,
  
  -- AVAILABILITY
  is_event_exclusive BOOLEAN DEFAULT FALSE,
  games_available TEXT NULL,
  
  -- METADATA
  date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  -- INDEXES
  INDEX idx_type1 (type1),
  INDEX idx_classification (classification),
  INDEX idx_generation (generation),
  INDEX idx_legendary_group (legendary_group)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- INSERT YOUR POKEMON DATA HERE
-- ============================================
-- Example format:
-- INSERT INTO pokemon VALUES 
-- (NULL, 'Mewtwo', 150, 'Psychic', NULL, 'Legendary', 1, 'Kanto', 
--  106, 110, 90, 154, 90, 130, 680,
--  'mewtwo.png', 'mewtwo_shiny.png', TRUE, 'mewtwo_mega_x.png,mewtwo_mega_y.png', 'Mega X, Mega Y',
--  'Created by scientists through genetic manipulation.', 'Created to be ultimate battle Pokemon.', 
--  'Cerulean Cave post-Elite Four', NULL, 'Legendary,Generation 1,Psychic,Kanto,Box Legendary,Mega Evolution',
--  'Pressure, Unnerve', 'Psystrike', 2.0, 122.0, FALSE, 'RBY, GSC, FRLG, HGSS, XY, LGPE', NOW(), NOW());
-- ============================================

-- Add your INSERT statements below:

