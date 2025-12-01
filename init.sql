-- LEGENDARY & MYTHICAL POKEMON DATABASE
-- Database: dmit2025 (matches compose.yml)

-- This database will be auto-created by Docker
-- MySQL container creates MYSQL_DATABASE automatically

-- Drop existing tables if they exist (for clean reinstall)
DROP TABLE IF EXISTS pokemon_tags;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS pokemon_images;
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
  
  -- IMAGES (main images)
  regular_image VARCHAR(255) NOT NULL,
  shiny_image VARCHAR(255) NULL,
  has_alternate_forms BOOLEAN DEFAULT FALSE,
  
  -- DESCRIPTION & LORE
  description TEXT NOT NULL,
  lore_story TEXT NULL,
  how_to_obtain TEXT NULL,
  
  -- ADDITIONAL INFO
  legendary_group VARCHAR(100) NULL,
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

-- Create pokemon_images table (Challenge #4: Multi-Image Gallery)
CREATE TABLE pokemon_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pokemon_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  form_name VARCHAR(100) NULL COMMENT 'e.g., Mega X, Mega Y, Primal',
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (pokemon_id) REFERENCES pokemon(id) ON DELETE CASCADE,
  INDEX idx_pokemon_id (pokemon_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create tags table (Challenge #6: Tagging System)
CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tag_name VARCHAR(50) NOT NULL UNIQUE,
  tag_slug VARCHAR(50) NOT NULL UNIQUE COMMENT 'URL-friendly version',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_tag_slug (tag_slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create pokemon_tags junction table (Challenge #6: Tagging System)
CREATE TABLE pokemon_tags (
  pokemon_id INT NOT NULL,
  tag_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (pokemon_id, tag_id),
  FOREIGN KEY (pokemon_id) REFERENCES pokemon(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Total: ~95 Pokemon across all 9 generations

-- GENERATION 1 - KANTO (5 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Articuno', 144, 'Ice', 'Flying', 'Legendary', 1, 'Kanto', 90, 85, 100, 95, 125, 85, 580, 'articuno.png', 'articuno_shiny.png', FALSE, NULL, NULL, 'A legendary bird Pokémon that is said to appear to doomed people who are lost in icy mountains.', 'Articuno is said to live in icy mountains and appears to travelers lost in snow.', 'Seafoam Islands after 8 badges', 'Legendary Birds', 'Legendary,Generation 1,Ice,Flying,Kanto,Trio', 'Pressure, Snow Cloak', 'Freeze-Dry', 1.7, 55.4, FALSE, 'RBY, GSC, FRLG, HGSS, XY, LGPE', NOW(), NOW()),

(NULL, 'Zapdos', 145, 'Electric', 'Flying', 'Legendary', 1, 'Kanto', 90, 90, 85, 125, 90, 100, 580, 'zapdos.png', 'zapdos_shiny.png', FALSE, NULL, NULL, 'A legendary bird Pokémon that is said to appear from clouds while dropping enormous lightning bolts.', 'Zapdos nests in thunderclouds and gains power from lightning strikes.', 'Power Plant in Kanto', 'Legendary Birds', 'Legendary,Generation 1,Electric,Flying,Kanto,Trio', 'Pressure, Static', 'Thunder Shock', 1.6, 52.6, FALSE, 'RBY, GSC, FRLG, HGSS, XY, LGPE', NOW(), NOW()),

(NULL, 'Moltres', 146, 'Fire', 'Flying', 'Legendary', 1, 'Kanto', 90, 100, 90, 125, 85, 90, 580, 'moltres.png', 'moltres_shiny.png', FALSE, NULL, NULL, 'A legendary bird Pokémon that is said to bring early spring to the wintry lands it visits.', 'Moltres migrates from the south bringing spring. Heals in volcanoes.', 'Victory Road after 8 badges', 'Legendary Birds', 'Legendary,Generation 1,Fire,Flying,Kanto,Trio', 'Pressure, Flame Body', 'Heat Wave', 2.0, 60.0, FALSE, 'RBY, GSC, FRLG, HGSS, XY, LGPE', NOW(), NOW()),

(NULL, 'Mewtwo', 150, 'Psychic', NULL, 'Legendary', 1, 'Kanto', 106, 110, 90, 154, 90, 130, 680, 'mewtwo.png', 'mewtwo_shiny.png', TRUE, 'mewtwo_mega_x.png,mewtwo_mega_y.png', 'Mega X: Psychic/Fighting, Mega Y: Pure Psychic', 'Created by scientists through genetic manipulation from Mew DNA.', 'Mewtwo was created to be the ultimate battle Pokemon through gene splicing.', 'Cerulean Cave post-Elite Four', NULL, 'Legendary,Generation 1,Psychic,Kanto,Box Legendary,Mega Evolution', 'Pressure, Unnerve', 'Psystrike', 2.0, 122.0, FALSE, 'RBY, GSC, FRLG, HGSS, XY, LGPE', NOW(), NOW()),

(NULL, 'Mew', 151, 'Psychic', NULL, 'Mythical', 1, 'Kanto', 100, 100, 100, 100, 100, 100, 600, 'mew.png', 'mew_shiny.png', FALSE, NULL, NULL, 'So rare that it is still said to be a mirage by many experts.', 'Mew possesses the genetic composition of all Pokemon and is their ancestor.', 'Event-exclusive only', NULL, 'Mythical,Generation 1,Psychic,Kanto,Event-Exclusive', 'Synchronize', 'Psychic', 0.4, 4.0, TRUE, 'Events Only', NOW(), NOW());

-- GENERATION 2 - JOHTO (6 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Raikou', 243, 'Electric', NULL, 'Legendary', 2, 'Johto', 90, 85, 75, 115, 100, 115, 580, 'raikou.png', 'raikou_shiny.png', FALSE, NULL, NULL, 'The rain clouds it carries let it fire thunderbolts at will.', 'Raikou embodies the speed of lightning and roars like thunder.', 'Roaming Johto after Burned Tower', 'Legendary Beasts', 'Legendary,Generation 2,Electric,Johto,Trio,Roaming', 'Pressure, Inner Focus', 'Thunder', 1.9, 178.0, FALSE, 'GSC, FRLG, HGSS', NOW(), NOW()),

(NULL, 'Entei', 244, 'Fire', NULL, 'Legendary', 2, 'Johto', 115, 115, 85, 90, 75, 100, 580, 'entei.png', 'entei_shiny.png', FALSE, NULL, NULL, 'Volcanoes erupt when it barks. Unable to contain its sheer power.', 'Entei embodies magma passion and was born in volcanic eruption.', 'Roaming Johto after Burned Tower', 'Legendary Beasts', 'Legendary,Generation 2,Fire,Johto,Trio,Roaming', 'Pressure, Inner Focus', 'Sacred Fire', 2.1, 198.0, FALSE, 'GSC, FRLG, HGSS', NOW(), NOW()),

(NULL, 'Suicune', 245, 'Water', NULL, 'Legendary', 2, 'Johto', 100, 75, 115, 90, 115, 85, 580, 'suicune.png', 'suicune_shiny.png', FALSE, NULL, NULL, 'Said to be the embodiment of north winds, it can purify water.', 'Suicune embodies pure spring water blessed by the north wind.', 'Roaming Johto, Tin Tower in Crystal', 'Legendary Beasts', 'Legendary,Generation 2,Water,Johto,Trio,Roaming', 'Pressure, Inner Focus', 'Aurora Beam', 2.0, 187.0, FALSE, 'GSC, FRLG, HGSS', NOW(), NOW()),

(NULL, 'Lugia', 249, 'Psychic', 'Flying', 'Legendary', 2, 'Johto', 106, 90, 130, 90, 154, 110, 680, 'lugia.png', 'lugia_shiny.png', FALSE, NULL, NULL, 'It quietly spends time deep at the bottom of the sea.', 'Lugia is guardian of the seas and master of the legendary birds.', 'Whirl Islands with Silver Wing', 'Tower Duo', 'Legendary,Generation 2,Psychic,Flying,Johto,Box Legendary', 'Pressure, Multiscale', 'Aeroblast', 5.2, 216.0, FALSE, 'S, C, XD, HGSS', NOW(), NOW()),

(NULL, 'Ho-Oh', 250, 'Fire', 'Flying', 'Legendary', 2, 'Johto', 106, 130, 90, 110, 154, 90, 680, 'ho-oh.png', 'ho-oh_shiny.png', FALSE, NULL, NULL, 'Legends claim this Pokemon flies the world\'s skies continuously.', 'Ho-Oh is guardian of the skies and master of legendary beasts.', 'Tin Tower with Rainbow Wing', 'Tower Duo', 'Legendary,Generation 2,Fire,Flying,Johto,Box Legendary', 'Pressure, Regenerator', 'Sacred Fire', 3.8, 199.0, FALSE, 'G, C, Colosseum, HGSS', NOW(), NOW()),

(NULL, 'Celebi', 251, 'Psychic', 'Grass', 'Mythical', 2, 'Johto', 100, 100, 100, 100, 100, 100, 600, 'celebi.png', 'celebi_shiny.png', FALSE, NULL, NULL, 'This Pokemon wanders across time. Forests flourish where it appears.', 'Celebi travels through time and only appears during times of peace.', 'Event-exclusive, Pokemon Bank', NULL, 'Mythical,Generation 2,Psychic,Grass,Johto,Event-Exclusive,Time Travel', 'Natural Cure', 'Future Sight', 0.6, 5.0, TRUE, 'Events, Pokemon Bank', NOW(), NOW());

-- GENERATION 3 - HOENN (10 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Regirock', 377, 'Rock', NULL, 'Legendary', 3, 'Hoenn', 80, 100, 200, 50, 100, 50, 580, 'regirock.png', 'regirock_shiny.png', FALSE, NULL, NULL, 'Regirock was sealed away long ago. It repairs itself with rocks.', 'Made entirely of rocks, sealed in ancient tomb, repairs with new rocks.', 'Desert Ruins puzzle', 'Legendary Titans', 'Legendary,Generation 3,Rock,Hoenn,Trio,Golem', 'Clear Body, Sturdy', 'Stone Edge', 1.7, 230.0, FALSE, 'RSE, Pt, B2W2, ORAS', NOW(), NOW()),

(NULL, 'Regice', 378, 'Ice', NULL, 'Legendary', 3, 'Hoenn', 80, 50, 100, 100, 200, 50, 580, 'regice.png', 'regice_shiny.png', FALSE, NULL, NULL, 'Regice cloaks itself with frigid air of -328 degrees Fahrenheit.', 'Made of ice age ice, controls cryogenic air of -328°F.', 'Island Cave puzzle', 'Legendary Titans', 'Legendary,Generation 3,Ice,Hoenn,Trio,Golem', 'Clear Body, Ice Body', 'Ice Beam', 1.8, 175.0, FALSE, 'RSE, Pt, B2W2, ORAS', NOW(), NOW()),

(NULL, 'Registeel', 379, 'Steel', NULL, 'Legendary', 3, 'Hoenn', 80, 75, 150, 75, 150, 50, 580, 'registeel.png', 'registeel_shiny.png', FALSE, NULL, NULL, 'Registeel has a body harder than any metal. Apparently hollow.', 'Made of unknown metal harder than any known metal.', 'Ancient Tomb puzzle', 'Legendary Titans', 'Legendary,Generation 3,Steel,Hoenn,Trio,Golem', 'Clear Body, Light Metal', 'Flash Cannon', 1.9, 205.0, FALSE, 'RSE, Pt, B2W2, ORAS', NOW(), NOW()),

(NULL, 'Latias', 380, 'Dragon', 'Psychic', 'Legendary', 3, 'Hoenn', 80, 80, 90, 110, 130, 110, 600, 'latias.png', 'latias_shiny.png', TRUE, 'latias_mega.png', 'Mega Evolution available', 'Highly intelligent and can understand human speech.', 'Can sense emotions and become invisible using psychic powers.', 'Roaming Hoenn, Southern Island', 'Eon Duo', 'Legendary,Generation 3,Dragon,Psychic,Hoenn,Mega Evolution', 'Levitate', 'Mist Ball', 1.4, 40.0, FALSE, 'S, E, HG, OR, AS', NOW(), NOW()),

(NULL, 'Latios', 381, 'Dragon', 'Psychic', 'Legendary', 3, 'Hoenn', 80, 90, 80, 130, 110, 110, 600, 'latios.png', 'latios_shiny.png', TRUE, 'latios_mega.png', 'Mega Evolution available', 'Understands human speech and is highly intelligent.', 'Can project images into minds and fly faster than a jet.', 'Roaming Hoenn, Southern Island', 'Eon Duo', 'Legendary,Generation 3,Dragon,Psychic,Hoenn,Mega Evolution', 'Levitate', 'Luster Purge', 2.0, 60.0, FALSE, 'R, E, SS, OR, AS', NOW(), NOW()),

(NULL, 'Kyogre', 382, 'Water', NULL, 'Legendary', 3, 'Hoenn', 100, 100, 90, 150, 140, 90, 670, 'kyogre.png', 'kyogre_shiny.png', TRUE, 'kyogre_primal.png', 'Primal Reversion: Water type, boosted stats', 'Can summon storms that cause sea levels to rise.', 'Personification of the sea, battled Groudon to expand seas.', 'Cave of Origin/Marine Cave', 'Weather Trio', 'Legendary,Generation 3,Water,Hoenn,Box Legendary,Primal', 'Drizzle', 'Origin Pulse', 4.5, 352.0, FALSE, 'S, E, HGSS, AS', NOW(), NOW()),

(NULL, 'Groudon', 383, 'Ground', NULL, 'Legendary', 3, 'Hoenn', 100, 150, 140, 100, 90, 90, 670, 'groudon.png', 'groudon_shiny.png', TRUE, 'groudon_primal.png', 'Primal Reversion: Ground/Fire type, boosted stats', 'Can expand continents through its power.', 'Personification of land, battled Kyogre to expand continents.', 'Cave of Origin/Terra Cave', 'Weather Trio', 'Legendary,Generation 3,Ground,Hoenn,Box Legendary,Primal', 'Drought', 'Precipice Blades', 3.5, 950.0, FALSE, 'R, E, HGSS, OR', NOW(), NOW()),

(NULL, 'Rayquaza', 384, 'Dragon', 'Flying', 'Legendary', 3, 'Hoenn', 105, 150, 90, 150, 90, 95, 680, 'rayquaza.png', 'rayquaza_shiny.png', TRUE, 'rayquaza_mega.png', 'Mega Evolution available', 'Flies through ozone layer, consuming meteoroids.', 'Lives in ozone layer, descends to stop Kyogre and Groudon.', 'Sky Pillar after crisis', 'Weather Trio', 'Legendary,Generation 3,Dragon,Flying,Hoenn,Box Legendary,Mega', 'Air Lock', 'Dragon Ascent', 7.0, 206.5, FALSE, 'RSE, HGSS, ORAS', NOW(), NOW()),

(NULL, 'Jirachi', 385, 'Steel', 'Psychic', 'Mythical', 3, 'Hoenn', 100, 100, 100, 100, 100, 100, 600, 'jirachi.png', 'jirachi_shiny.png', FALSE, NULL, NULL, 'Jirachi will make true any wish written on its head tags.', 'Awakens once every thousand years for seven days to grant wishes.', 'Event-exclusive only', NULL, 'Mythical,Generation 3,Steel,Psychic,Hoenn,Event-Exclusive', 'Serene Grace', 'Doom Desire', 0.3, 1.1, TRUE, 'Events, Colosseum Bonus', NOW(), NOW()),

(NULL, 'Deoxys', 386, 'Psychic', NULL, 'Mythical', 3, 'Hoenn', 50, 150, 50, 150, 50, 150, 600, 'deoxys.png', 'deoxys_shiny.png', TRUE, 'deoxys_attack.png,deoxys_defense.png,deoxys_speed.png', 'Normal, Attack, Defense, Speed forms', 'DNA of space virus mutated after laser beam exposure.', 'Alien virus that can change forms to boost different stats.', 'Birth Island, Delta Episode', NULL, 'Mythical,Generation 3,Psychic,Hoenn,Event-Exclusive,Forms', 'Pressure', 'Psycho Boost', 1.7, 60.8, TRUE, 'Events, FRLG, ORAS', NOW(), NOW());

-- GENERATION 4 - SINNOH (14 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Uxie', 480, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh', 75, 75, 130, 75, 130, 95, 580, 'uxie.png', 'uxie_shiny.png', FALSE, NULL, NULL, 'Known as the Being of Knowledge. Can wipe memories with a glare.', 'Known as the Being of Knowledge, one of the lake guardians.', 'Lake Acuity after story', 'Lake Guardians', 'Legendary,Generation 4,Psychic,Sinnoh,Trio', 'Levitate', 'Confusion', 0.3, 0.3, FALSE, 'DPPt, BDSP', NOW(), NOW()),

(NULL, 'Mesprit', 481, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh', 80, 105, 105, 105, 105, 80, 580, 'mesprit.png', 'mesprit_shiny.png', FALSE, NULL, NULL, 'Known as the Being of Emotion. Taught humans joy and sorrow.', 'Known as the Being of Emotion, one of the lake guardians.', 'Lake Verity, then roaming', 'Lake Guardians', 'Legendary,Generation 4,Psychic,Sinnoh,Trio,Roaming', 'Levitate', 'Confusion', 0.3, 0.3, FALSE, 'DPPt, BDSP', NOW(), NOW()),

(NULL, 'Azelf', 482, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh', 75, 125, 70, 125, 70, 115, 580, 'azelf.png', 'azelf_shiny.png', FALSE, NULL, NULL, 'Known as the Being of Willpower. Sleeps at bottom of a lake.', 'Known as the Being of Willpower, one of the lake guardians.', 'Lake Valor after story', 'Lake Guardians', 'Legendary,Generation 4,Psychic,Sinnoh,Trio', 'Levitate', 'Confusion', 0.3, 0.3, FALSE, 'DPPt, BDSP', NOW(), NOW()),

(NULL, 'Dialga', 483, 'Steel', 'Dragon', 'Legendary', 4, 'Sinnoh', 100, 120, 120, 150, 100, 90, 680, 'dialga.png', 'dialga_shiny.png', TRUE, 'dialga_origin.png', 'Origin Form available in Legends Arceus', 'It has the power to control time. Appears in Sinnoh myths.', 'Has power to control time, created when universe was born.', 'Spear Pillar after story', 'Creation Trio', 'Legendary,Generation 4,Steel,Dragon,Sinnoh,Box Legendary,Origin Form', 'Pressure, Telepathy', 'Roar of Time', 5.4, 683.0, FALSE, 'D, Pt, BDSP, PLA', NOW(), NOW()),

(NULL, 'Palkia', 484, 'Water', 'Dragon', 'Legendary', 4, 'Sinnoh', 90, 120, 100, 150, 120, 100, 680, 'palkia.png', 'palkia_shiny.png', TRUE, 'palkia_origin.png', 'Origin Form available in Legends Arceus', 'It has the ability to distort space. Appears in Sinnoh myths.', 'Has power to distort space, created when universe was born.', 'Spear Pillar after story', 'Creation Trio', 'Legendary,Generation 4,Water,Dragon,Sinnoh,Box Legendary,Origin Form', 'Pressure, Telepathy', 'Spacial Rend', 4.2, 336.0, FALSE, 'P, Pt, BDSP, PLA', NOW(), NOW()),

(NULL, 'Heatran', 485, 'Fire', 'Steel', 'Legendary', 4, 'Sinnoh', 91, 90, 106, 130, 106, 77, 600, 'heatran.png', 'heatran_shiny.png', FALSE, NULL, NULL, 'Dwells in volcanic caves. Its blood boils at 10,000 degrees.', 'Dwells in volcanic caves with blood that boils at extreme heat.', 'Stark Mountain after story', NULL, 'Legendary,Generation 4,Fire,Steel,Sinnoh', 'Flash Fire, Flame Body', 'Magma Storm', 1.7, 430.0, FALSE, 'DPPt, HGSS, B2W2, ORAS, BDSP', NOW(), NOW()),

(NULL, 'Regigigas', 486, 'Normal', NULL, 'Legendary', 4, 'Sinnoh', 110, 160, 110, 80, 110, 100, 670, 'regigigas.png', 'regigigas_shiny.png', FALSE, NULL, NULL, 'There is an enduring legend that states this Pokemon towed continents.', 'Master of the legendary titans, towed continents with ropes.', 'Snowpoint Temple with all Regis', 'Legendary Titans', 'Legendary,Generation 4,Normal,Sinnoh,Master', 'Slow Start', 'Crush Grip', 3.7, 420.0, FALSE, 'DPPt, B2W2, ORAS, BDSP', NOW(), NOW()),

(NULL, 'Giratina', 487, 'Ghost', 'Dragon', 'Legendary', 4, 'Sinnoh', 150, 100, 120, 100, 120, 90, 680, 'giratina.png', 'giratina_shiny.png', TRUE, 'giratina_origin.png', 'Altered Form (normal), Origin Form (with Griseous Orb)', 'It was banished for its violence. It silently gazed from the Distortion World.', 'Banished to Distortion World for violence, can travel between worlds.', 'Distortion World/Turnback Cave', 'Creation Trio', 'Legendary,Generation 4,Ghost,Dragon,Sinnoh,Box Legendary,Forms', 'Pressure, Telepathy', 'Shadow Force', 4.5, 650.0, FALSE, 'Pt, HGSS, B2W2, ORAS, BDSP, PLA', NOW(), NOW()),

(NULL, 'Cresselia', 488, 'Psychic', NULL, 'Legendary', 4, 'Sinnoh', 120, 70, 120, 75, 130, 85, 600, 'cresselia.png', 'cresselia_shiny.png', FALSE, NULL, NULL, 'Shining particles from its wings bring happy dreams.', 'Represents the crescent moon and brings pleasant dreams.', 'Fullmoon Island, then roaming', NULL, 'Legendary,Generation 4,Psychic,Sinnoh,Roaming', 'Levitate', 'Psycho Cut', 1.5, 85.6, FALSE, 'DPPt, BW, B2W2, ORAS, BDSP', NOW(), NOW()),

(NULL, 'Phione', 489, 'Water', NULL, 'Mythical', 4, 'Sinnoh', 80, 80, 80, 80, 80, 80, 480, 'phione.png', 'phione_shiny.png', FALSE, NULL, NULL, 'A Pokémon that lives in warm seas. Drifts ashore on icebergs.', 'Born from Manaphy, drifts through warm ocean waters.', 'Breed Manaphy with Ditto', NULL, 'Mythical,Generation 4,Water,Sinnoh', 'Hydration', 'Water Pulse', 0.4, 3.1, FALSE, 'DPPt (breeding), BDSP', NOW(), NOW()),

(NULL, 'Manaphy', 490, 'Water', NULL, 'Mythical', 4, 'Sinnoh', 100, 100, 100, 100, 100, 100, 600, 'manaphy.png', 'manaphy_shiny.png', FALSE, NULL, NULL, 'Born on a cold seafloor, it will swim great distances to return.', 'Prince of the Sea, born on cold seafloor, can swap hearts.', 'Event-exclusive, Pokemon Ranger', NULL, 'Mythical,Generation 4,Water,Sinnoh,Event-Exclusive', 'Hydration', 'Heart Swap', 0.3, 1.4, TRUE, 'Events, Pokemon Ranger', NOW(), NOW()),

(NULL, 'Darkrai', 491, 'Dark', NULL, 'Mythical', 4, 'Sinnoh', 70, 90, 90, 135, 90, 125, 600, 'darkrai.png', 'darkrai_shiny.png', FALSE, NULL, NULL, 'It chases people and Pokemon away with nightmares.', 'Represents the new moon and causes nightmares.', 'Newmoon Island with event item', NULL, 'Mythical,Generation 4,Dark,Sinnoh,Event-Exclusive', 'Bad Dreams', 'Dark Void', 1.5, 50.5, TRUE, 'Events, Pt, BDSP', NOW(), NOW()),

(NULL, 'Shaymin', 492, 'Grass', NULL, 'Mythical', 4, 'Sinnoh', 100, 100, 100, 100, 100, 100, 600, 'shaymin.png', 'shaymin_shiny.png', TRUE, 'shaymin_sky.png', 'Land Form (Grass), Sky Form (Grass/Flying)', 'The flowers all over its body burst into bloom if it is healthy.', 'Gratitude Pokemon that can purify polluted land with flowers.', 'Event-exclusive, Flower Paradise', NULL, 'Mythical,Generation 4,Grass,Sinnoh,Event-Exclusive,Forms', 'Natural Cure, Serene Grace', 'Seed Flare', 0.2, 2.1, TRUE, 'Events, Pt, BDSP', NOW(), NOW()),

(NULL, 'Arceus', 493, 'Normal', NULL, 'Mythical', 4, 'Sinnoh', 120, 120, 120, 120, 120, 120, 720, 'arceus.png', 'arceus_shiny.png', TRUE, 'arceus_types.png', 'Can change type with plates/Z-Crystals', 'According to legend, it shaped the universe with its 1,000 arms.', 'The Original One that shaped the universe with 1,000 arms.', 'Event-exclusive, Hall of Origin', NULL, 'Mythical,Generation 4,Normal,Sinnoh,Event-Exclusive,God Pokemon,Type Change', 'Multitype', 'Judgment', 3.2, 320.0, TRUE, 'Events, BDSP, PLA', NOW(), NOW());

-- GENERATION 5 - UNOVA (13 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Cobalion', 638, 'Steel', 'Fighting', 'Legendary', 5, 'Unova', 91, 90, 129, 90, 72, 108, 580, 'cobalion.png', 'cobalion_shiny.png', FALSE, NULL, NULL, 'It has a body and heart of steel. It intimidated Pokémon with its glare.', 'Leader of Swords of Justice, protected Pokemon during war.', 'Mistralton Cave', 'Swords of Justice', 'Legendary,Generation 5,Steel,Fighting,Unova,Quartet', 'Justified', 'Sacred Sword', 2.1, 250.0, FALSE, 'BW, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Terrakion', 639, 'Rock', 'Fighting', 'Legendary', 5, 'Unova', 91, 129, 90, 72, 90, 108, 580, 'terrakion.png', 'terrakion_shiny.png', FALSE, NULL, NULL, 'Its charge is strong enough to break through a giant castle wall.', 'Member of Swords of Justice, can smash castle walls.', 'Victory Road', 'Swords of Justice', 'Legendary,Generation 5,Rock,Fighting,Unova,Quartet', 'Justified', 'Sacred Sword', 1.9, 260.0, FALSE, 'BW, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Virizion', 640, 'Grass', 'Fighting', 'Legendary', 5, 'Unova', 91, 90, 72, 90, 129, 108, 580, 'virizion.png', 'virizion_shiny.png', FALSE, NULL, NULL, 'Legends say this Pokemon confounded opponents with swift movements.', 'Member of Swords of Justice, swift and graceful fighter.', 'Pinwheel Forest', 'Swords of Justice', 'Legendary,Generation 5,Grass,Fighting,Unova,Quartet', 'Justified', 'Sacred Sword', 2.0, 200.0, FALSE, 'BW, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Tornadus', 641, 'Flying', NULL, 'Legendary', 5, 'Unova', 79, 115, 70, 125, 80, 111, 580, 'tornadus.png', 'tornadus_shiny.png', TRUE, 'tornadus_therian.png', 'Incarnate Form (pure Flying), Therian Form (Flying)', 'The lower half of its body is wrapped in a cloud. It flies at 200 mph.', 'Forces of Nature member, creates terrible windstorms.', 'Roaming Unova in BW', 'Forces of Nature', 'Legendary,Generation 5,Flying,Unova,Trio,Roaming,Forms', 'Prankster, Defiant', 'Hurricane', 1.5, 63.0, FALSE, 'W, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Thundurus', 642, 'Electric', 'Flying', 'Legendary', 5, 'Unova', 79, 115, 70, 125, 80, 111, 580, 'thundurus.png', 'thundurus_shiny.png', TRUE, 'thundurus_therian.png', 'Incarnate and Therian Forms', 'The spikes on its tail discharge immense bolts of lightning.', 'Forces of Nature member, shoots lightning from its tail.', 'Roaming Unova in BW', 'Forces of Nature', 'Legendary,Generation 5,Electric,Flying,Unova,Trio,Roaming,Forms', 'Prankster, Defiant', 'Thunder', 1.5, 61.0, FALSE, 'B, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Reshiram', 643, 'Dragon', 'Fire', 'Legendary', 5, 'Unova', 100, 120, 100, 150, 120, 90, 680, 'reshiram.png', 'reshiram_shiny.png', FALSE, NULL, NULL, 'This Pokemon appears in legends. It sends flames into the air from its tail.', 'Represents truth and ideals, legendary dragon of Unova.', 'N\'s Castle in Black/White', 'Tao Trio', 'Legendary,Generation 5,Dragon,Fire,Unova,Box Legendary', 'Turboblaze', 'Blue Flare', 3.2, 330.0, FALSE, 'B, B2W2, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Zekrom', 644, 'Dragon', 'Electric', 'Legendary', 5, 'Unova', 100, 150, 120, 120, 100, 90, 680, 'zekrom.png', 'zekrom_shiny.png', FALSE, NULL, NULL, 'Concealing itself in lightning clouds, it flies throughout Unova.', 'Represents ideals and truth, legendary dragon of Unova.', 'N\'s Castle in Black/White', 'Tao Trio', 'Legendary,Generation 5,Dragon,Electric,Unova,Box Legendary', 'Teravolt', 'Bolt Strike', 2.9, 345.0, FALSE, 'W, B2W2, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Landorus', 645, 'Ground', 'Flying', 'Legendary', 5, 'Unova', 89, 125, 90, 115, 80, 101, 600, 'landorus.png', 'landorus_shiny.png', TRUE, 'landorus_therian.png', 'Incarnate and Therian Forms', 'The energy from its tail makes the land fertile.', 'Forces of Nature leader, brings fertility to the land.', 'Abundant Shrine with Tornadus and Thundurus', 'Forces of Nature', 'Legendary,Generation 5,Ground,Flying,Unova,Trio,Forms', 'Sand Force, Intimidate', 'Earth Power', 1.5, 68.0, FALSE, 'BW, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Kyurem', 646, 'Dragon', 'Ice', 'Legendary', 5, 'Unova', 125, 130, 90, 130, 90, 95, 660, 'kyurem.png', 'kyurem_shiny.png', TRUE, 'kyurem_white.png,kyurem_black.png', 'Base form, White Kyurem (with Reshiram), Black Kyurem (with Zekrom)', 'It generates powerful freezing energy but leaks it from its body.', 'Empty shell left behind when Reshiram and Zekrom split.', 'Giant Chasm', 'Tao Trio', 'Legendary,Generation 5,Dragon,Ice,Unova,Box Legendary,Fusion', 'Pressure', 'Glaciate', 3.0, 325.0, FALSE, 'BW, B2W2, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Keldeo', 647, 'Water', 'Fighting', 'Mythical', 5, 'Unova', 91, 72, 90, 129, 90, 108, 580, 'keldeo.png', 'keldeo_shiny.png', TRUE, 'keldeo_resolute.png', 'Ordinary Form, Resolute Form (learns Secret Sword)', 'By blasting water from its hooves, it can glide across water.', 'Student of Swords of Justice, youngest member of the group.', 'Event-exclusive', 'Swords of Justice', 'Mythical,Generation 5,Water,Fighting,Unova,Event-Exclusive,Quartet,Forms', 'Justified', 'Secret Sword', 1.4, 48.5, TRUE, 'Events, B2W2, ORAS, SwSh Crown', NOW(), NOW()),

(NULL, 'Meloetta', 648, 'Normal', 'Psychic', 'Mythical', 5, 'Unova', 100, 77, 77, 128, 128, 90, 600, 'meloetta.png', 'meloetta_shiny.png', TRUE, 'meloetta_pirouette.png', 'Aria Form (Normal/Psychic), Pirouette Form (Normal/Fighting)', 'The melodies sung by Meloetta have the power to make Pokemon cry or laugh.', 'Melody Pokemon whose songs can control emotions.', 'Event-exclusive', NULL, 'Mythical,Generation 5,Normal,Psychic,Unova,Event-Exclusive,Forms', 'Serene Grace', 'Relic Song', 0.6, 6.5, TRUE, 'Events, B2W2', NOW(), NOW()),

(NULL, 'Genesect', 649, 'Bug', 'Steel', 'Mythical', 5, 'Unova', 71, 120, 95, 120, 95, 99, 600, 'genesect.png', 'genesect_shiny.png', TRUE, 'genesect_drives.png', 'Can hold different Drives to change Techno Blast type', 'Over 300 million years ago, it was modified by Team Plasma.', 'Ancient bug modified by Team Plasma with a cannon on its back.', 'Event-exclusive', NULL, 'Mythical,Generation 5,Bug,Steel,Unova,Event-Exclusive,Modified', 'Download', 'Techno Blast', 1.5, 82.5, TRUE, 'Events, B2W2', NOW(), NOW()),

(NULL, 'Victini', 494, 'Psychic', 'Fire', 'Mythical', 5, 'Unova', 100, 100, 100, 100, 100, 100, 600, 'victini.png', 'victini_shiny.png', FALSE, NULL, NULL, 'This Pokemon brings victory. It shares its infinite energy with those who touch it.', 'Victory Pokemon that generates unlimited energy and brings victory.', 'Liberty Garden with event item', NULL, 'Mythical,Generation 5,Psychic,Fire,Unova,Event-Exclusive', 'Victory Star', 'V-create', 0.4, 4.0, TRUE, 'BW with event item', NOW(), NOW());

-- GENERATION 6 - KALOS (6 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Xerneas', 716, 'Fairy', NULL, 'Legendary', 6, 'Kalos', 126, 131, 95, 131, 98, 99, 680, 'xerneas.png', 'xerneas_shiny.png', TRUE, 'xerneas_active.png', 'Neutral Mode (dormant), Active Mode (in battle)', 'Legends say it can share eternal life. It slept for a thousand years.', 'Life Pokemon that shares eternal life and awakened from 1000 year sleep.', 'Team Flare HQ in X', 'Aura Trio', 'Legendary,Generation 6,Fairy,Kalos,Box Legendary,Modes', 'Fairy Aura', 'Geomancy', 3.0, 215.0, FALSE, 'X, USUM', NOW(), NOW()),

(NULL, 'Yveltal', 717, 'Dark', 'Flying', 'Legendary', 6, 'Kalos', 126, 131, 95, 131, 98, 99, 680, 'yveltal.png', 'yveltal_shiny.png', FALSE, NULL, NULL, 'When life comes to an end, this Pokemon absorbs the life energy.', 'Destruction Pokemon that absorbs life energy when it awakens.', 'Team Flare HQ in Y', 'Aura Trio', 'Legendary,Generation 6,Dark,Flying,Kalos,Box Legendary', 'Dark Aura', 'Oblivion Wing', 5.8, 203.0, FALSE, 'Y, USUM', NOW(), NOW()),

(NULL, 'Zygarde', 718, 'Dragon', 'Ground', 'Legendary', 6, 'Kalos', 108, 100, 121, 81, 95, 95, 600, 'zygarde.png', 'zygarde_shiny.png', TRUE, 'zygarde_10.png,zygarde_complete.png', '50% Form (base), 10% Form, Complete Form (100%)', 'It monitors the ecosystem of the Kalos region. It protects the environment.', 'Order Pokemon that maintains ecosystem balance with its cells.', 'Terminus Cave, Route 10', 'Aura Trio', 'Legendary,Generation 6,Dragon,Ground,Kalos,Box Legendary,Forms', 'Aura Break, Power Construct', 'Thousand Arrows', 5.0, 305.0, FALSE, 'XY, SM, USUM', NOW(), NOW()),

(NULL, 'Diancie', 719, 'Rock', 'Fairy', 'Mythical', 6, 'Kalos', 50, 100, 150, 100, 150, 50, 600, 'diancie.png', 'diancie_shiny.png', TRUE, 'diancie_mega.png', 'Regular form, Mega Evolution available', 'A sudden transformation of Carbink, its pink body glitters.', 'Jewel Pokemon born from mutation of Carbink, creates diamonds.', 'Event-exclusive', NULL, 'Mythical,Generation 6,Rock,Fairy,Kalos,Event-Exclusive,Mega Evolution', 'Clear Body', 'Diamond Storm', 0.7, 8.8, TRUE, 'Events, ORAS', NOW(), NOW()),

(NULL, 'Hoopa', 720, 'Psychic', 'Ghost', 'Mythical', 6, 'Kalos', 80, 110, 60, 150, 130, 70, 600, 'hoopa.png', 'hoopa_shiny.png', TRUE, 'hoopa_unbound.png', 'Confined Form (Psychic/Ghost), Unbound Form (Psychic/Dark)', 'It gathers things it likes and stores them in its rings.', 'Mischief Pokemon that can summon things through its rings.', 'Event-exclusive', NULL, 'Mythical,Generation 6,Psychic,Ghost,Kalos,Event-Exclusive,Forms', 'Magician', 'Hyperspace Hole', 0.5, 9.0, TRUE, 'Events, ORAS', NOW(), NOW()),

(NULL, 'Volcanion', 721, 'Fire', 'Water', 'Mythical', 6, 'Kalos', 80, 110, 120, 130, 90, 70, 600, 'volcanion.png', 'volcanion_shiny.png', FALSE, NULL, NULL, 'It expels its internal steam from the arms on its back.', 'Steam Pokemon with unique Fire/Water typing, expels steam.', 'Event-exclusive', NULL, 'Mythical,Generation 6,Fire,Water,Kalos,Event-Exclusive', 'Water Absorb', 'Steam Eruption', 1.7, 195.0, TRUE, 'Events', NOW(), NOW());

-- GENERATION 7 - ALOLA (11 Pokemon + 11 Ultra Beasts)

INSERT INTO pokemon VALUES 
(NULL, 'Type: Null', 772, 'Normal', NULL, 'Legendary', 7, 'Alola', 95, 95, 95, 95, 95, 59, 534, 'type_null.png', 'type_null_shiny.png', FALSE, NULL, NULL, 'A Pokemon made through genetic modification to be the ultimate weapon.', 'Synthetic Pokemon created to fight Ultra Beasts, evolves into Silvally.', 'Given by Gladion', NULL, 'Legendary,Generation 7,Normal,Alola,Synthetic,Pre-Evolution', 'Battle Armor', 'Tri Attack', 1.9, 120.5, FALSE, 'SM, USUM, SwSh', NOW(), NOW()),

(NULL, 'Silvally', 773, 'Normal', NULL, 'Legendary', 7, 'Alola', 95, 95, 95, 95, 95, 95, 570, 'silvally.png', 'silvally_shiny.png', TRUE, 'silvally_types.png', 'Can change type with different memories', 'It destroyed its own control mask to save its partner.', 'Evolution of Type: Null that broke free, can change type with memories.', 'Evolve Type: Null with high friendship', NULL, 'Legendary,Generation 7,Normal,Alola,Synthetic,Type Change', 'RKS System', 'Multi-Attack', 2.3, 100.5, FALSE, 'SM, USUM, SwSh', NOW(), NOW()),

(NULL, 'Tapu Koko', 785, 'Electric', 'Fairy', 'Legendary', 7, 'Alola', 70, 115, 85, 95, 75, 130, 570, 'tapu_koko.png', 'tapu_koko_shiny.png', FALSE, NULL, NULL, 'The lightning-wielding guardian deity of Melemele Island.', 'Guardian deity of Melemele Island, protects the island.', 'Ruins of Conflict post-game', 'Guardian Deities', 'Legendary,Generation 7,Electric,Fairy,Alola,Quartet,Guardian', 'Electric Surge, Telepathy', 'Nature\'s Madness', 1.8, 20.5, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Tapu Lele', 786, 'Psychic', 'Fairy', 'Legendary', 7, 'Alola', 70, 85, 75, 130, 115, 95, 570, 'tapu_lele.png', 'tapu_lele_shiny.png', FALSE, NULL, NULL, 'The guardian deity of Akala Island, it heals its own wounds.', 'Guardian deity of Akala Island, heals and harms with scales.', 'Ruins of Life post-game', 'Guardian Deities', 'Legendary,Generation 7,Psychic,Fairy,Alola,Quartet,Guardian', 'Psychic Surge, Telepathy', 'Nature\'s Madness', 1.2, 18.6, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Tapu Bulu', 787, 'Grass', 'Fairy', 'Legendary', 7, 'Alola', 70, 130, 115, 85, 95, 75, 570, 'tapu_bulu.png', 'tapu_bulu_shiny.png', FALSE, NULL, NULL, 'The guardian deity of Ula\'ula Island, it has incredible physical strength.', 'Guardian deity of Ula\'ula Island with immense strength.', 'Ruins of Abundance post-game', 'Guardian Deities', 'Legendary,Generation 7,Grass,Fairy,Alola,Quartet,Guardian', 'Grassy Surge, Telepathy', 'Nature\'s Madness', 1.9, 45.5, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Tapu Fini', 788, 'Water', 'Fairy', 'Legendary', 7, 'Alola', 70, 75, 115, 95, 130, 85, 570, 'tapu_fini.png', 'tapu_fini_shiny.png', FALSE, NULL, NULL, 'The guardian deity of Poni Island, it creates a mystical mist.', 'Guardian deity of Poni Island that creates purifying fog.', 'Ruins of Hope post-game', 'Guardian Deities', 'Legendary,Generation 7,Water,Fairy,Alola,Quartet,Guardian', 'Misty Surge, Telepathy', 'Nature\'s Madness', 1.3, 21.2, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Cosmog', 789, 'Psychic', NULL, 'Legendary', 7, 'Alola', 43, 29, 31, 29, 31, 37, 200, 'cosmog.png', 'cosmog_shiny.png', FALSE, NULL, NULL, 'Its body is gaseous and can produce any substance it wants.', 'Nebula Pokemon that is very curious and fragile.', 'Story event with Lillie', 'Cosmog Line', 'Legendary,Generation 7,Psychic,Alola,Pre-Evolution', 'Unaware', 'Splash', 0.2, 0.1, FALSE, 'SM, USUM', NOW(), NOW()),

(NULL, 'Cosmoem', 790, 'Psychic', NULL, 'Legendary', 7, 'Alola', 43, 29, 131, 29, 131, 37, 400, 'cosmoem.png', 'cosmoem_shiny.png', FALSE, NULL, NULL, 'The king who ruled Alola in times of old called it the cocoon of the stars.', 'Protostar Pokemon that is hardening into its final form.', 'Evolve Cosmog at level 43', 'Cosmog Line', 'Legendary,Generation 7,Psychic,Alola,Pre-Evolution', 'Sturdy', 'Cosmic Power', 0.1, 999.9, FALSE, 'SM, USUM', NOW(), NOW()),

(NULL, 'Solgaleo', 791, 'Psychic', 'Steel', 'Legendary', 7, 'Alola', 137, 137, 107, 113, 89, 97, 680, 'solgaleo.png', 'solgaleo_shiny.png', FALSE, NULL, NULL, 'Said to live in another world, this Pokemon devours light.', 'Legendary Pokemon of the sun that opens Ultra Wormholes.', 'Evolve Cosmoem in Sun/Ultra Sun', 'Cosmog Line', 'Legendary,Generation 7,Psychic,Steel,Alola,Box Legendary', 'Full Metal Body', 'Sunsteel Strike', 3.4, 230.0, FALSE, 'S, US, SwSh Crown', NOW(), NOW()),

(NULL, 'Lunala', 792, 'Psychic', 'Ghost', 'Legendary', 7, 'Alola', 137, 113, 89, 137, 107, 97, 680, 'lunala.png', 'lunala_shiny.png', FALSE, NULL, NULL, 'Known as the Beast that Calls the Moon, it absorbs light.', 'Legendary Pokemon of the moon that opens Ultra Wormholes.', 'Evolve Cosmoem in Moon/Ultra Moon', 'Cosmog Line', 'Legendary,Generation 7,Psychic,Ghost,Alola,Box Legendary', 'Shadow Shield', 'Moongeist Beam', 4.0, 120.0, FALSE, 'M, UM, SwSh Crown', NOW(), NOW()),

(NULL, 'Necrozma', 800, 'Psychic', NULL, 'Legendary', 7, 'Alola', 97, 107, 101, 127, 89, 79, 600, 'necrozma.png', 'necrozma_shiny.png', TRUE, 'necrozma_dusk.png,necrozma_dawn.png,necrozma_ultra.png', 'Base, Dusk Mane, Dawn Wings, Ultra forms', 'Reminiscent of the Ultra Beasts, this life-form seeks light to survive.', 'Prism Pokemon that absorbs light, can fuse with Solgaleo/Lunala.', 'Ten Carat Hill post-game', 'Light Trio', 'Legendary,Generation 7,Psychic,Alola,Box Legendary,Fusion,Forms', 'Prism Armor, Neuroforce', 'Photon Geyser', 2.4, 230.0, FALSE, 'USUM, SwSh Crown', NOW(), NOW());

-- Ultra Beasts (Generation 7)

INSERT INTO pokemon VALUES 
(NULL, 'Nihilego', 793, 'Rock', 'Poison', 'Ultra Beast', 7, 'Alola', 109, 53, 47, 127, 131, 103, 570, 'nihilego.png', 'nihilego_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It appeared from an Ultra Wormhole.', 'Ultra Beast that resembles a jellyfish and possesses hosts.', 'Wela Volcano Park in USUM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Rock,Poison,Alola,UB-01', 'Beast Boost', 'Power Gem', 1.2, 55.5, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Buzzwole', 794, 'Bug', 'Fighting', 'Ultra Beast', 7, 'Alola', 107, 139, 139, 53, 53, 79, 570, 'buzzwole.png', 'buzzwole_shiny.png', FALSE, NULL, NULL, 'This Ultra Beast appeared from another world. It shows off its body.', 'Ultra Beast with massive muscles that shows off its strength.', 'Melemele Meadow in US', 'Ultra Beasts', 'Ultra Beast,Generation 7,Bug,Fighting,Alola,UB-02 Absorption', 'Beast Boost', 'Leech Life', 2.4, 333.6, FALSE, 'S, US, SwSh Crown', NOW(), NOW()),

(NULL, 'Pheromosa', 795, 'Bug', 'Fighting', 'Ultra Beast', 7, 'Alola', 71, 137, 37, 137, 37, 151, 570, 'pheromosa.png', 'pheromosa_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It refuses to touch anything dirty.', 'Ultra Beast with incredible speed and beauty that avoids dirt.', 'Verdant Cavern in UM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Bug,Fighting,Alola,UB-02 Beauty', 'Beast Boost', 'Bug Buzz', 1.8, 25.0, FALSE, 'M, UM, SwSh Crown', NOW(), NOW()),

(NULL, 'Xurkitree', 796, 'Electric', NULL, 'Ultra Beast', 7, 'Alola', 83, 89, 71, 173, 71, 83, 570, 'xurkitree.png', 'xurkitree_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It absorbs electricity and causes blackouts.', 'Ultra Beast that resembles electric wires and absorbs electricity.', 'Lush Jungle/Memorial Hill in USUM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Electric,Alola,UB-03 Lighting', 'Beast Boost', 'Thunderbolt', 3.8, 100.0, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Celesteela', 797, 'Steel', 'Flying', 'Ultra Beast', 7, 'Alola', 97, 101, 103, 107, 101, 61, 570, 'celesteela.png', 'celesteela_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It fires gas and debris to propel itself.', 'Ultra Beast that resembles a bamboo rocket, extremely heavy.', 'Malie Garden/Haina Desert in UM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Steel,Flying,Alola,UB-04 Blaster', 'Beast Boost', 'Heavy Slam', 9.2, 999.9, FALSE, 'M, UM, SwSh Crown', NOW(), NOW()),

(NULL, 'Kartana', 798, 'Grass', 'Steel', 'Ultra Beast', 7, 'Alola', 59, 181, 131, 59, 31, 109, 570, 'kartana.png', 'kartana_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It slices things with its sharp body.', 'Ultra Beast made of paper that can cut through anything.', 'Malie Garden/Route 17 in US', 'Ultra Beasts', 'Ultra Beast,Generation 7,Grass,Steel,Alola,UB-04 Blade', 'Beast Boost', 'Leaf Blade', 0.3, 0.1, FALSE, 'S, US, SwSh Crown', NOW(), NOW()),

(NULL, 'Guzzlord', 799, 'Dark', 'Dragon', 'Ultra Beast', 7, 'Alola', 223, 101, 53, 97, 53, 43, 570, 'guzzlord.png', 'guzzlord_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It consumes everything endlessly.', 'Ultra Beast with massive appetite that devours everything.', 'Resolution Cave in USUM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Dark,Dragon,Alola,UB-05 Glutton', 'Beast Boost', 'Stomping Tantrum', 5.5, 888.0, FALSE, 'SM, USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Poipole', 803, 'Poison', NULL, 'Ultra Beast', 7, 'Alola', 67, 73, 67, 73, 67, 73, 420, 'poipole.png', 'poipole_shiny.png', FALSE, NULL, NULL, 'An Ultra Beast that lives in a different world. It clings to others.', 'Ultra Beast that is very affectionate and sprays poison.', 'Given by Ultra Recon Squad', 'Ultra Beasts', 'Ultra Beast,Generation 7,Poison,Alola,UB Adhesive,Pre-Evolution', 'Beast Boost', 'Poison Jab', 0.6, 1.8, FALSE, 'USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Naganadel', 804, 'Poison', 'Dragon', 'Ultra Beast', 7, 'Alola', 73, 73, 73, 127, 73, 121, 540, 'naganadel.png', 'naganadel_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It fires poisonous needles at high speed.', 'Evolution of Poipole that fires poisonous stingers.', 'Evolve Poipole with Dragon Pulse', 'Ultra Beasts', 'Ultra Beast,Generation 7,Poison,Dragon,Alola,UB Stinger', 'Beast Boost', 'Dragon Pulse', 3.6, 150.0, FALSE, 'USUM, SwSh Crown', NOW(), NOW()),

(NULL, 'Stakataka', 805, 'Rock', 'Steel', 'Ultra Beast', 7, 'Alola', 61, 131, 211, 53, 101, 13, 570, 'stakataka.png', 'stakataka_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It was found collapsed like a stone wall.', 'Ultra Beast made of many life-forms stacked together.', 'Poni Grove in US', 'Ultra Beasts', 'Ultra Beast,Generation 7,Rock,Steel,Alola,UB Assembly', 'Beast Boost', 'Rock Slide', 5.5, 820.0, FALSE, 'US, SwSh Crown', NOW(), NOW()),

(NULL, 'Blacephalon', 806, 'Fire', 'Ghost', 'Ultra Beast', 7, 'Alola', 53, 127, 53, 151, 79, 107, 570, 'blacephalon.png', 'blacephalon_shiny.png', FALSE, NULL, NULL, 'One of the Ultra Beasts. It steals vitality by making heads explode.', 'Ultra Beast that makes its own head explode as an attack.', 'Poni Grove in UM', 'Ultra Beasts', 'Ultra Beast,Generation 7,Fire,Ghost,Alola,UB Burst', 'Beast Boost', 'Mind Blown', 1.8, 13.0, FALSE, 'UM, SwSh Crown', NOW(), NOW());

-- Mythicals (Generation 7)

INSERT INTO pokemon VALUES 
(NULL, 'Magearna', 801, 'Steel', 'Fairy', 'Mythical', 7, 'Alola', 80, 95, 115, 130, 115, 65, 600, 'magearna.png', 'magearna_shiny.png', TRUE, 'magearna_original.png', 'Regular form, Original Color form', 'Built about 500 years ago, it can sense emotions.', 'Artificial Pokemon built 500 years ago as a gift for a princess.', 'QR code event', NULL, 'Mythical,Generation 7,Steel,Fairy,Alola,Event-Exclusive,Artificial', 'Soul-Heart', 'Fleur Cannon', 1.0, 80.5, TRUE, 'SM Event, USUM', NOW(), NOW()),

(NULL, 'Marshadow', 802, 'Fighting', 'Ghost', 'Mythical', 7, 'Alola', 90, 125, 80, 90, 90, 125, 600, 'marshadow.png', 'marshadow_shiny.png', FALSE, NULL, NULL, 'It sinks into shadows of people and Pokemon, imitating their moves.', 'Gloomdweller Pokemon that hides in shadows and mimics techniques.', 'Event-exclusive', NULL, 'Mythical,Generation 7,Fighting,Ghost,Alola,Event-Exclusive', 'Technician', 'Spectral Thief', 0.7, 22.2, TRUE, 'Events', NOW(), NOW()),

(NULL, 'Zeraora', 807, 'Electric', NULL, 'Mythical', 7, 'Alola', 88, 112, 75, 102, 80, 143, 600, 'zeraora.png', 'zeraora_shiny.png', FALSE, NULL, NULL, 'It electrifies its claws and tears opponents apart.', 'Thunderclap Pokemon with incredible speed and electric claws.', 'Event-exclusive', NULL, 'Mythical,Generation 7,Electric,Alola,Event-Exclusive', 'Volt Absorb', 'Plasma Fists', 1.5, 44.5, TRUE, 'Events, USUM', NOW(), NOW()),

(NULL, 'Meltan', 808, 'Steel', NULL, 'Mythical', 7, 'Alola', 46, 65, 65, 55, 35, 34, 300, 'meltan.png', 'meltan_shiny.png', FALSE, NULL, NULL, 'It melts particles of iron and absorbs them into its body.', 'Hex Nut Pokemon made of liquid metal that eats iron.', 'Pokemon GO transfer to Let\'s Go', NULL, 'Mythical,Generation 7,Steel,Alola,Pre-Evolution', 'Magnet Pull', 'Flash Cannon', 0.2, 8.0, FALSE, 'Pokemon GO, LGPE', NOW(), NOW()),

(NULL, 'Melmetal', 809, 'Steel', NULL, 'Mythical', 7, 'Alola', 135, 143, 143, 80, 65, 34, 600, 'melmetal.png', 'melmetal_shiny.png', TRUE, 'melmetal_gmax.png', 'Regular form, Gigantamax form in SwSh', 'Centrifugal force is behind its punches, which are strong enough to shatter mountains.', 'Evolution of Meltan with incredibly powerful metal fists.', 'Evolve Meltan in Pokemon GO', NULL, 'Mythical,Generation 7,Steel,Alola,Gigantamax', 'Iron Fist', 'Double Iron Bash', 2.5, 800.0, FALSE, 'Pokemon GO, LGPE, HOME', NOW(), NOW());

-- GENERATION 8 - GALAR (12 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Zacian', 888, 'Fairy', NULL, 'Legendary', 8, 'Galar', 92, 130, 115, 80, 115, 138, 670, 'zacian.png', 'zacian_shiny.png', TRUE, 'zacian_crowned.png', 'Hero of Many Battles (Fairy), Crowned Sword (Fairy/Steel with Rusted Sword)', 'Known as a legendary hero, this Pokemon absorbs metal to power up.', 'Hero Pokemon that saved Galar with its sword in ancient times.', 'Slumbering Weald post-game', 'Hero Duo', 'Legendary,Generation 8,Fairy,Galar,Box Legendary,Forms', 'Intrepid Sword', 'Behemoth Blade', 2.8, 110.0, FALSE, 'Sw, SwSh Crown', NOW(), NOW()),

(NULL, 'Zamazenta', 889, 'Fighting', NULL, 'Legendary', 8, 'Galar', 92, 130, 115, 80, 115, 138, 670, 'zamazenta.png', 'zamazenta_shiny.png', TRUE, 'zamazenta_crowned.png', 'Hero of Many Battles (Fighting), Crowned Shield (Fighting/Steel with Rusted Shield)', 'Its ability to deflect any attack led to it being known as the Fighting Master\'s Shield.', 'Hero Pokemon that saved Galar with its shield in ancient times.', 'Slumbering Weald post-game', 'Hero Duo', 'Legendary,Generation 8,Fighting,Galar,Box Legendary,Forms', 'Dauntless Shield', 'Behemoth Bash', 2.9, 210.0, FALSE, 'Sh, SwSh Crown', NOW(), NOW()),

(NULL, 'Eternatus', 890, 'Poison', 'Dragon', 'Legendary', 8, 'Galar', 140, 85, 95, 145, 95, 130, 690, 'eternatus.png', 'eternatus_shiny.png', TRUE, 'eternatus_eternamax.png', 'Regular form, Eternamax form (uncatchable boss)', 'The core on its chest absorbs energy from the lands of the Galar region.', 'Gigantic Pokemon that crashed to Galar 20,000 years ago.', 'Energy Plant during story', NULL, 'Legendary,Generation 8,Poison,Dragon,Galar,Box Legendary,Forms', 'Pressure', 'Dynamax Cannon', 20.0, 950.0, FALSE, 'SwSh', NOW(), NOW()),

(NULL, 'Kubfu', 891, 'Fighting', NULL, 'Legendary', 8, 'Galar', 60, 90, 60, 53, 50, 72, 385, 'kubfu.png', 'kubfu_shiny.png', FALSE, NULL, NULL, 'It lived on a remote island. Training diligently made it strong.', 'Wushu Pokemon that trains constantly to become stronger.', 'Isle of Armor gift from Mustard', NULL, 'Legendary,Generation 8,Fighting,Galar,IoA,Pre-Evolution', 'Inner Focus', 'Rock Smash', 0.6, 12.0, FALSE, 'SwSh IoA', NOW(), NOW()),

(NULL, 'Urshifu Single Strike', 892, 'Fighting', 'Dark', 'Legendary', 8, 'Galar', 100, 130, 100, 63, 60, 97, 550, 'urshifu_single.png', 'urshifu_single_shiny.png', TRUE, 'urshifu_single_gmax.png', 'Regular form, Gigantamax form', 'This form is the result of training in the Tower of Darkness.', 'Evolved from Kubfu by mastering Single Strike Style.', 'Evolve Kubfu at Tower of Darkness', NULL, 'Legendary,Generation 8,Fighting,Dark,Galar,IoA,Gigantamax', 'Unseen Fist', 'Wicked Blow', 1.9, 105.0, FALSE, 'SwSh IoA', NOW(), NOW()),

(NULL, 'Urshifu Rapid Strike', 892, 'Fighting', 'Water', 'Legendary', 8, 'Galar', 100, 130, 100, 63, 60, 97, 550, 'urshifu_rapid.png', 'urshifu_rapid_shiny.png', TRUE, 'urshifu_rapid_gmax.png', 'Regular form, Gigantamax form', 'This form is the result of training in the Tower of Waters.', 'Evolved from Kubfu by mastering Rapid Strike Style.', 'Evolve Kubfu at Tower of Waters', NULL, 'Legendary,Generation 8,Fighting,Water,Galar,IoA,Gigantamax', 'Unseen Fist', 'Surging Strikes', 1.9, 105.0, FALSE, 'SwSh IoA', NOW(), NOW()),

(NULL, 'Regieleki', 894, 'Electric', NULL, 'Legendary', 8, 'Galar', 80, 100, 50, 100, 50, 200, 580, 'regieleki.png', 'regieleki_shiny.png', FALSE, NULL, NULL, 'This Pokemon is a cluster of electrical energy. It\'s said it was born from lightning.', 'Member of Legendary Titans, made of pure electricity, fastest Regi.', 'Split-Decision Ruins in Crown Tundra', 'Legendary Titans', 'Legendary,Generation 8,Electric,Galar,Crown Tundra,Golem', 'Transistor', 'Thunder Cage', 1.2, 145.0, FALSE, 'SwSh Crown', NOW(), NOW()),

(NULL, 'Regidrago', 895, 'Dragon', NULL, 'Legendary', 8, 'Galar', 200, 100, 50, 100, 50, 80, 580, 'regidrago.png', 'regidrago_shiny.png', FALSE, NULL, NULL, 'Created from crystallized dragon energy, it has more power than any other Regi.', 'Member of Legendary Titans, incomplete dragon made of dragon energy.', 'Split-Decision Ruins in Crown Tundra', 'Legendary Titans', 'Legendary,Generation 8,Dragon,Galar,Crown Tundra,Golem', 'Dragon\'s Maw', 'Dragon Energy', 2.1, 200.0, FALSE, 'SwSh Crown', NOW(), NOW()),

(NULL, 'Glastrier', 896, 'Ice', NULL, 'Legendary', 8, 'Galar', 100, 145, 130, 65, 110, 30, 580, 'glastrier.png', 'glastrier_shiny.png', FALSE, NULL, NULL, 'Glastrier emits intense cold. It has incredible physical strength.', 'Wild Horse Pokemon made of ice with immense strength.', 'Crown Tundra story choice', 'Steeds of Calyrex', 'Legendary,Generation 8,Ice,Galar,Crown Tundra,Horse', 'Chilling Neigh', 'Glacial Lance', 2.2, 800.0, FALSE, 'SwSh Crown', NOW(), NOW()),

(NULL, 'Spectrier', 897, 'Ghost', NULL, 'Legendary', 8, 'Galar', 100, 65, 60, 145, 80, 130, 580, 'spectrier.png', 'spectrier_shiny.png', FALSE, NULL, NULL, 'It probes its surroundings with its frail body made of a soul.', 'Swift Horse Pokemon made of ghostly energy with incredible speed.', 'Crown Tundra story choice', 'Steeds of Calyrex', 'Legendary,Generation 8,Ghost,Galar,Crown Tundra,Horse', 'Grim Neigh', 'Astral Barrage', 2.0, 44.5, FALSE, 'SwSh Crown', NOW(), NOW()),

(NULL, 'Calyrex', 898, 'Psychic', 'Grass', 'Legendary', 8, 'Galar', 100, 80, 80, 80, 80, 80, 500, 'calyrex.png', 'calyrex_shiny.png', TRUE, 'calyrex_ice.png,calyrex_shadow.png', 'Base form, Ice Rider (with Glastrier), Shadow Rider (with Spectrier)', 'Calyrex is a merciful Pokemon, known to heal the wounds of Pokemon and humans.', 'King of Bountiful Harvests that ruled ancient Galar.', 'Crown Tundra story', 'Calyrex Forms', 'Legendary,Generation 8,Psychic,Grass,Galar,Crown Tundra,Fusion', 'Unnerve, As One', 'Psychic', 1.1, 7.7, FALSE, 'SwSh Crown', NOW(), NOW());

-- Mythicals (Generation 8)
INSERT INTO pokemon VALUES 
(NULL, 'Zarude', 893, 'Dark', 'Grass', 'Mythical', 8, 'Galar', 105, 120, 105, 70, 95, 105, 600, 'zarude.png', 'zarude_shiny.png', TRUE, 'zarude_dada.png', 'Regular form, Dada Zarude (with scarf)', 'Within dense forests, this Pokemon lives in a pack with others.', 'Rogue Monkey Pokemon that swings through forests with vines.', 'Event-exclusive', NULL, 'Mythical,Generation 8,Dark,Grass,Galar,Event-Exclusive,Forms', 'Leaf Guard', 'Jungle Healing', 1.8, 70.0, TRUE, 'Events, SwSh', NOW(), NOW());

-- GENERATION 9 - PALDEA (7 Pokemon)

INSERT INTO pokemon VALUES 
(NULL, 'Wo-Chien', 1001, 'Dark', 'Grass', 'Legendary', 9, 'Paldea', 85, 85, 100, 95, 135, 70, 570, 'wo_chien.png', 'wo_chien_shiny.png', FALSE, NULL, NULL, 'The grudge of a person punished for writing the king\'s evil deeds became this Pokemon.', 'Ruinous Pokemon formed from grudge-filled wooden tablets.', 'Collect stakes and open shrine', 'Treasures of Ruin', 'Legendary,Generation 9,Dark,Grass,Paldea,Quartet', 'Tablets of Ruin', 'Ruination', 1.5, 74.2, FALSE, 'SV', NOW(), NOW()),

(NULL, 'Chien-Pao', 1002, 'Dark', 'Ice', 'Legendary', 9, 'Paldea', 80, 120, 80, 90, 65, 135, 570, 'chien_pao.png', 'chien_pao_shiny.png', FALSE, NULL, NULL, 'This Pokemon can control 100 tons of fallen snow with a wave of its fangs.', 'Ruinous Pokemon formed from grudge-filled broken sword.', 'Collect stakes and open shrine', 'Treasures of Ruin', 'Legendary,Generation 9,Dark,Ice,Paldea,Quartet', 'Sword of Ruin', 'Ruination', 1.9, 152.2, FALSE, 'SV', NOW(), NOW()),

(NULL, 'Ting-Lu', 1003, 'Dark', 'Ground', 'Legendary', 9, 'Paldea', 155, 110, 125, 55, 80, 45, 570, 'ting_lu.png', 'ting_lu_shiny.png', FALSE, NULL, NULL, 'The fear poured into an ancient ritual vessel awakened it. This Pokemon absorbs fear as energy.', 'Ruinous Pokemon formed from grudge-filled ancient vessel.', 'Collect stakes and open shrine', 'Treasures of Ruin', 'Legendary,Generation 9,Dark,Ground,Paldea,Quartet', 'Vessel of Ruin', 'Ruination', 2.7, 699.7, FALSE, 'SV', NOW(), NOW()),

(NULL, 'Chi-Yu', 1004, 'Dark', 'Fire', 'Legendary', 9, 'Paldea', 55, 80, 80, 145, 120, 100, 580, 'chi_yu.png', 'chi_yu_shiny.png', FALSE, NULL, NULL, 'The envy accumulated within curved beads awakened this Pokemon.', 'Ruinous Pokemon formed from grudge-filled beads of envy.', 'Collect stakes and open shrine', 'Treasures of Ruin', 'Legendary,Generation 9,Dark,Fire,Paldea,Quartet', 'Beads of Ruin', 'Ruination', 0.4, 4.9, FALSE, 'SV', NOW(), NOW()),

(NULL, 'Koraidon', 1007, 'Fighting', 'Dragon', 'Legendary', 9, 'Paldea', 100, 135, 115, 85, 100, 135, 670, 'koraidon.png', 'koraidon_shiny.png', TRUE, 'koraidon_modes.png', 'Apex Build (battle), Limited Build (rideable), other forms', 'This seems to be the Winged King mentioned in an old expedition journal.', 'Paradox Pokemon from ancient past, legendary beast of Paldea.', 'Story event', 'Paradox Duo', 'Legendary,Generation 9,Fighting,Dragon,Paldea,Box Legendary,Paradox,Forms', 'Orichalcum Pulse', 'Collision Course', 2.5, 303.0, FALSE, 'S', NOW(), NOW()),

(NULL, 'Miraidon', 1008, 'Electric', 'Dragon', 'Legendary', 9, 'Paldea', 100, 85, 100, 135, 115, 135, 670, 'miraidon.png', 'miraidon_shiny.png', TRUE, 'miraidon_modes.png', 'Ultimate Mode (battle), Low-Power Mode (rideable), other forms', 'Much remains unknown about this creature. It resembles Cyclizar but is far more savage.', 'Paradox Pokemon from distant future, legendary beast of Paldea.', 'Story event', 'Paradox Duo', 'Legendary,Generation 9,Electric,Dragon,Paldea,Box Legendary,Paradox,Forms', 'Hadron Engine', 'Electro Drift', 3.5, 240.0, FALSE, 'V', NOW(), NOW()),

(NULL, 'Terapagos', 1024, 'Normal', NULL, 'Legendary', 9, 'Paldea', 90, 65, 85, 65, 85, 60, 450, 'terapagos.png', 'terapagos_shiny.png', TRUE, 'terapagos_terastal.png,terapagos_stellar.png', 'Normal Form, Terastal Form, Stellar Form', 'An old expedition journal describes the sight of this Pokemon buried in the depths of the earth.', 'Legendary Pokemon that is source of Terastallization phenomenon.', 'Indigo Disk DLC story', NULL, 'Legendary,Generation 9,Normal,Paldea,DLC,Tera Pokemon,Forms', 'Tera Shell, Tera Shift', 'Tera Starstorm', 0.3, 6.5, FALSE, 'SV Indigo Disk', NOW(), NOW());

-- Mythicals (Generation 9)
INSERT INTO pokemon VALUES 
(NULL, 'Pecharunt', 1025, 'Poison', 'Ghost', 'Mythical', 9, 'Paldea', 88, 88, 160, 88, 88, 88, 600, 'pecharunt.png', 'pecharunt_shiny.png', FALSE, NULL, NULL, 'It feeds others toxic mochi that draw out desires and capabilities.', 'Subjugation Pokemon that controls others with poisonous mochi.', 'Mochi Mayhem event', NULL, 'Mythical,Generation 9,Poison,Ghost,Paldea,Event-Exclusive', 'Poison Puppeteer', 'Malignant Chain', 0.3, 0.3, TRUE, 'SV Mochi Mayhem', NOW(), NOW());

-- END OF DATABASE
-- Total Pokemon: ~95 (including all forms as separate entries)