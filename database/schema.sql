SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) NOT NULL UNIQUE,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  slug VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recipes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  category_id INT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  summary VARCHAR(300) NOT NULL,
  instructions TEXT NOT NULL,
  prep_minutes SMALLINT UNSIGNED NOT NULL,
  servings TINYINT UNSIGNED NOT NULL DEFAULT 2,
  difficulty ENUM('Easy Peasy', 'Gemiddeld', 'Chef-ish') NOT NULL DEFAULT 'Easy Peasy',
  image_path VARCHAR(255) NOT NULL DEFAULT 'assets/geen-foto.svg',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_recipe_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_recipe_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recipe_ingredients (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  recipe_id INT UNSIGNED NOT NULL,
  ingredient_line VARCHAR(200) NOT NULL,
  position TINYINT UNSIGNED NOT NULL,
  CONSTRAINT fk_ingredient_recipe FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
  UNIQUE KEY uq_recipe_ingredient_position (recipe_id, position),
  INDEX idx_ingredient_line (ingredient_line)
) ENGINE=InnoDB;

INSERT IGNORE INTO categories (id, name, slug) VALUES
  (1, 'Ontbijt', 'ontbijt'),
  (2, 'Lunch', 'lunch'),
  (3, 'Diner', 'diner'),
  (4, 'Snacks', 'snacks'),
  (5, 'Vegan', 'vegan'),
  (6, 'Budget', 'budget'),
  (7, 'Snel klaar', 'snel-klaar'),
  (8, 'Gezond', 'gezond'),
  (9, 'Voorgerecht', 'voorgerecht'),
  (10, 'Hoofdgerecht', 'hoofdgerecht'),
  (11, 'Nagerecht', 'nagerecht');

INSERT IGNORE INTO recipes
  (id, user_id, category_id, title, summary, instructions, prep_minutes, servings, difficulty, image_path, created_at)
VALUES
  (1, NULL, 3, 'Creamy Burrata Tomato Pasta', 'De ultieme lazy Sunday comfort food voor een betaalbare dinner.',
   'Kook de pasta volgens de verpakking.\nBak de tomaten en knoflook met een scheutje olie.\nMeng de pasta met de saus en leg de burrata erop.\nWerk af met basilicum en peper.',
   20, 2, 'Easy Peasy', 'assets/pasta.jpg', '2026-10-05 12:00:00'),
  (2, NULL, 2, 'Smashed Taco Tortilla’s met extra kaas', 'Knapperig, snel en precies wat je nodig hebt na een drukke dag.',
   'Bak de vulling in een pan.\nVul de tortilla’s en voeg kaas toe.\nBak beide kanten goudbruin.\nServeer met je favoriete saus.',
   15, 2, 'Easy Peasy', 'assets/tacos.png', '2026-10-09 12:00:00'),
  (3, NULL, 1, 'Wolkige Soufflé Pancakes', 'Een zacht ontbijt waar je ochtend meteen beter van wordt.',
   'Splits de eieren en klop het eiwit luchtig.\nMeng de overige ingrediënten.\nSpatel het eiwit er voorzichtig door.\nBak kleine pancakes op laag vuur.',
   20, 2, 'Chef-ish', 'assets/pancakes.jpg', '2026-10-07 12:00:00'),
  (4, NULL, 3, '10-Min Pindakaas Noodles', 'Pittige noodles met een romige pindasaus.',
   'Kook de noodles.\nMeng pindakaas, sojasaus en wat kookwater.\nRoer de noodles door de saus.\nMaak af met groenten en chili.',
   10, 2, 'Easy Peasy', 'assets/noodles.png', '2026-10-08 12:00:00'),
  (5, NULL, 5, 'Vegan Chickpea Bowl', 'Rijst met geroosterde kikkererwten, frisse groenten en een plantaardige yoghurtsaus.',
   'Kook de rijst volgens de verpakking.\nSpoel de kikkererwten af en bak ze met paprikapoeder in olijfolie tot ze knapperig zijn.\nSnijd de komkommer, tomaten en rode ui.\nRoer de sojayoghurt los met citroensap en verse kruiden.\nVerdeel de rijst over twee kommen en leg de kikkererwten, groenten en saus erop.',
   25, 2, 'Easy Peasy', 'assets/bowl.jpg', '2026-10-06 12:00:00'),
  (6, NULL, 10, 'Shakshuka uit één pan', 'Eieren gegaard in een pittige tomatensaus. Eén pan, weinig afwas.',
   'Fruit de ui en paprika vijf minuten in een pan met olie.\nVoeg de komijn en de tomatenblokjes toe en laat tien minuten pruttelen.\nMaak vier kuiltjes in de saus en breek in elk kuiltje een ei.\nDoe de deksel op de pan en laat de eieren in zes minuten stollen.\nKruimel de feta erover en eet het met brood.',
   25, 2, 'Gemiddeld', 'assets/eggs.jpg', '2026-10-04 12:00:00'),
  (7, NULL, 9, 'Tomaat-komkommersalade met feta', 'Frisse blokjes tomaat en komkommer met feta, klaar terwijl je pasta kookt.',
   'Snijd de tomaten en de komkommer in blokjes.
Snijd de rode ui heel fijn.
Meng alles in een kom met de olijfolie.
Kruimel de feta erover.
Maak op smaak met zout en versgemalen peper.',
   10, 2, 'Easy Peasy', 'assets/salade.jpg', '2026-10-03 12:00:00'),
  (8, NULL, 11, 'Yoghurt met rood fruit en honing', 'Zoet, fris en zonder fornuis.',
   'Schep de yoghurt in twee kommen.
Was het fruit en snijd de aardbeien doormidden.
Leg het fruit op de yoghurt.
Schenk de honing eroverheen.',
   5, 2, 'Easy Peasy', 'assets/yoghurt-fruit.jpg', '2026-10-02 12:00:00'),
  (9, NULL, 4, 'Hummus met groentesticks', 'Romige hummus uit de blender met knapperige groenten om te dippen.',
   'Spoel de kikkererwten af en laat ze uitlekken.
Doe de kikkererwten, tahin, knoflook, citroensap en olijfolie in een blender.
Mix tot een gladde hummus en voeg wat water toe als hij te dik is.
Snijd de paprika, wortel en komkommer in reepjes.
Serveer de hummus met de groentesticks.',
   15, 4, 'Easy Peasy', 'assets/hummus.jpg', '2026-10-01 12:00:00'),
  (10, NULL, 6, 'Gebakken rijst met ei', 'Rijst van gisteren wordt in tien minuten een volle maaltijd voor weinig geld.',
   'Klop de eieren los met een snufje zout.
Verhit olie in een wok of grote pan en roerbak de eieren kort; schep ze eruit.
Bak de lente-ui en de doperwten twee minuten.
Voeg de koude rijst toe en bak tot hij warm en los is.
Roer de eieren en de sojasaus erdoor.',
   15, 2, 'Easy Peasy', 'assets/gebakken-rijst.jpg', '2026-09-30 12:00:00'),
  (11, NULL, 7, 'Tosti met kaas', 'Goudbruin en knapperig, in vijf minuten klaar.',
   'Besmeer de buitenkant van de boterhammen dun met boter.
Leg de kaas tussen twee boterhammen met de boterkant naar buiten.
Bak de tosti in een koekenpan op middelhoog vuur, twee tot drie minuten per kant.
Snijd hem in repen en eet hem warm.',
   5, 1, 'Easy Peasy', 'assets/tosti.jpg', '2026-09-29 12:00:00'),
  (12, NULL, 8, 'Overnight oats met mango en kiwi', 'Maak het voor het slapengaan, eet het morgen meteen.',
   'Meng de havermout met de melk en de yoghurt in een pot of kom.
Zet het een nacht in de koelkast.
Snijd de mango en de kiwi in stukjes.
Schep het fruit erop en eet het koud.',
   5, 1, 'Easy Peasy', 'assets/overnight-oats.jpg', '2026-09-28 12:00:00');

