-- DMIT2025 POKEMON CATALOGUE - COMPLETE DATABASE
-- Group 3: Legendary & Mythical Pokemon

-- This file creates:
-- 1. Pokemon table (29 columns) - matches add.php/edit.php
-- 2. Admin user table (5 users)
-- 3. ALL Legendary & Mythical Pokemon (Gen 1-9)
-- All passwords set to: student

-- Database will be auto-created by Docker as dmit2025


-- DROP EXISTING TABLES


DROP TABLE IF EXISTS pokemon_tags;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS pokemon_images;
DROP TABLE IF EXISTS pokemon;
DROP TABLE IF EXISTS group_3_catalogue_admin;


-- POKEMON TABLE (29 columns - matches your working code)


CREATE TABLE pokemon (
  -- PRIMARY KEY
  id INT AUTO_INCREMENT PRIMARY KEY,
  
  -- BASIC INFORMATION (7 columns)
  name VARCHAR(100) NOT NULL,
  pokedex_number INT NOT NULL,
  type1 VARCHAR(20) NOT NULL,
  type2 VARCHAR(20) NULL,
  classification ENUM('Legendary', 'Mythical', 'Sub-Legendary', 'Ultra Beast', 'Paradox') NOT NULL,
  generation INT NOT NULL,
  region VARCHAR(50) NOT NULL,
  
  -- BASE STATS (7 columns)
  hp INT NOT NULL,
  attack INT NOT NULL,
  defense INT NOT NULL,
  sp_attack INT NOT NULL,
  sp_defense INT NOT NULL,
  speed INT NOT NULL,
  base_stat_total INT NOT NULL,
  
  -- IMAGES (5 columns) - CRITICAL: This order matches add.php/edit.php
  regular_image VARCHAR(255) NULL,
  thumbnail_image VARCHAR(255) NULL,
  fullsize_image VARCHAR(255) NULL,
  shiny_image VARCHAR(255) NULL,
  has_alternate_forms TINYINT(1) DEFAULT 0,
  
  -- DESCRIPTION & LORE (3 columns)
  description TEXT NOT NULL,
  lore_story TEXT NULL,
  how_to_obtain TEXT NULL,
  
  -- ADDITIONAL INFO (7 columns)
  legendary_group VARCHAR(100) NULL,
  abilities TEXT NULL,
  signature_move VARCHAR(100) NULL,
  height_m DECIMAL(5,2) NULL,
  weight_kg DECIMAL(6,1) NULL,
  is_event_exclusive TINYINT(1) DEFAULT 0,
  games_available TEXT NULL,
  
  -- TIMESTAMPS (auto-managed)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  -- INDEXES
  INDEX idx_type1 (type1),
  INDEX idx_classification (classification),
  INDEX idx_generation (generation),
  INDEX idx_legendary_group (legendary_group)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- ADMIN TABLE
-- ============================================

CREATE TABLE group_3_catalogue_admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert admin accounts
-- Password for ALL accounts: student
-- Hash: $2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC

INSERT INTO group_3_catalogue_admin (username, password) VALUES
('Nikolay', '$2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC'),
('Charis', '$2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC'),
('Sheena', '$2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC'),
('Ady', '$2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC'),
('instructor', '$2a$12$xzH1wPZchaHFl3tpYIAJBO5F5Jh6EIDqkQcM9YQiNBESmS2foLYOC');

-- ============================================
-- POKEMON DATA - ALL LEGENDARIES & MYTHICALS
-- ============================================
-- Note: Images are NULL - add via admin interface
-- Total: ~95 Pokemon across all 9 generations

-- ============================================
-- GENERATION 1 - KANTO (5 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Articuno', 144, 'Ice', 'Flying', 'Legendary', 1, 'Kanto',
 90, 85, 100, 95, 125, 85, 580,
 NULL, NULL, NULL, NULL, 0,
 'A legendary bird Pokemon that is said to appear to doomed people who are lost in icy mountains.',
 'Articuno is said to live in icy mountains and appears to travelers lost in snow.',
 'Seafoam Islands after 8 badges',
 'Legendary Birds', 'Pressure, Snow Cloak', 'Freeze-Dry', 1.7, 55.4, 0, 'RBY, GSC, FRLG, HGSS, XY, LGPE, SwSh'),

('Zapdos', 145, 'Electric', 'Flying', 'Legendary', 1, 'Kanto',
 90, 90, 85, 125, 90, 100, 580,
 NULL, NULL, NULL, NULL, 0,
 'A legendary bird Pokemon that is said to appear from clouds while dropping enormous lightning bolts.',
 'Zapdos nests in thunderclouds and gains power from lightning strikes.',
 'Power Plant in Kanto',
 'Legendary Birds', 'Pressure, Static', 'Thunder Shock', 1.6, 52.6, 0, 'RBY, GSC, FRLG, HGSS, XY, LGPE, SwSh'),

('Moltres', 146, 'Fire', 'Flying', 'Legendary', 1, 'Kanto',
 90, 100, 90, 125, 85, 90, 580,
 NULL, NULL, NULL, NULL, 0,
 'A legendary bird Pokemon that is said to bring early spring to the wintry lands it visits.',
 'Moltres migrates from the south bringing spring. Heals in volcanoes.',
 'Victory Road after 8 badges',
 'Legendary Birds', 'Pressure, Flame Body', 'Heat Wave', 2.0, 60.0, 0, 'RBY, GSC, FRLG, HGSS, XY, LGPE, SwSh'),

('Mewtwo', 150, 'Psychic', NULL, 'Legendary', 1, 'Kanto',
 106, 110, 90, 154, 90, 130, 680,
 NULL, NULL, NULL, NULL, 1,
 'Created by scientists through genetic manipulation from Mew DNA.',
 'Mewtwo was created to be the ultimate battle Pokemon through gene splicing.',
 'Cerulean Cave post-Elite Four',
 NULL, 'Pressure, Unnerve', 'Psystrike', 2.0, 122.0, 0, 'RBY, GSC, FRLG, HGSS, XY, LGPE, SwSh'),

('Mew', 151, 'Psychic', NULL, 'Mythical', 1, 'Kanto',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 0,
 'So rare that it is still said to be a mirage by many experts.',
 'Mew possesses the genetic composition of all Pokemon and is their ancestor.',
 'Event-exclusive only',
 NULL, 'Synchronize', 'Psychic', 0.4, 4.0, 1, 'Events Only');

-- ============================================
-- GENERATION 2 - JOHTO (6 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Raikou', 243, 'Electric', NULL, 'Legendary', 2, 'Johto',
 90, 85, 75, 115, 100, 115, 580,
 NULL, NULL, NULL, NULL, 0,
 'The rain clouds it carries let it fire thunderbolts at will.',
 'Raikou embodies the speed of lightning and roars like thunder.',
 'Roaming Johto after Burned Tower',
 'Legendary Beasts', 'Pressure, Inner Focus', 'Thunder', 1.9, 178.0, 0, 'GSC, FRLG, HGSS'),

('Entei', 244, 'Fire', NULL, 'Legendary', 2, 'Johto',
 115, 115, 85, 90, 75, 100, 580,
 NULL, NULL, NULL, NULL, 0,
 'Volcanoes erupt when it barks. Unable to contain its sheer power.',
 'Entei embodies magma passion and was born in volcanic eruption.',
 'Roaming Johto after Burned Tower',
 'Legendary Beasts', 'Pressure, Inner Focus', 'Sacred Fire', 2.1, 198.0, 0, 'GSC, FRLG, HGSS'),

('Suicune', 245, 'Water', NULL, 'Legendary', 2, 'Johto',
 100, 75, 115, 90, 115, 85, 580,
 NULL, NULL, NULL, NULL, 0,
 'Said to be the embodiment of north winds, it can purify water.',
 'Suicune embodies pure spring water blessed by the north wind.',
 'Roaming Johto, Tin Tower in Crystal',
 'Legendary Beasts', 'Pressure, Inner Focus', 'Aurora Beam', 2.0, 187.0, 0, 'GSC, FRLG, HGSS'),

('Lugia', 249, 'Psychic', 'Flying', 'Legendary', 2, 'Johto',
 106, 90, 130, 90, 154, 110, 680,
 NULL, NULL, NULL, NULL, 0,
 'It quietly spends time deep at the bottom of the sea.',
 'Lugia is guardian of the seas and master of the legendary birds.',
 'Whirl Islands with Silver Wing',
 'Tower Duo', 'Pressure, Multiscale', 'Aeroblast', 5.2, 216.0, 0, 'Silver, Crystal, XD, HGSS'),

('Ho-Oh', 250, 'Fire', 'Flying', 'Legendary', 2, 'Johto',
 106, 130, 90, 110, 154, 90, 680,
 NULL, NULL, NULL, NULL, 0,
 'Legends claim this Pokemon flies the world\'s skies continuously.',
 'Ho-Oh is guardian of the skies and master of legendary beasts.',
 'Tin Tower with Rainbow Wing',
 'Tower Duo', 'Pressure, Regenerator', 'Sacred Fire', 3.8, 199.0, 0, 'Gold, Crystal, Colosseum, HGSS'),

('Celebi', 251, 'Psychic', 'Grass', 'Mythical', 2, 'Johto',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 0,
 'This Pokemon wanders across time. Forests flourish where it appears.',
 'Celebi travels through time and only appears during times of peace.',
 'Event-exclusive, Pokemon Bank',
 NULL, 'Natural Cure', 'Future Sight', 0.6, 5.0, 1, 'Events, Pokemon Bank');

-- ============================================
-- GENERATION 3 - HOENN (10 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Regirock', 377, 'Rock', NULL, 'Legendary', 3, 'Hoenn',
 80, 100, 200, 50, 100, 50, 580,
 NULL, NULL, NULL, NULL, 0,
 'Regirock was sealed away long ago. It repairs itself with rocks.',
 'Made entirely of rocks, sealed in ancient tomb, repairs with new rocks.',
 'Desert Ruins puzzle',
 'Legendary Titans', 'Clear Body, Sturdy', 'Stone Edge', 1.7, 230.0, 0, 'RSE, Pt, B2W2, ORAS'),

('Regice', 378, 'Ice', NULL, 'Legendary', 3, 'Hoenn',
 80, 50, 100, 100, 200, 50, 580,
 NULL, NULL, NULL, NULL, 0,
 'Regice cloaks itself with frigid air of -328 degrees Fahrenheit.',
 'Made of ice age ice, controls cryogenic air of -328°F.',
 'Island Cave puzzle',
 'Legendary Titans', 'Clear Body, Ice Body', 'Ice Beam', 1.8, 175.0, 0, 'RSE, Pt, B2W2, ORAS'),

('Registeel', 379, 'Steel', NULL, 'Legendary', 3, 'Hoenn',
 80, 75, 150, 75, 150, 50, 580,
 NULL, NULL, NULL, NULL, 0,
 'Registeel has a body harder than any metal. Apparently hollow.',
 'Made of unknown metal harder than any known metal.',
 'Ancient Tomb puzzle',
 'Legendary Titans', 'Clear Body, Light Metal', 'Flash Cannon', 1.9, 205.0, 0, 'RSE, Pt, B2W2, ORAS'),

('Latias', 380, 'Dragon', 'Psychic', 'Legendary', 3, 'Hoenn',
 80, 80, 90, 110, 130, 110, 600,
 NULL, NULL, NULL, NULL, 1,
 'Highly intelligent and can understand human speech.',
 'Can sense emotions and become invisible using psychic powers.',
 'Roaming Hoenn, Southern Island',
 'Eon Duo', 'Levitate', 'Mist Ball', 1.4, 40.0, 0, 'Sapphire, Emerald, HeartGold, OmegaRuby, AlphaSapphire'),

('Latios', 381, 'Dragon', 'Psychic', 'Legendary', 3, 'Hoenn',
 80, 90, 80, 130, 110, 110, 600,
 NULL, NULL, NULL, NULL, 1,
 'Understands human speech and is highly intelligent.',
 'Can project images into minds and fly faster than a jet.',
 'Roaming Hoenn, Southern Island',
 'Eon Duo', 'Levitate', 'Luster Purge', 2.0, 60.0, 0, 'Ruby, Emerald, SoulSilver, OmegaRuby, AlphaSapphire'),

('Kyogre', 382, 'Water', NULL, 'Legendary', 3, 'Hoenn',
 100, 100, 90, 150, 140, 90, 670,
 NULL, NULL, NULL, NULL, 1,
 'Can summon storms that cause sea levels to rise.',
 'Personification of the sea, battled Groudon to expand seas.',
 'Cave of Origin/Marine Cave',
 'Weather Trio', 'Drizzle', 'Origin Pulse', 4.5, 352.0, 0, 'Sapphire, Emerald, HGSS, AlphaSapphire'),

('Groudon', 383, 'Ground', NULL, 'Legendary', 3, 'Hoenn',
 100, 150, 140, 100, 90, 90, 670,
 NULL, NULL, NULL, NULL, 1,
 'Can expand continents through its power.',
 'Personification of land, battled Kyogre to expand continents.',
 'Cave of Origin/Terra Cave',
 'Weather Trio', 'Drought', 'Precipice Blades', 3.5, 950.0, 0, 'Ruby, Emerald, HGSS, OmegaRuby'),

('Rayquaza', 384, 'Dragon', 'Flying', 'Legendary', 3, 'Hoenn',
 105, 150, 90, 150, 90, 95, 680,
 NULL, NULL, NULL, NULL, 1,
 'Flies through ozone layer, consuming meteoroids.',
 'Lives in ozone layer, descends to stop Kyogre and Groudon.',
 'Sky Pillar after crisis',
 'Weather Trio', 'Air Lock', 'Dragon Ascent', 7.0, 206.5, 0, 'RSE, HGSS, ORAS'),

('Jirachi', 385, 'Steel', 'Psychic', 'Mythical', 3, 'Hoenn',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 0,
 'Jirachi will make true any wish written on its head tags.',
 'Awakens once every thousand years for seven days to grant wishes.',
 'Event-exclusive only',
 NULL, 'Serene Grace', 'Doom Desire', 0.3, 1.1, 1, 'Events, Colosseum Bonus'),

('Deoxys', 386, 'Psychic', NULL, 'Mythical', 3, 'Hoenn',
 50, 150, 50, 150, 50, 150, 600,
 NULL, NULL, NULL, NULL, 1,
 'DNA of space virus mutated after laser beam exposure.',
 'Alien virus that can change forms to boost different stats.',
 'Birth Island, Delta Episode',
 NULL, 'Pressure', 'Psycho Boost', 1.7, 60.8, 1, 'Events, FRLG, ORAS');

-- ============================================
-- GENERATION 4 - SINNOH (14 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Uxie', 480, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh',
 75, 75, 130, 75, 130, 95, 580,
 NULL, NULL, NULL, NULL, 0,
 'Known as the Being of Knowledge. Can wipe memories with a glare.',
 'Known as the Being of Knowledge, one of the lake guardians.',
 'Lake Acuity after story',
 'Lake Guardians', 'Levitate', 'Confusion', 0.3, 0.3, 0, 'DPPt, BDSP'),

('Mesprit', 481, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh',
 80, 105, 105, 105, 105, 80, 580,
 NULL, NULL, NULL, NULL, 0,
 'Known as the Being of Emotion. Taught humans joy and sorrow.',
 'Known as the Being of Emotion, one of the lake guardians.',
 'Lake Verity, then roaming',
 'Lake Guardians', 'Levitate', 'Confusion', 0.3, 0.3, 0, 'DPPt, BDSP'),

('Azelf', 482, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh',
 75, 125, 70, 125, 70, 115, 580,
 NULL, NULL, NULL, NULL, 0,
 'Known as the Being of Willpower. Sleeps at bottom of a lake.',
 'Known as the Being of Willpower, one of the lake guardians.',
 'Lake Valor after story',
 'Lake Guardians', 'Levitate', 'Confusion', 0.3, 0.3, 0, 'DPPt, BDSP'),

('Dialga', 483, 'Steel', 'Dragon', 'Legendary', 4, 'Sinnoh',
 100, 120, 120, 150, 100, 90, 680,
 NULL, NULL, NULL, NULL, 1,
 'It has the power to control time. Appears in Sinnoh myths.',
 'Has power to control time, created when universe was born.',
 'Spear Pillar after story',
 'Creation Trio', 'Pressure, Telepathy', 'Roar of Time', 5.4, 683.0, 0, 'Diamond, Platinum, BDSP, PLA'),

('Palkia', 484, 'Water', 'Dragon', 'Legendary', 4, 'Sinnoh',
 90, 120, 100, 150, 120, 100, 680,
 NULL, NULL, NULL, NULL, 1,
 'It has the ability to distort space. Appears in Sinnoh myths.',
 'Has power to distort space, created when universe was born.',
 'Spear Pillar after story',
 'Creation Trio', 'Pressure, Telepathy', 'Spacial Rend', 4.2, 336.0, 0, 'Pearl, Platinum, BDSP, PLA'),

('Heatran', 485, 'Fire', 'Steel', 'Legendary', 4, 'Sinnoh',
 91, 90, 106, 130, 106, 77, 600,
 NULL, NULL, NULL, NULL, 0,
 'Dwells in volcanic caves. Its blood boils at 10,000 degrees.',
 'Dwells in volcanic caves with blood that boils at extreme heat.',
 'Stark Mountain after story',
 NULL, 'Flash Fire, Flame Body', 'Magma Storm', 1.7, 430.0, 0, 'DPPt, HGSS, B2W2, ORAS, BDSP'),

('Regigigas', 486, 'Normal', NULL, 'Legendary', 4, 'Sinnoh',
 110, 160, 110, 80, 110, 100, 670,
 NULL, NULL, NULL, NULL, 0,
 'There is an enduring legend that states this Pokemon towed continents.',
 'Master of the legendary titans, towed continents with ropes.',
 'Snowpoint Temple with all Regis',
 'Legendary Titans', 'Slow Start', 'Crush Grip', 3.7, 420.0, 0, 'DPPt, B2W2, ORAS, BDSP'),

('Giratina', 487, 'Ghost', 'Dragon', 'Legendary', 4, 'Sinnoh',
 150, 100, 120, 100, 120, 90, 680,
 NULL, NULL, NULL, NULL, 1,
 'It was banished for its violence. It silently gazed from the Distortion World.',
 'Banished to Distortion World for violence, can travel between worlds.',
 'Distortion World/Turnback Cave',
 'Creation Trio', 'Pressure, Telepathy', 'Shadow Force', 4.5, 650.0, 0, 'Platinum, HGSS, B2W2, ORAS, BDSP, PLA'),

('Cresselia', 488, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh',
 120, 70, 120, 75, 130, 85, 600,
 NULL, NULL, NULL, NULL, 0,
 'Shining particles from its wings bring happy dreams.',
 'Represents the crescent moon and brings pleasant dreams.',
 'Fullmoon Island, then roaming',
 NULL, 'Levitate', 'Psycho Cut', 1.5, 85.6, 0, 'DPPt, BW, B2W2, ORAS, BDSP'),

('Phione', 489, 'Water', NULL, 'Mythical', 4, 'Sinnoh',
 80, 80, 80, 80, 80, 80, 480,
 NULL, NULL, NULL, NULL, 0,
 'A Pokemon that lives in warm seas. Drifts ashore on icebergs.',
 'Born from Manaphy, drifts through warm ocean waters.',
 'Breed Manaphy with Ditto',
 NULL, 'Hydration', 'Water Pulse', 0.4, 3.1, 0, 'DPPt (breeding), BDSP'),

('Manaphy', 490, 'Water', NULL, 'Mythical', 4, 'Sinnoh',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 0,
 'Born on a cold seafloor, it will swim great distances to return.',
 'Prince of the Sea, born on cold seafloor, can swap hearts.',
 'Event-exclusive, Pokemon Ranger',
 NULL, 'Hydration', 'Heart Swap', 0.3, 1.4, 1, 'Events, Pokemon Ranger'),

('Darkrai', 491, 'Dark', NULL, 'Mythical', 4, 'Sinnoh',
 70, 90, 90, 135, 90, 125, 600,
 NULL, NULL, NULL, NULL, 0,
 'It chases people and Pokemon away with nightmares.',
 'Represents the new moon and causes nightmares.',
 'Newmoon Island with event item',
 NULL, 'Bad Dreams', 'Dark Void', 1.5, 50.5, 1, 'Events, Platinum, BDSP'),

('Shaymin', 492, 'Grass', NULL, 'Mythical', 4, 'Sinnoh',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 1,
 'The flowers all over its body burst into bloom if it is healthy.',
 'Gratitude Pokemon that can purify polluted land with flowers.',
 'Event-exclusive, Flower Paradise',
 NULL, 'Natural Cure, Serene Grace', 'Seed Flare', 0.2, 2.1, 1, 'Events, Platinum, BDSP'),

('Arceus', 493, 'Normal', NULL, 'Mythical', 4, 'Sinnoh',
 120, 120, 120, 120, 120, 120, 720,
 NULL, NULL, NULL, NULL, 1,
 'According to legend, it shaped the universe with its 1,000 arms.',
 'The Original One that shaped the universe with 1,000 arms.',
 'Event-exclusive, Hall of Origin',
 NULL, 'Multitype', 'Judgment', 3.2, 320.0, 1, 'Events, BDSP, PLA');

-- ============================================
-- GENERATION 5 - UNOVA (13 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Victini', 494, 'Psychic', 'Fire', 'Mythical', 5, 'Unova',
 100, 100, 100, 100, 100, 100, 600,
 NULL, NULL, NULL, NULL, 0,
 'This Pokemon brings victory. It shares its infinite energy with those who touch it.',
 'Victory Pokemon that generates unlimited energy and brings victory.',
 'Liberty Garden with event item',
 NULL, 'Victory Star', 'V-create', 0.4, 4.0, 1, 'BW with event item'),

('Cobalion', 638, 'Steel', 'Fighting', 'Legendary', 5, 'Unova',
 91, 90, 129, 90, 72, 108, 580,
 NULL, NULL, NULL, NULL, 0,
 'It has a body and heart of steel. It intimidated Pokemon with its glare.',
 'Leader of Swords of Justice, protected Pokemon during war.',
 'Mistralton Cave',
 'Swords of Justice', 'Justified', 'Sacred Sword', 2.1, 250.0, 0, 'BW, B2W2, ORAS, SwSh Crown'),

('Terrakion', 639, 'Rock', 'Fighting', 'Legendary', 5, 'Unova',
 91, 129, 90, 72, 90, 108, 580,
 NULL, NULL, NULL, NULL, 0,
 'Its charge is strong enough to break through a giant castle wall.',
 'Member of Swords of Justice, can smash castle walls.',
 'Victory Road',
 'Swords of Justice', 'Justified', 'Sacred Sword', 1.9, 260.0, 0, 'BW, B2W2, ORAS, SwSh Crown'),

('Virizion', 640, 'Grass', 'Fighting', 'Legendary', 5, 'Unova',
 91, 90, 72, 90, 129, 108, 580,
 NULL, NULL, NULL, NULL, 0,
 'Legends say this Pokemon confounded opponents with swift movements.',
 'Member of Swords of Justice, swift and graceful fighter.',
 'Pinwheel Forest',
 'Swords of Justice', 'Justified', 'Sacred Sword', 2.0, 200.0, 0, 'BW, B2W2, ORAS, SwSh Crown'),

('Tornadus', 641, 'Flying', NULL, 'Legendary', 5, 'Unova',
 79, 115, 70, 125, 80, 111, 580,
 NULL, NULL, NULL, NULL, 1,
 'The lower half of its body is wrapped in a cloud. It flies at 200 mph.',
 'Forces of Nature member, creates terrible windstorms.',
 'Roaming Unova in BW',
 'Forces of Nature', 'Prankster, Defiant', 'Hurricane', 1.5, 63.0, 0, 'White, B2W2, ORAS, SwSh Crown'),

('Thundurus', 642, 'Electric', 'Flying', 'Legendary', 5, 'Unova',
 79, 115, 70, 125, 80, 111, 580,
 NULL, NULL, NULL, NULL, 1,
 'The spikes on its tail discharge immense bolts of lightning.',
 'Forces of Nature member, shoots lightning from its tail.',
 'Roaming Unova in BW',
 'Forces of Nature', 'Prankster, Defiant', 'Thunder', 1.5, 61.0, 0, 'Black, B2W2, ORAS, SwSh Crown'),

('Reshiram', 643, 'Dragon', 'Fire', 'Legendary', 5, 'Unova',
 100, 120, 100, 150, 120, 90, 680,
 NULL, NULL, NULL, NULL, 0,
 'This Pokemon appears in legends. It sends flames into the air from its tail.',
 'Represents truth and ideals, legendary dragon of Unova.',
 'N\'s Castle in Black/White',
 'Tao Trio', 'Turboblaze', 'Blue Flare', 3.2, 330.0, 0, 'Black, B2W2, USUM, SwSh Crown'),

('Zekrom', 644, 'Dragon', 'Electric', 'Legendary', 5, 'Unova',
 100, 150, 120, 120, 100, 90, 680,
 NULL, NULL, NULL, NULL, 0,
 'Concealing itself in lightning clouds, it flies throughout Unova.',
 'Represents ideals and truth, legendary dragon of Unova.',
 'N\'s Castle in Black/White',
 'Tao Trio', 'Teravolt', 'Bolt Strike', 2.9, 345.0, 0, 'White, B2W2, USUM, SwSh Crown'),

('Landorus', 645, 'Ground', 'Flying', 'Legendary', 5, 'Unova',
 89, 125, 90, 115, 80, 101, 600,
 NULL, NULL, NULL, NULL, 1,
 'The energy from its tail makes the land fertile.',
 'Forces of Nature leader, brings fertility to the land.',
 'Abundant Shrine with Tornadus and Thundurus',
 'Forces of Nature', 'Sand Force, Intimidate', 'Earth Power', 1.5, 68.0, 0, 'BW, B2W2, ORAS, SwSh Crown'),

('Kyurem', 646, 'Dragon', 'Ice', 'Legendary', 5, 'Unova',
 125, 130, 90, 130, 90, 95, 660,
 NULL, NULL, NULL, NULL, 1,
 'It generates powerful freezing energy but leaks it from its body.',
 'Empty shell left behind when Reshiram and Zekrom split.',
 'Giant Chasm',
 'Tao Trio', 'Pressure', 'Glaciate', 3.0, 325.0, 0, 'BW, B2W2, USUM, SwSh Crown'),

('Keldeo', 647, 'Water', 'Fighting', 'Mythical', 5, 'Unova',
 91, 72, 90, 129, 90, 108, 580,
 NULL, NULL, NULL, NULL, 1,
 'By blasting water from its hooves, it can glide across water.',
 'Student of Swords of Justice, youngest member of the group.',
 'Event-exclusive',
 'Swords of Justice', 'Justified', 'Secret Sword', 1.4, 48.5, 1, 'Events, B2W2, ORAS, SwSh Crown'),

('Meloetta', 648, 'Normal', 'Psychic', 'Mythical', 5, 'Unova',
 100, 77, 77, 128, 128, 90, 600,
 NULL, NULL, NULL, NULL, 1,
 'The melodies sung by Meloetta have the power to make Pokemon cry or laugh.',
 'Melody Pokemon whose songs can control emotions.',
 'Event-exclusive',
 NULL, 'Serene Grace', 'Relic Song', 0.6, 6.5, 1, 'Events, B2W2'),

('Genesect', 649, 'Bug', 'Steel', 'Mythical', 5, 'Unova',
 71, 120, 95, 120, 95, 99, 600,
 NULL, NULL, NULL, NULL, 1,
 'Over 300 million years ago, it was modified by Team Plasma.',
 'Ancient bug modified by Team Plasma with a cannon on its back.',
 'Event-exclusive',
 NULL, 'Download', 'Techno Blast', 1.5, 82.5, 1, 'Events, B2W2');

-- ============================================
-- GENERATION 6 - KALOS (6 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Xerneas', 716, 'Fairy', NULL, 'Legendary', 6, 'Kalos',
 126, 131, 95, 131, 98, 99, 680,
 NULL, NULL, NULL, NULL, 1,
 'Legends say it can share eternal life. It slept for a thousand years.',
 'Life Pokemon that shares eternal life and awakened from 1000 year sleep.',
 'Team Flare HQ in X',
 'Aura Trio', 'Fairy Aura', 'Geomancy', 3.0, 215.0, 0, 'X, USUM'),

('Yveltal', 717, 'Dark', 'Flying', 'Legendary', 6, 'Kalos',
 126, 131, 95, 131, 98, 99, 680,
 NULL, NULL, NULL, NULL, 0,
 'When life comes to an end, this Pokemon absorbs the life energy.',
 'Destruction Pokemon that absorbs life energy when it awakens.',
 'Team Flare HQ in Y',
 'Aura Trio', 'Dark Aura', 'Oblivion Wing', 5.8, 203.0, 0, 'Y, USUM'),

('Zygarde', 718, 'Dragon', 'Ground', 'Legendary', 6, 'Kalos',
 108, 100, 121, 81, 95, 95, 600,
 NULL, NULL, NULL, NULL, 1,
 'It monitors the ecosystem of the Kalos region. It protects the environment.',
 'Order Pokemon that maintains ecosystem balance with its cells.',
 'Terminus Cave, Route 10',
 'Aura Trio', 'Aura Break, Power Construct', 'Thousand Arrows', 5.0, 305.0, 0, 'XY, SM, USUM'),

('Diancie', 719, 'Rock', 'Fairy', 'Mythical', 6, 'Kalos',
 50, 100, 150, 100, 150, 50, 600,
 NULL, NULL, NULL, NULL, 1,
 'A sudden transformation of Carbink, its pink body glitters.',
 'Jewel Pokemon born from mutation of Carbink, creates diamonds.',
 'Event-exclusive',
 NULL, 'Clear Body', 'Diamond Storm', 0.7, 8.8, 1, 'Events, ORAS'),

('Hoopa', 720, 'Psychic', 'Ghost', 'Mythical', 6, 'Kalos',
 80, 110, 60, 150, 130, 70, 600,
 NULL, NULL, NULL, NULL, 1,
 'It gathers things it likes and stores them in its rings.',
 'Mischief Pokemon that can summon things through its rings.',
 'Event-exclusive',
 NULL, 'Magician', 'Hyperspace Hole', 0.5, 9.0, 1, 'Events, ORAS'),

('Volcanion', 721, 'Fire', 'Water', 'Mythical', 6, 'Kalos',
 80, 110, 120, 130, 90, 70, 600,
 NULL, NULL, NULL, NULL, 0,
 'It expels its internal steam from the arms on its back.',
 'Steam Pokemon with unique Fire/Water typing, expels steam.',
 'Event-exclusive',
 NULL, 'Water Absorb', 'Steam Eruption', 1.7, 195.0, 1, 'Events');

-- ============================================
-- GENERATION 7 - ALOLA (11 Main + 11 Ultra Beasts)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Type: Null', 772, 'Normal', NULL, 'Legendary', 7, 'Alola',
 95, 95, 95, 95, 95, 59, 534,
 NULL, NULL, NULL, NULL, 0,
 'A Pokemon made through genetic modification to be the ultimate weapon.',
 'Synthetic Pokemon created to fight Ultra Beasts, evolves into Silvally.',
 'Given by Gladion',
 NULL, 'Battle Armor', 'Tri Attack', 1.9, 120.5, 0, 'SM, USUM, SwSh'),

