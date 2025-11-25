<?php
// filter.php - Reusable filter component for search functionality
// Located in: html/includes/filter.php
?>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-funnel-fill"></i> Filter Pokemon</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= isset($filterAction) ? $filterAction : 'search.php' ?>">
            <div class="row g-3">
                <!-- Search by Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           placeholder="Search by name..." 
                           value="<?= isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>">
                </div>
                
                <!-- Filter by Type -->
                <div class="col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="Normal">Normal</option>
                        <option value="Fire">Fire</option>
                        <option value="Water">Water</option>
                        <option value="Electric">Electric</option>
                        <option value="Grass">Grass</option>
                        <option value="Ice">Ice</option>
                        <option value="Fighting">Fighting</option>
                        <option value="Poison">Poison</option>
                        <option value="Ground">Ground</option>
                        <option value="Flying">Flying</option>
                        <option value="Psychic">Psychic</option>
                        <option value="Bug">Bug</option>
                        <option value="Rock">Rock</option>
                        <option value="Ghost">Ghost</option>
                        <option value="Dragon">Dragon</option>
                        <option value="Dark">Dark</option>
                        <option value="Steel">Steel</option>
                        <option value="Fairy">Fairy</option>
                    </select>
                </div>
                
                <!-- Filter by Generation -->
                <div class="col-md-4">
                    <label for="generation" class="form-label">Generation</label>
                    <select class="form-select" id="generation" name="generation">
                        <option value="">All Generations</option>
                        <option value="1">Gen 1 (Kanto)</option>
                        <option value="2">Gen 2 (Johto)</option>
                        <option value="3">Gen 3 (Hoenn)</option>
                        <option value="4">Gen 4 (Sinnoh)</option>
                        <option value="5">Gen 5 (Unova)</option>
                        <option value="6">Gen 6 (Kalos)</option>
                        <option value="7">Gen 7 (Alola)</option>
                        <option value="8">Gen 8 (Galar)</option>
                        <option value="9">Gen 9 (Paldea)</option>
                    </select>
                </div>
                
                <!-- Filter by Classification -->
                <div class="col-md-4">
                    <label for="classification" class="form-label">Classification</label>
                    <select class="form-select" id="classification" name="classification">
                        <option value="">All</option>
                        <option value="Legendary">Legendary</option>
                        <option value="Mythical">Mythical</option>
                        <option value="Ultra Beast">Ultra Beast</option>
                    </select>
                </div>
                
                <!-- Filter by Legendary Group -->
                <div class="col-md-4">
                    <label for="group" class="form-label">Legendary Group</label>
                    <select class="form-select" id="group" name="group">
                        <option value="">All Groups</option>
                        <option value="Legendary Birds">Legendary Birds</option>
                        <option value="Legendary Beasts">Legendary Beasts</option>
                        <option value="Weather Trio">Weather Trio</option>
                        <option value="Creation Trio">Creation Trio</option>
                        <option value="Lake Guardians">Lake Guardians</option>
                        <option value="Swords of Justice">Swords of Justice</option>
                        <option value="Forces of Nature">Forces of Nature</option>
                        <option value="Aura Trio">Aura Trio</option>
                        <option value="Guardian Deities">Guardian Deities</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
                <a href="<?= isset($filterAction) ? $filterAction : 'search.php' ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>