INSERT IGNORE INTO recipe_ingredients (recipe_id, ingredient_line, position) VALUES
  (1, '200 g rigatoni pasta', 1), (1, '1 blikje tomatenblokjes', 2),
  (1, '1 teentje knoflook', 3), (1, '1 bol burrata', 4), (1, 'Verse basilicum', 5),
  (2, '4 tortilla’s', 1), (2, '150 g vegetarisch gehakt of kip', 2),
  (2, 'Geraspte kaas', 3), (2, 'Taco kruiden', 4),
  (3, '2 eieren', 1), (3, '50 g bloem', 2), (3, '2 el melk', 3),
  (4, '200 g noodles', 1), (4, '2 el pindakaas', 2),
  (4, '1 el sojasaus', 3), (4, 'Groenten naar keuze', 4),
  (5, '150 g rijst', 1), (5, '1 blik kikkererwten', 2), (5, '1 tl paprikapoeder', 3),
  (5, 'Halve komkommer', 4), (5, '2 tomaten', 5), (5, 'Halve rode ui', 6),
  (5, '4 el sojayoghurt', 7), (5, 'Sap van halve citroen', 8), (5, 'Verse kruiden', 9),
  (6, '4 eieren', 1), (6, '1 blik tomatenblokjes', 2), (6, '1 ui', 3),
  (6, '1 rode paprika', 4), (6, '1 tl komijn', 5), (6, 'Feta naar smaak', 6),
  (7, '2 tomaten', 1), (7, 'Halve komkommer', 2), (7, 'Halve rode ui', 3),
  (7, '1 el olijfolie', 4), (7, '50 g feta', 5), (7, 'Zout en versgemalen peper', 6),
  (8, '200 g Griekse yoghurt', 1), (8, '100 g frambozen', 2), (8, '100 g aardbeien', 3),
  (8, 'Handje bramen en blauwe bessen', 4), (8, '1 el honing', 5),
  (9, '1 blik kikkererwten', 1), (9, '2 el tahin', 2), (9, '1 teentje knoflook', 3),
  (9, 'Sap van halve citroen', 4), (9, '2 el olijfolie', 5), (9, '1 paprika', 6),
  (9, '2 wortels', 7), (9, 'Halve komkommer', 8),
  (10, '250 g gekookte rijst van gisteren', 1), (10, '2 eieren', 2), (10, '2 lente-uitjes', 3),
  (10, '100 g diepvries doperwten', 4), (10, '1 el sojasaus', 5), (10, '1 el olie', 6),
  (11, '2 boterhammen', 1), (11, '2 plakken kaas', 2), (11, 'Beetje boter', 3),
  (12, '50 g havermout', 1), (12, '100 ml melk', 2), (12, '2 el yoghurt', 3),
  (12, 'Halve mango', 4), (12, '1 kiwi', 5);