('Silvally', 773, 'Normal', NULL, 'Legendary', 7, 'Alola',
 95, 95, 95, 95, 95, 95, 570,
 NULL, NULL, NULL, NULL, 1,
 'It destroyed its own control mask to save its partner.',
 'Evolution of Type: Null that broke free, can change type with memories.',
 'Evolve Type: Null with high friendship',
 NULL, 'RKS System', 'Multi-Attack', 2.3, 100.5, 0, 'SM, USUM, SwSh'),

('Tapu Koko', 785, 'Electric', 'Fairy', 'Legendary', 7, 'Alola',
 70, 115, 85, 95, 75, 130, 570,
 NULL, NULL, NULL, NULL, 0,
 'The lightning-wielding guardian deity of Melemele Island.',
 'Guardian deity of Melemele Island, protects the island.',
 'Ruins of Conflict post-game',
 'Guardian Deities', 'Electric Surge, Telepathy', 'Nature\'s Madness', 1.8, 20.5, 0, 'SM, USUM, SwSh Crown'),

('Tapu Lele', 786, 'Psychic', 'Fairy', 'Legendary', 7, 'Alola',
 70, 85, 75, 130, 115, 95, 570,
 NULL, NULL, NULL, NULL, 0,
 'The guardian deity of Akala Island, it heals its own wounds.',
 'Guardian deity of Akala Island, heals and harms with scales.',
 'Ruins of Life post-game',
 'Guardian Deities', 'Psychic Surge, Telepathy', 'Nature\'s Madness', 1.2, 18.6, 0, 'SM, USUM, SwSh Crown'),

