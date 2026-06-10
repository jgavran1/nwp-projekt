<?php
    if(!defined('__APP__')) {
        die("Hacking attempt");
    }

    $api_key = '852e45cdc061480381f7d7f37a18aff4'; 
    
    $search_result = null;
     
    if (isset($_GET['recipe_id']) && !empty($_GET['recipe_id'])) {
        $recipe_id = (int)$_GET['recipe_id'];
        
       $url = "https://api.spoonacular.com/recipes/{$recipe_id}/information?apiKey={$api_key}";
        $cache_file = "cache_recipe_" . $recipe_id . ".json";
        if (file_exists($cache_file)) {
            $response = file_get_contents($cache_file);
        } else {
            $response = @file_get_contents($url);
        if ($response) {
            file_put_contents($cache_file, $response);
    }
}
        
        if ($response) {
            $recipe = json_decode($response, true);
            
            $price_in_usd = ($recipe['pricePerServing'] * $recipe['servings']) / 100;
            $price_in_eur = $price_in_usd * 0.92;
?>
            <div style="padding: 20px; font-family: sans-serif; max-width: 800px; margin: 0 auto; text-align: left;">
                <a href="index.php?menu=7" style="display: inline-block; margin-bottom: 20px; color: #2b358a; text-decoration: none; font-weight: bold; font-size: 16px;">← Natrag na pretraživanje slastica</a>
                
                <h2 style="color: #2b358a; margin-top: 0; font-size: 28px; border-bottom: 2px solid #2b358a; padding-bottom: 10px; text-align: left;"><?php echo $recipe['title']; ?></h2>
                
                <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
                    <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>" style="width: 100%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); object-fit: cover;">
                    
                    <div style="flex: 1; min-width: 250px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                        <p style="font-size: 16px; margin: 5px 0; color: #333;">⏱️ Vrijeme pripreme: <strong><?php echo $recipe['readyInMinutes']; ?> minuta</strong></p>
                        <p style="font-size: 16px; margin: 5px 0; color: #333;">🍽️ Broj porcija: <strong><?php echo $recipe['servings']; ?></strong></p>
                        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                        <p style="font-size: 14px; color: #555; margin-bottom: 2px;">Ukupna procjena troška sastojaka:</p>
                        <p style="font-size: 26px; font-weight: bold; color: #28a745; margin: 0;"><?php echo number_format($price_in_eur, 2, ',', '.'); ?> €</p>
                    </div>
                </div>

                <h3 style="color: #2b358a; border-bottom: 1px solid #eee; padding-bottom: 5px; text-align: left;">Sastojci:</h3>
                <div style="background: #2b358a; border: 1px solid #2b358a; border-radius: 8px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <ul style="line-height: 1.8; font-size: 16px; margin: 0; padding-left: 20px; list-style-type: disc; color: #ffffff !important;">
                        <?php foreach ($recipe['extendedIngredients'] as $ingredient): ?>
                            <li style="color: #ffffff !important; text-align: left;"><?php echo htmlspecialchars($ingredient['original']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <h3 style="color: #2b358a; border-bottom: 1px solid #eee; padding-bottom: 5px; text-align: left;">Upute za pripremu:</h3>
                <div style="line-height: 1.8; font-size: 16px; text-align: justify; background: #ffffff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <?php 
                    if (!empty($recipe['analyzedInstructions'])) {
                        echo "<ol style='padding-left: 20px; margin: 0;'>";
                        foreach ($recipe['analyzedInstructions'][0]['steps'] as $step) {
                            echo "<li style='margin-bottom: 10px; color: #333333 !important; text-align: left;'>" . htmlspecialchars($step['step']) . "</li>";
                        }
                        echo "</ol>";
                    } else if (!empty($recipe['instructions'])) {
                        echo "<div style='color: #333333 !important; text-align: left;'>" . $recipe['instructions'] . "</div>"; 
                    } else {
                        echo "<p style='color: #333333; margin: 0;'>Upute trenutno nisu dostupne za ovaj recept.</p>";
                    }
                    ?>
                </div>
            </div>
<?php
        } else {
            echo "<p style='color:red; text-align:center; font-weight:bold; margin-top:30px;'>Došlo je do pogreške prilikom dohvaćanja detalja recepta.</p>";
        }
    } 
    else {
        if (isset($_POST['search_query']) && !empty($_POST['search_query'])) {
            $original_query = mb_strtolower(trim($_POST['search_query']), 'UTF-8');
            
            $dictionary = [
                'čokolada' => 'chocolate', 'cokolada' => 'chocolate', 'čokoladni' => 'chocolate', 'čokoladna' => 'chocolate',
                'palačinke' => 'pancake', 'palacinke' => 'pancake', 'palačinka' => 'pancake',
                'limun' => 'lemon', 'limunski' => 'lemon',
                'jabuka' => 'apple', 'jabuke' => 'apple', 'jabučni' => 'apple',
                'keksi' => 'cookie', 'keks' => 'cookie', 'keksići' => 'cookie',
                'torta' => 'cake', 'torte' => 'cake', 'kolač' => 'cake', 'kolac' => 'cake', 'kolači' => 'cake',
                'jagoda' => 'strawberry', 'jagode' => 'strawberry',
                'sladoled' => 'ice cream', 'banana' => 'banana', 'banane' => 'banana', 'vanilija' => 'vanilla',
                'malina' => 'raspberry', 'maline' => 'raspberry', 'borovnica' => 'blueberry', 'borovnice' => 'blueberry',
                'naranča' => 'orange', 'naranca' => 'orange', 'sir' => 'cheese', 'cheesecake' => 'cheesecake',
                'muffin' => 'muffin', 'muffini' => 'muffin', 'vafli' => 'waffle', 'vafl' => 'waffle',
                'mrkva' => 'carrot', 'mrkve' => 'carrot', 'orah' => 'walnut', 'orasi' => 'walnut',
                'lješnjak' => 'hazelnut', 'ljesnjak' => 'hazelnut', 'badem' => 'almond', 'bademi' => 'almond',
                'med' => 'honey', 'mlijeko' => 'milk', 'kava' => 'coffee', 'tiramisu' => 'tiramisu',
                'puding' => 'pudding', 'krafne' => 'donut', 'krafna' => 'donut', 'slatko' => 'sweet'
            ];

            $translated_query = $original_query;
            foreach ($dictionary as $hr => $en) {
                $translated_query = preg_replace('/\b' . preg_quote($hr, '/') . '\b/u', $en, $translated_query);
            }
            
            $search_query = urlencode($translated_query);
            
            $url = "https://api.spoonacular.com/recipes/complexSearch?query={$search_query}&type=dessert&addRecipeInformation=true&fillIngredients=true&apiKey={$api_key}&number=21";
            
            $response = @file_get_contents($url);
            if ($response) {
                $search_result = json_decode($response, true);
            }
        }
?>
        <div style="padding: 20px; font-family: sans-serif; max-width: 900px; margin: 0 auto;">
            <h2 style="color: #2b358a; border-bottom: 2px solid #2b358a; padding-bottom: 10px;">Pretraži kulinarske ideje (Spoonacular API)</h2>
            <p>Upišite sastojak ili naziv deserta (npr. <em>chocolate, pancake, lemon, apple, cookies, cake</em>)...</p>
            
            <form action="index.php?menu=7" method="POST" style="margin-bottom: 30px; display: flex; gap: 10px;">
                <input type="text" name="search_query" placeholder="Npr. Čokoladna torta..." required 
                       value="<?php echo isset($_POST['search_query']) ? htmlspecialchars($_POST['search_query']) : ''; ?>"
                       style="flex: 1; padding: 12px; border: 2px solid #2b358a; border-radius: 4px; font-size: 16px;">
                <input type="submit" value="Pretraži" 
                       style="background: #2b358a; color: white; padding: 12px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
            </form>

            <?php if ($search_result && isset($search_result['results']) && !empty($search_result['results'])): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <?php foreach ($search_result['results'] as $recipe): 
                        $price_in_usd = ($recipe['pricePerServing'] * $recipe['servings']) / 100;
                        $price_in_eur = $price_in_usd * 0.92; 
                    ?>
                        <div style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                            <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>" style="width: 100%; height: 200px; object-fit: cover;">
                            
                            <div style="padding: 15px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h3 style="margin-top: 0; color: #333; font-size: 18px; min-height: 44px; text-align: left;"><?php echo $recipe['title']; ?></h3>
                                    <p style="font-size: 14px; color: #666; margin-bottom: 5px; text-align: left;">⏱️ Priprema: <strong><?php echo $recipe['readyInMinutes']; ?> min</strong></p>
                                    <p style="font-size: 14px; color: #666; margin-bottom: 5px; text-align: left;">🍽️ Porcija: <strong><?php echo $recipe['servings']; ?></strong></p>
                                    <p style="font-size: 14px; color: #28a745; margin-bottom: 5px; text-align: left;">💰 Trošak namirnica: <strong><?php echo number_format($price_in_eur, 2, ',', '.'); ?> €</strong></p>
                                </div>
                                
                                <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
                                    <a href="index.php?menu=7&recipe_id=<?php echo $recipe['id']; ?>" 
                                       style="display: block; text-align: center; background: #2b358a; color: white; padding: 10px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px;">
                                       Pogledaj recept
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif (isset($_POST['search_query'])): ?>
                <p style="font-weight: bold; color: #666; text-align: center; margin-top: 20px;">Nije pronađen nijedan desert za uneseni pojam. Pokušajte s drugom riječi.</p>
            <?php endif; ?>
        </div>
<?php 
    } 
?>