('Tapu Bulu', 787, 'Grass', 'Fairy', 'Legendary', 7, 'Alola',
 70, 130, 115, 85, 95, 75, 570,
 NULL, NULL, NULL, NULL, 0,
 'The guardian deity of Ula\'ula Island, it has incredible physical strength.',
 'Guardian deity of Ula\'ula Island with immense strength.',
 'Ruins of Abundance post-game',
 'Guardian Deities', 'Grassy Surge, Telepathy', 'Nature\'s Madness', 1.9, 45.5, 0, 'SM, USUM, SwSh Crown'),

('Tapu Fini', 788, 'Water', 'Fairy', 'Legendary', 7, 'Alola',
 70, 75, 115, 95, 130, 85, 570,
 NULL, NULL, NULL, NULL, 0,
 'The guardian deity of Poni Island, it creates a mystical mist.',
 'Guardian deity of Poni Island that creates purifying fog.',
 'Ruins of Hope post-game',
 'Guardian Deities', 'Misty Surge, Telepathy', 'Nature\'s Madness', 1.3, 21.2, 0, 'SM, USUM, SwSh Crown'),

('Cosmog', 789, 'Psychic', NULL, 'Legendary', 7, 'Alola',
 43, 29, 31, 29, 31, 37, 200,
 NULL, NULL, NULL, NULL, 0,
 'Its body is gaseous and can produce any substance it wants.',
 'Nebula Pokemon that is very curious and fragile.',
 'Story event with Lillie',
 'Cosmog Line', 'Unaware', 'Splash', 0.2, 0.1, 0, 'SM, USUM'),

('Cosmoem', 790, 'Psychic', NULL, 'Legendary', 7, 'Alola',
 43, 29, 131, 29, 131, 37, 400,
 NULL, NULL, NULL, NULL, 0,
 'The king who ruled Alola in times of old called it the cocoon of the stars.',
 'Protostar Pokemon that is hardening into its final form.',
 'Evolve Cosmog at level 43',
 'Cosmog Line', 'Sturdy', 'Cosmic Power', 0.1, 999.9, 0, 'SM, USUM'),

('Solgaleo', 791, 'Psychic', 'Steel', 'Legendary', 7, 'Alola',
 137, 137, 107, 113, 89, 97, 680,
 NULL, NULL, NULL, NULL, 0,
 'Said to live in another world, this Pokemon devours light.',
 'Legendary Pokemon of the sun that opens Ultra Wormholes.',
 'Evolve Cosmoem in Sun/Ultra Sun',
 'Cosmog Line', 'Full Metal Body', 'Sunsteel Strike', 3.4, 230.0, 0, 'Sun, Ultra Sun, SwSh Crown'),

('Lunala', 792, 'Psychic', 'Ghost', 'Legendary', 7, 'Alola',
 137, 113, 89, 137, 107, 97, 680,
 NULL, NULL, NULL, NULL, 0,
 'Known as the Beast that Calls the Moon, it absorbs light.',
 'Legendary Pokemon of the moon that opens Ultra Wormholes.',
 'Evolve Cosmoem in Moon/Ultra Moon',
 'Cosmog Line', 'Shadow Shield', 'Moongeist Beam', 4.0, 120.0, 0, 'Moon, Ultra Moon, SwSh Crown'),

('Necrozma', 800, 'Psychic', NULL, 'Legendary', 7, 'Alola',
 97, 107, 101, 127, 89, 79, 600,
 NULL, NULL, NULL, NULL, 1,
 'Reminiscent of the Ultra Beasts, this life-form seeks light to survive.',
 'Prism Pokemon that absorbs light, can fuse with Solgaleo/Lunala.',
 'Ten Carat Hill post-game',
 'Light Trio', 'Prism Armor, Neuroforce', 'Photon Geyser', 2.4, 230.0, 0, 'USUM, SwSh Crown');

-- Ultra Beasts (Generation 7)
INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Nihilego', 793, 'Rock', 'Poison', 'Ultra Beast', 7, 'Alola',
 109, 53, 47, 127, 131, 103, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It appeared from an Ultra Wormhole.',
 'Ultra Beast that resembles a jellyfish and possesses hosts.',
 'Wela Volcano Park in USUM',
 'Ultra Beasts', 'Beast Boost', 'Power Gem', 1.2, 55.5, 0, 'SM, USUM, SwSh Crown'),

('Buzzwole', 794, 'Bug', 'Fighting', 'Ultra Beast', 7, 'Alola',
 107, 139, 139, 53, 53, 79, 570,
 NULL, NULL, NULL, NULL, 0,
 'This Ultra Beast appeared from another world. It shows off its body.',
 'Ultra Beast with massive muscles that shows off its strength.',
 'Melemele Meadow in US',
 'Ultra Beasts', 'Beast Boost', 'Leech Life', 2.4, 333.6, 0, 'Sun, Ultra Sun, SwSh Crown'),

('Pheromosa', 795, 'Bug', 'Fighting', 'Ultra Beast', 7, 'Alola',
 71, 137, 37, 137, 37, 151, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It refuses to touch anything dirty.',
 'Ultra Beast with incredible speed and beauty that avoids dirt.',
 'Verdant Cavern in UM',
 'Ultra Beasts', 'Beast Boost', 'Bug Buzz', 1.8, 25.0, 0, 'Moon, Ultra Moon, SwSh Crown'),

('Xurkitree', 796, 'Electric', NULL, 'Ultra Beast', 7, 'Alola',
 83, 89, 71, 173, 71, 83, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It absorbs electricity and causes blackouts.',
 'Ultra Beast that resembles electric wires and absorbs electricity.',
 'Lush Jungle/Memorial Hill in USUM',
 'Ultra Beasts', 'Beast Boost', 'Thunderbolt', 3.8, 100.0, 0, 'SM, USUM, SwSh Crown'),

('Celesteela', 797, 'Steel', 'Flying', 'Ultra Beast', 7, 'Alola',
 97, 101, 103, 107, 101, 61, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It fires gas and debris to propel itself.',
 'Ultra Beast that resembles a bamboo rocket, extremely heavy.',
 'Malie Garden/Haina Desert in UM',
 'Ultra Beasts', 'Beast Boost', 'Heavy Slam', 9.2, 999.9, 0, 'Moon, Ultra Moon, SwSh Crown'),

('Kartana', 798, 'Grass', 'Steel', 'Ultra Beast', 7, 'Alola',
 59, 181, 131, 59, 31, 109, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It slices things with its sharp body.',
 'Ultra Beast made of paper that can cut through anything.',
 'Malie Garden/Route 17 in US',
 'Ultra Beasts', 'Beast Boost', 'Leaf Blade', 0.3, 0.1, 0, 'Sun, Ultra Sun, SwSh Crown'),

('Guzzlord', 799, 'Dark', 'Dragon', 'Ultra Beast', 7, 'Alola',
 223, 101, 53, 97, 53, 43, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It consumes everything endlessly.',
 'Ultra Beast with massive appetite that devours everything.',
 'Resolution Cave in USUM',
 'Ultra Beasts', 'Beast Boost', 'Stomping Tantrum', 5.5, 888.0, 0, 'SM, USUM, SwSh Crown'),

('Poipole', 803, 'Poison', NULL, 'Ultra Beast', 7, 'Alola',
 67, 73, 67, 73, 67, 73, 420,
 NULL, NULL, NULL, NULL, 0,
 'An Ultra Beast that lives in a different world. It clings to others.',
 'Ultra Beast that is very affectionate and sprays poison.',
 'Given by Ultra Recon Squad',
 'Ultra Beasts', 'Beast Boost', 'Poison Jab', 0.6, 1.8, 0, 'USUM, SwSh Crown'),

('Naganadel', 804, 'Poison', 'Dragon', 'Ultra Beast', 7, 'Alola',
 73, 73, 73, 127, 73, 121, 540,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It fires poisonous needles at high speed.',
 'Evolution of Poipole that fires poisonous stingers.',
 'Evolve Poipole with Dragon Pulse',
 'Ultra Beasts', 'Beast Boost', 'Dragon Pulse', 3.6, 150.0, 0, 'USUM, SwSh Crown'),

('Stakataka', 805, 'Rock', 'Steel', 'Ultra Beast', 7, 'Alola',
 61, 131, 211, 53, 101, 13, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It was found collapsed like a stone wall.',
 'Ultra Beast made of many life-forms stacked together.',
 'Poni Grove in US',
 'Ultra Beasts', 'Beast Boost', 'Rock Slide', 5.5, 820.0, 0, 'Ultra Sun, SwSh Crown'),

('Blacephalon', 806, 'Fire', 'Ghost', 'Ultra Beast', 7, 'Alola',
 53, 127, 53, 151, 79, 107, 570,
 NULL, NULL, NULL, NULL, 0,
 'One of the Ultra Beasts. It steals vitality by making heads explode.',
 'Ultra Beast that makes its own head explode as an attack.',
 'Poni Grove in UM',
 'Ultra Beasts', 'Beast Boost', 'Mind Blown', 1.8, 13.0, 0, 'Ultra Moon, SwSh Crown');

-- Mythicals (Generation 7)
INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Magearna', 801, 'Steel', 'Fairy', 'Mythical', 7, 'Alola',
 80, 95, 115, 130, 115, 65, 600,
 NULL, NULL, NULL, NULL, 1,
 'Built about 500 years ago, it can sense emotions.',
 'Artificial Pokemon built 500 years ago as a gift for a princess.',
 'QR code event',
 NULL, 'Soul-Heart', 'Fleur Cannon', 1.0, 80.5, 1, 'SM Event, USUM'),

('Marshadow', 802, 'Fighting', 'Ghost', 'Mythical', 7, 'Alola',
 90, 125, 80, 90, 90, 125, 600,
 NULL, NULL, NULL, NULL, 0,
 'It sinks into shadows of people and Pokemon, imitating their moves.',
 'Gloomdweller Pokemon that hides in shadows and mimics techniques.',
 'Event-exclusive',
 NULL, 'Technician', 'Spectral Thief', 0.7, 22.2, 1, 'Events'),

('Zeraora', 807, 'Electric', NULL, 'Mythical', 7, 'Alola',
 88, 112, 75, 102, 80, 143, 600,
 NULL, NULL, NULL, NULL, 0,
 'It electrifies its claws and tears opponents apart.',
 'Thunderclap Pokemon with incredible speed and electric claws.',
 'Event-exclusive',
 NULL, 'Volt Absorb', 'Plasma Fists', 1.5, 44.5, 1, 'Events, USUM'),

('Meltan', 808, 'Steel', NULL, 'Mythical', 7, 'Alola',
 46, 65, 65, 55, 35, 34, 300,
 NULL, NULL, NULL, NULL, 0,
 'It melts particles of iron and absorbs them into its body.',
 'Hex Nut Pokemon made of liquid metal that eats iron.',
 'Pokemon GO transfer to Let\'s Go',
 NULL, 'Magnet Pull', 'Flash Cannon', 0.2, 8.0, 0, 'Pokemon GO, LGPE'),

('Melmetal', 809, 'Steel', NULL, 'Mythical', 7, 'Alola',
 135, 143, 143, 80, 65, 34, 600,
 NULL, NULL, NULL, NULL, 1,
 'Centrifugal force is behind its punches, which are strong enough to shatter mountains.',
 'Evolution of Meltan with incredibly powerful metal fists.',
 'Evolve Meltan in Pokemon GO',
 NULL, 'Iron Fist', 'Double Iron Bash', 2.5, 800.0, 0, 'Pokemon GO, LGPE, HOME');

-- ============================================
-- GENERATION 8 - GALAR (12 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Zacian', 888, 'Fairy', NULL, 'Legendary', 8, 'Galar',
 92, 130, 115, 80, 115, 138, 670,
 NULL, NULL, NULL, NULL, 1,
 'Known as a legendary hero, this Pokemon absorbs metal to power up.',
 'Hero Pokemon that saved Galar with its sword in ancient times.',
 'Slumbering Weald post-game',
 'Hero Duo', 'Intrepid Sword', 'Behemoth Blade', 2.8, 110.0, 0, 'Sword, SwSh Crown'),

('Zamazenta', 889, 'Fighting', NULL, 'Legendary', 8, 'Galar',
 92, 130, 115, 80, 115, 138, 670,
 NULL, NULL, NULL, NULL, 1,
 'Its ability to deflect any attack led to it being known as the Fighting Master\'s Shield.',
 'Hero Pokemon that saved Galar with its shield in ancient times.',
 'Slumbering Weald post-game',
 'Hero Duo', 'Dauntless Shield', 'Behemoth Bash', 2.9, 210.0, 0, 'Shield, SwSh Crown'),

('Eternatus', 890, 'Poison', 'Dragon', 'Legendary', 8, 'Galar',
 140, 85, 95, 145, 95, 130, 690,
 NULL, NULL, NULL, NULL, 1,
 'The core on its chest absorbs energy from the lands of the Galar region.',
 'Gigantic Pokemon that crashed to Galar 20,000 years ago.',
 'Energy Plant during story',
 NULL, 'Pressure', 'Dynamax Cannon', 20.0, 950.0, 0, 'SwSh'),

('Kubfu', 891, 'Fighting', NULL, 'Legendary', 8, 'Galar',
 60, 90, 60, 53, 50, 72, 385,
 NULL, NULL, NULL, NULL, 0,
 'It lived on a remote island. Training diligently made it strong.',
 'Wushu Pokemon that trains constantly to become stronger.',
 'Isle of Armor gift from Mustard',
 NULL, 'Inner Focus', 'Rock Smash', 0.6, 12.0, 0, 'SwSh IoA'),

('Urshifu Single Strike', 892, 'Fighting', 'Dark', 'Legendary', 8, 'Galar',
 100, 130, 100, 63, 60, 97, 550,
 NULL, NULL, NULL, NULL, 1,
 'This form is the result of training in the Tower of Darkness.',
 'Evolved from Kubfu by mastering Single Strike Style.',
 'Evolve Kubfu at Tower of Darkness',
 NULL, 'Unseen Fist', 'Wicked Blow', 1.9, 105.0, 0, 'SwSh IoA'),

('Urshifu Rapid Strike', 892, 'Fighting', 'Water', 'Legendary', 8, 'Galar',
 100, 130, 100, 63, 60, 97, 550,
 NULL, NULL, NULL, NULL, 1,
 'This form is the result of training in the Tower of Waters.',
 'Evolved from Kubfu by mastering Rapid Strike Style.',
 'Evolve Kubfu at Tower of Waters',
 NULL, 'Unseen Fist', 'Surging Strikes', 1.9, 105.0, 0, 'SwSh IoA'),

('Zarude', 893, 'Dark', 'Grass', 'Mythical', 8, 'Galar',
 105, 120, 105, 70, 95, 105, 600,
 NULL, NULL, NULL, NULL, 1,
 'Within dense forests, this Pokemon lives in a pack with others.',
 'Rogue Monkey Pokemon that swings through forests with vines.',
 'Event-exclusive',
 NULL, 'Leaf Guard', 'Jungle Healing', 1.8, 70.0, 1, 'Events, SwSh'),

('Regieleki', 894, 'Electric', NULL, 'Legendary', 8, 'Galar',
 80, 100, 50, 100, 50, 200, 580,
 NULL, NULL, NULL, NULL, 0,
 'This Pokemon is a cluster of electrical energy. It\'s said it was born from lightning.',
 'Member of Legendary Titans, made of pure electricity, fastest Regi.',
 'Split-Decision Ruins in Crown Tundra',
 'Legendary Titans', 'Transistor', 'Thunder Cage', 1.2, 145.0, 0, 'SwSh Crown'),

('Regidrago', 895, 'Dragon', NULL, 'Legendary', 8, 'Galar',
 200, 100, 50, 100, 50, 80, 580,
 NULL, NULL, NULL, NULL, 0,
 'Created from crystallized dragon energy, it has more power than any other Regi.',
 'Member of Legendary Titans, incomplete dragon made of dragon energy.',
 'Split-Decision Ruins in Crown Tundra',
 'Legendary Titans', 'Dragon\'s Maw', 'Dragon Energy', 2.1, 200.0, 0, 'SwSh Crown'),

('Glastrier', 896, 'Ice', NULL, 'Legendary', 8, 'Galar',
 100, 145, 130, 65, 110, 30, 580,
 NULL, NULL, NULL, NULL, 0,
 'Glastrier emits intense cold. It has incredible physical strength.',
 'Wild Horse Pokemon made of ice with immense strength.',
 'Crown Tundra story choice',
 'Steeds of Calyrex', 'Chilling Neigh', 'Glacial Lance', 2.2, 800.0, 0, 'SwSh Crown'),

('Spectrier', 897, 'Ghost', NULL, 'Legendary', 8, 'Galar',
 100, 65, 60, 145, 80, 130, 580,
 NULL, NULL, NULL, NULL, 0,
 'It probes its surroundings with its frail body made of a soul.',
 'Swift Horse Pokemon made of ghostly energy with incredible speed.',
 'Crown Tundra story choice',
 'Steeds of Calyrex', 'Grim Neigh', 'Astral Barrage', 2.0, 44.5, 0, 'SwSh Crown'),

('Calyrex', 898, 'Psychic', 'Grass', 'Legendary', 8, 'Galar',
 100, 80, 80, 80, 80, 80, 500,
 NULL, NULL, NULL, NULL, 1,
 'Calyrex is a merciful Pokemon, known to heal the wounds of Pokemon and humans.',
 'King of Bountiful Harvests that ruled ancient Galar.',
 'Crown Tundra story',
 'Calyrex Forms', 'Unnerve, As One', 'Psychic', 1.1, 7.7, 0, 'SwSh Crown');

-- ============================================
-- GENERATION 9 - PALDEA (7 Pokemon)
-- ============================================

INSERT INTO pokemon (
  name, pokedex_number, type1, type2, classification, generation, region,
  hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
  regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
  description, lore_story, how_to_obtain,
  legendary_group, abilities, signature_move, height_m, weight_kg, is_event_exclusive, games_available
) VALUES 
('Wo-Chien', 1001, 'Dark', 'Grass', 'Legendary', 9, 'Paldea',
 85, 85, 100, 95, 135, 70, 570,
 NULL, NULL, NULL, NULL, 0,
 'The grudge of a person punished for writing the king\'s evil deeds became this Pokemon.',
 'Ruinous Pokemon formed from grudge-filled wooden tablets.',
 'Collect stakes and open shrine',
 'Treasures of Ruin', 'Tablets of Ruin', 'Ruination', 1.5, 74.2, 0, 'SV'),

('Chien-Pao', 1002, 'Dark', 'Ice', 'Legendary', 9, 'Paldea',
 80, 120, 80, 90, 65, 135, 570,
 NULL, NULL, NULL, NULL, 0,
 'This Pokemon can control 100 tons of fallen snow with a wave of its fangs.',
 'Ruinous Pokemon formed from grudge-filled broken sword.',
 'Collect stakes and open shrine',
 'Treasures of Ruin', 'Sword of Ruin', 'Ruination', 1.9, 152.2, 0, 'SV'),

('Ting-Lu', 1003, 'Dark', 'Ground', 'Legendary', 9, 'Paldea',
 155, 110, 125, 55, 80, 45, 570,
 NULL, NULL, NULL, NULL, 0,
 'The fear poured into an ancient ritual vessel awakened it. This Pokemon absorbs fear as energy.',
 'Ruinous Pokemon formed from grudge-filled ancient vessel.',
 'Collect stakes and open shrine',
 'Treasures of Ruin', 'Vessel of Ruin', 'Ruination', 2.7, 699.7, 0, 'SV'),

('Chi-Yu', 1004, 'Dark', 'Fire', 'Legendary', 9, 'Paldea',
 55, 80, 80, 145, 120, 100, 580,
 NULL, NULL, NULL, NULL, 0,
 'The envy accumulated within curved beads awakened this Pokemon.',
 'Ruinous Pokemon formed from grudge-filled beads of envy.',
 'Collect stakes and open shrine',
 'Treasures of Ruin', 'Beads of Ruin', 'Ruination', 0.4, 4.9, 0, 'SV'),

('Koraidon', 1007, 'Fighting', 'Dragon', 'Legendary', 9, 'Paldea',
 100, 135, 115, 85, 100, 135, 670,
 NULL, NULL, NULL, NULL, 1,
 'This seems to be the Winged King mentioned in an old expedition journal.',
 'Paradox Pokemon from ancient past, legendary beast of Paldea.',
 'Story event',
 'Paradox Duo', 'Orichalcum Pulse', 'Collision Course', 2.5, 303.0, 0, 'Scarlet'),

('Miraidon', 1008, 'Electric', 'Dragon', 'Legendary', 9, 'Paldea',
 100, 85, 100, 135, 115, 135, 670,
 NULL, NULL, NULL, NULL, 1,
 'Much remains unknown about this creature. It resembles Cyclizar but is far more savage.',
 'Paradox Pokemon from distant future, legendary beast of Paldea.',
 'Story event',
 'Paradox Duo', 'Hadron Engine', 'Electro Drift', 3.5, 240.0, 0, 'Violet'),

('Terapagos', 1024, 'Normal', NULL, 'Legendary', 9, 'Paldea',
 90, 65, 85, 65, 85, 60, 450,
 NULL, NULL, NULL, NULL, 1,
 'An old expedition journal describes the sight of this Pokemon buried in the depths of the earth.',
 'Legendary Pokemon that is source of Terastallization phenomenon.',
 'Indigo Disk DLC story',
 NULL, 'Tera Shell, Tera Shift', 'Tera Starstorm', 0.3, 6.5, 0, 'SV Indigo Disk'),

('Pecharunt', 1025, 'Poison', 'Ghost', 'Mythical', 9, 'Paldea',
 88, 88, 160, 88, 88, 88, 600,
 NULL, NULL, NULL, NULL, 0,
 'It feeds others toxic mochi that draw out desires and capabilities.',
 'Subjugation Pokemon that controls others with poisonous mochi.',
 'Mochi Mayhem event',
 NULL, 'Poison Puppeteer', 'Malignant Chain', 0.3, 0.3, 1, 'SV Mochi Mayhem');


-- END OF DATABASE - READY FOR USE!

-- Total Pokemon: ~95 Legendary & Mythical Pokemon
-- All images are NULL - add via admin interface
-- Database is ready for CRUD operations