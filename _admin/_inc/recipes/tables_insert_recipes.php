<?php
 mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Proteinpannekaker', 2, 'no', 'Pannekaker med proteinpulver, egg og melk.', '1. Bland det tÃ¸rre. Ha i egg. RÃ¸r til slutt inn melk.\n\n2. La det stÃ¥ Ã¥ svelle en liten time i kjÃ¸leskapet.\n\n3. Stek smÃ¥ pannekaker.\n\nServeres med syltetÃ¸y og cottage cheese.', '_uploads/recipes/_image_uploads/2/2/2017', '1.png', '1-thumb.png', '', '2017-11-12', '19:27:00', '0', '0', '0', '0', '1', '', '', '', 'ef65dae3be4a4f6301ce38ce6083d7ea3459a17a')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Cherry oat bars', 5, 'en', 'Taste just like the ones from Starbucks! Feel free to replace sugar with sugar free options.', '1. Preheat oven to 350Â°F.\n2. Line a 9x9 pan with parchment paper and lighty grease it. If you want a thinner crust use a 9x13 pan.\n3. Make the cherry filling by combining cherries, corn starch and sugar in a pot. Cook over medium heat for 10 minutes, stir frequently.\n4. Combine all crust ingredients in a large bowl until it becomes soft and crumbly, feel free to use hands mixing it.\n5. Pat 2/3rd of the crust into the pan.\n6. Cover the crust with the cherry filling using a slotted spoon. Careful to not use too much of the liquid to avoid the crust being wet.\n7. Crumble the rest of the crust mixture over the cherries.\n8. Bake for 30 minutes. Let cool before cutting into 12 bars, enjoy!', '_uploads/recipes/_image_uploads/5/3/2017', '2.png', '2-thumb.png', '', '2017-11-12', '18:23:03', '0', '0', '0', '0', '11', '', '', '', '34ec1525bedf1de1dd45597f75f489841b79fde0')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Fresh spring rolls', 3, 'en', 'Makes two rolls. Served with soy or peanut butter sauce. You can also include meats like shrimp or turkey in your rolls.', '1. Cut the vegetables in slices and set aside. You can use bagged coleslaw instead of cutting the cabbage and carrots.\n2. Fill a large bowl with warm water. \n3. Gradually dip the rice paper into the water until completely soft.\n4. Place the soft rice wrapper onto a work surface like a plastic cutting board.\n5. Fill the rolls with vegetables but do not overstuff them.\n6. Roll them tightly the same way you would roll a burrito. You can fold in the sides of the rice papers for a prettier look. \n7. Cut in half and serve with peanut sauce. To store them wrap each roll in plastic wrap to prevent sticking', '_uploads/recipes/_image_uploads/3/3/2017', '3.png', '3-thumb.png', '', '2017-12-10', '12:29:00', '0', '0', '0', '0', '2', '', '', '', '10f9d26649b7610da827ccea232d5bab4f63b536')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Lettuce wrap burger', 2, 'en', 'Cut the calories but not the flavor by switching out the regular burger bun with a lettuce wrap.', '1. In a bowl mix the ground beef, garlic and spices. It is best if you let this mixture be in the fridge for 2-4 hours but this step can be skipped.\n2. Form the mixture into a half inch patty. \n3. Lighlty grease the patty with cooking spray and grill or pan fry 6 minutes each side.\n4. Cook the mushroom in the same pan during the last 4-5 minutes of cook time.\n5. During the last 3 minutes put the cheese over the patty and let melt.\n6. Serve the patty ontop of a lettuce leaf and top with your favorite burger accessories!', '_uploads/recipes/_image_uploads/2/3/2017', '4.png', '4-thumb.png', '', '2017-11-12', '18:23:00', '0', '0', '0', '0', '2', '', '', '', '46ab34e632d3eb58b930ceb54dd3a35b1bc9bbed')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Protein banana bread', 4, 'en', 'I use Optimum Nutrition vanilla protein powder and Kodiak pancake mix as flour but any other brands will work instead.', '1. Preheat oven to 350Â°F.\n2. Line a bread pan with parchment paper.\n3. Combine the dry ingredients in a bowl and mix in the wet ones.\n4. Pour batter into pan.\n5. Bake for 45-50 minutes or until done. Let cool before cutting it in ten slices.', '_uploads/recipes/_image_uploads/4/3/2017', '5.png', '5-thumb.png', '', '2017-11-12', '19:26:00', '0', '0', '0', '0', '2', '', '', '', '8cfd7354810181fedf1767461edc743dc76cc6a6')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Wok med friske grønnsaker', 2, 'no', 'Denne tar litt lengre tid å lage, men er verd det.', '1. Sett p&aring; ris.\n\n2. Stek kyllingen.\n\n3. Ta bort kyllingen. Stek l?k, brokkoli og gulrot. Ha i resten av gr?nnsakene.\n\n4. Ha i kyllingen og ta over wok saus.\n\nServeres med kikoman saus.', '_uploads/recipes/_image_uploads/2/2/2017', '6.png', '6-thumb.png', '', '2017-12-10', '11:59:00', '0', '0', '0', '0', '1', '', '', '', '1cb630917e23af4e86c83d99bb825f65b29c6bb5')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Tomato soup', 2, 'en', 'Quick and low calories', '1. Heat the olive oil in a pot, add chopped onion and sautÃ¨ until golden, approx 4 minutes. \n2. Add garlic and let cook another minute.\n3. Add tomatoes, broth and spices and bring to a boil while stirring frequently.\n4. Reduce heat and let simmer for 10 minutes.\n5. Use an immersion blender or blender to puree the soup and serve, add pepper to taste. If you like thinner soup add more broth.\n\nTop with cheese, fresh basil or green onions.', '_uploads/recipes/_image_uploads/2/3/2017', '7.png', '7-thumb.png', '', '2017-12-10', '09:59:00', '0', '0', '0', '0', '3', '', '', '', '2fc0a8b0bc3a2bfd9f73f39a27db1711e3c65be7')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Tomato soup II', 2, 'en', 'Apple cider vinegar gives this tomato soup great flavor', '1. Heat the oil in a pot and sautÃ¨ the onions until golden, approx 4 minutes.\n2. Add garlic and cook another minute.\n3. Add the tomatoes with the juices, spices and apple cider vinegar. Bring to a boil.\n4. Add the almond milk and broth and let simmer for 10 minutes. \n5. Use a immersion blender or a regular blender (that can be used with hot liquids) and puree the soup until smooth. Ready to serve, add pepper to taste.', '_uploads/recipes/_image_uploads/2/3/2017', '8.png', '8-thumb.png', '', '2017-12-10', '16:49:00', '0', '0', '0', '0', '3', '', '', '', '4558254b1771ec82f3f31509f3c609ca6dbb9c26')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Baked tilapia loins', 2, 'en', '23 grams protein. I like to use Kirklands defrosted tilapia.', '1. Preheat oven to 425Â°F.\n2. Place tilapia in a aluminum foil sheet and sprinkle over spices. You can also add a teaspoon butter or oil if you want a creamy flavor.\n3. Cover tilapia and bake for 10 minutes.\n4. Uncover and bake for another 5-8 or til the fish is easy to flake.', '_uploads/recipes/_image_uploads/2/3/2017', '9.png', '9-thumb.png', '', '2017-12-10', '11:06:00', '0', '0', '0', '0', '1', '', '', '', '932690381a9cc49cb7c2eb66b926cad0691d002b')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Kyllingfilet med grønnsaker og ris', 2, 'no', 'Kylling er sundt og god middag.', '1. Sett p&aring; ovenen p&aring; 200 grader. Legg kyllingfilet i en form og ha p&aring; krydder. Sett formen midt i ovnen. Kyllingfileten skal steke i 40 min.\n\n2. Sett p&aring; vann til gr?nnsakene og risen. Gr?nnsakene skal bare ha et lite oppkok, mens risen skal koke i 20 min.', '_uploads/recipes/_image_uploads/2/2/2017', '10.png', '10-thumb.png', '', '2017-12-10', '11:48:00', '0', '0', '0', '0', '1', '', '', '', 'baf555d9952c3f1d7197a0bad0c046ff3db33698')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Kveite med gresk salat', 2, 'no', 'Kveita har 16 g protein og 10 g fett pr 100 g', '1. Sett p&aring; oven p&aring; 200 grader. Sett p&aring; ris. \n\n2. Stek kveite i en stekepanne i 3 min pr side. Legg den i en form i ovnen. La den steke i oven i 15 min.\n\n3. Lag gresk salat av gr?nnsakene, utenom sitronen.\n\n4. Ha sitron over kveita, og server!\n\nRisen kan byttes ut med koskos.\n\n', '_uploads/recipes/_image_uploads/2/2/2017', '11.png', '11-thumb.png', '', '2017-12-10', '12:23:00', '6', '0', '0', '0', '1', '', '', '', '56b016da3294c5ecf8cb706ea0b7279c88fb8325')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Havregryn, koksmelk og blåbærsyltetøy', 1, 'no', 'Frokost rik på fiber.', '1. Bland sammen havregryn og koksmelk. Server med syltet?y.', '_uploads/recipes/_image_uploads/1/2/2017', '12.png', '12-thumb.png', '', '2017-12-10', '12:23:00', '0', '0', '0', '0', '2', '', '', '', '9663a7ed8212519d8e6b9e3c187e72094285c291')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Turkey meatballs, no breadcrumbs', 2, 'en', 'The veggies add volume to the meatballs. Low calorie, tasty and 26 gram protein!', '1. Preheat oven to 375Â°F.\n2. Combine all the ingredients in a bowl.\n3. Divide mixture in five and roll each part into a ball.\n4. Bake in preheated oven for 20-25 minutes.\n5. Serve over a salad or pasta.\n', '_uploads/recipes/_image_uploads/2/3/2017', '13.png', '13-thumb.png', '', '2017-12-10', '16:49:00', '0', '0', '0', '0', '2', '', '', '', 'f2bf6561a20c7f5078fa9d090730800752440f7')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Garlic and lemon butter shrimp with fettuccine', 2, 'en', 'Great low calorie option for a shrimp scampi craving! Feel free to omit butter or add more shrimp.', '1. Rinse the noodles, place on a microwave safe plate and microwave for two minutes.\n2. Spray a pan with non stick and sautÃ¨ the garlic and onions. \n3. Add the shrimp, either cut up or whole. I prefer to cut mine in three. Cook until opaque, about 2 minutes.\n4. Add the diced tomatoes, squeezed lemon juice and noodles. Cook until the tomatoes are hot and shrimp is done. \n5. Add butter and let it melt.\n6. Serve and top with the grated parmesan. \n', '_uploads/recipes/_image_uploads/2/3/2017', '14.png', '14-thumb.png', '', '2017-12-10', '17:07:00', '0', '0', '0', '0', '2', '', '', '', '4e21a986e82c805d2496a3bd95978e39b94db05b')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Greek yogurt bark', 4, 'en', '23 gram of protein using fage 0 fat Greek yogurt. Great for breakfast or an anytime snack', '1. In a bowl mix the yogurt, vanilla and stevia.\n2. Spread the yogurt mix into a 9x9 inch parchment paper covered freezer safe dish.\n3. Top with diced strawberry and grated chocolate.\n4. Freeze for at least 3 hours. Let melt 10 minutes before breaking into pieces to serve. \n\nGet creative, switch out strawberries with goji berries or blueberries! Top with coconut flakes instead of chocolate, or perhaps both! ;)', '_uploads/recipes/_image_uploads/4/3/2017', '15.png', '15-thumb.png', '', '2017-12-10', '12:30:00', '0', '0', '0', '0', '2', '', '', '', 'c72769d99b5eebd784837fa2b7f0c64db27f9e12')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Broccoli soup ala Gordon Ramsay', 2, 'en', 'Simple, delicious and low calorie. Serve with a grilled cheese sandwich.', '1. Boil water and salt.\n2. Add broccoli and boil rapidly under a lid for 8 minutes.\n3. Using a slotted spoon add the broccoli to a blender that tolerate heat. \n4. Pour the same water that you boiled the broccoli into the blender. Stop when you reach the halfway point of the broccoli.\n5. Pulse the blender then use the puree function.\n6. Add salt and pepper to taste, serve.', '_uploads/recipes/_image_uploads/2/3/2017', '16.png', '16-thumb.png', '', '2017-12-10', '15:44:00', '0', '0', '0', '0', '1', '', '', '', 'd02d5b6408d312826e6e894363627aba1eed3dc8')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Ramen', 2, 'en', 'Switching regular noodles with shirataki noodles saves a lot of calories.', '1. Bring a small pot with water to boil. Add the egg and let boil for 6-7 min. \n2. Rinse the noodles, drain and place on a microwave safe plate. Microwave for 2 minutes.\n3. Make the broth by mixing chicken stock, garlic and soy sauce. Bring to a boil. \n4. Add all the other ingredients to the broth and let simmer until they become hot.\n4. Serve in a large bowl with the egg cut in half.', '_uploads/recipes/_image_uploads/2/3/2017', '17.png', '17-thumb.png', '', '2017-12-10', '10:59:00', '0', '0', '0', '0', '2', '', '', '', 'a8194f59ff0b2b172933d1b1c8c97c3c6915b61e')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Lemon oven baked flounder', 2, 'en', 'Goes great with a simple green salad', '1. Preheat oven to 400Â°F.\n2. Make the lemon glaze in a small bowl.\n3. Place the fish in an oven safe dish and spread the glaze over the fish. \n4. Bake 10 minutes or to fish easily flakes with a fork.', '_uploads/recipes/_image_uploads/2/3/2017', '18.png', '18-thumb.png', '', '2017-12-10', '10:59:00', '0', '0', '0', '0', '2', '', '', '', '7d679d8897ff28a71ae4a6cd659131006a9b2cd8')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Ground turkey skillet', 2, 'en', 'Great served over cauliflower rice or by itself.', '1. Cook the ground turkey in a pan.\n2. Add the onions and cook until translucent.\n3. Add diced tomatoes, jalapeno and spinach. Let cook until the spinach shrinks and the tomato are saucy and hot. \n4. Serve, squeeze the lime over and garnish with the green onions and cilantro. \n\nGoes well with a dash salsa ontop! \n', '_uploads/recipes/_image_uploads/2/3/2017', '20.png', '20-thumb.png', '', '2017-12-10', '10:30:00', '0', '0', '0', '0', '3', '', '', '', '87e0495516955486dd0d7cb9d46de3fdbff4d0f2')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Salat med egg og reker', 3, 'no', 'En veldig sund og proteinrik lunsj.', '1. Sett ovnen p&aring; 200 grader til rundstykker. Sett p&aring; vann til eggene.\n\n2. Stek rundstykker p&aring; 200 grader i 12 min. Eggene skal koke i 9 1/2 min.\n\n3. Ha babyleaf, tomat og agurk i en tallerken. Ha i reker og egg.\n\nServer med rundstykke.', '_uploads/recipes/_image_uploads/3/2/2017', '21.png', '21-thumb.png', '', '2017-12-10', '11:32:00', '0', '0', '0', '0', '1', '', '', '', 'abc6a733d07d00b3e7359ca8ec63d88c2f4544e5')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Fish Gratin', 2, 'en', 'One of the most popular dishes in Norway. I made mine using flounder but any white fish will work.', '1. Boil the elbow pasta according to the package.\n2. Chop the onion and carrots.\n3. Boil water in a saucepan.\n4. Add fish, and vegetables to the water and bring to a boil. Once it is boiling, turn of the heat and let it rest for 5 minutes. \n5. Carefully remove the fish and vegetables, and chop the fish into bite size pieces. \n6. Add the milk and flour to a sauce pan and stir while bringing it to a boil. Let it boil for about 10 minutes, till the sauce thickens. \n7. Add the fish, vegetables, salt and pepper to taste. \n8. Pour the mixture into an oven safe dish and top with breadcrumbs.\n9. Bake in the oven on 400F/200C for about 20 minutes.', '_uploads/recipes/_image_uploads/2/3/2017', '28.png', '28-thumb.png', '', '2017-12-10', '21:41:53', '23', '0', '0', '', '1', '', '', '', 'd6f17f7aa4f64561f6a8f1409043be8ed895fcd8')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Basil, Spinach and Chicken Soup', 2, 'en', 'Easy to make and inspired by Italian flavors like Pesto! Serves one but can be adjusted for more.', '1. Add all the ingredients except for Parmesan in a 2 Quart Slow Cooker. If you are using raw chicken you can cook the entire breast, and chop it into bite size pieces after the cook time is done.\n\n2. Cook for 3-4 hours on high or 6-7 hours on low.\n\n3. Stir in Parmesan and pepper to taste.', '_uploads/recipes/_image_uploads/2/3/2017', '24.png', '24-thumb.png', '', '2017-12-10', '17:36:21', '22', '0', '0', '', '3', '', '', '', '3653f661e06da8b49ce07265d873645a1e62f8fa')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooker Taco Soup', 2, 'en', 'An easy and healthy Taco Soup for one, but can be adjusted for more servings. The mushroom makes it possible to use less meat while still keeping a hearty meat flavor.', 'Step 1. Brown the ground beef. I sauté mine with Kirkland Chicken stock instead of oil. Add mushroom and onion towards the end of the cooking time.\nStep 2.Place all the ingredients into a two quart slow cooker and stir to blend the taco seasoning. Cover and cook on high for 3-4 hours or low 6-7 hours.\nStep 3. Serve with fresh chopped Cilantro and Greek yogurt instead of sour cream.', '_uploads/recipes/_image_uploads/2/3/2017', '25.png', '25-thumb.png', '', '2017-12-10', '17:46:48', '14', '0', '0', '', '3', '', '', '', '975261152fbad312845cfbcde9e2f8f7e21184cc')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Cloud Bread', 1, 'en', 'Finally a way to enjoy a sandwich without the carbs! Try adding various spices like oregano, basil, or red pepper flakes to the egg yolks.', '1. Preheat oven to 300°F/150°C and line two baking sheet with parchment paper.\n\n2. Separate the egg whites in one bowl and the yolks in another. For best results, use a glass bowl for the egg whites. \n\n3. Whip the egg whites into stiff peaks forms, be patient as this takes time. Add the Xanthan Gum towards the end. \n\n4. Add the yogurt, and spices into the yolks and mix until combined. \n\n5. Combine the yolks and egg whites carefully. Do not use an electronic mixer, just fold them until incorporated.\n\n\n6. Place six dollops of the mixture on each of the trays (about a full tablespoon each).\n\n7. Spread out the circles with a spatula to about ½ inch thick.\n\n8. Bake for 30 minutes or until golden and allow to cool for one hour before serving with your favorite sandwich toppings!', '_uploads/recipes/_image_uploads/1/3/2017', '27.png', '27-thumb.png', '', '2017-12-10', '21:20:04', '0', '0', '0', '', '1', '', '', '', '9c4ccd0dd6020e90b900f502997fdb2635a9e75b')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Egg White Puffs', 4, 'en', 'Tasty high protein snack', '1. Preheat oven to 350 F and place parchment paper on a cookie sheet. \n2. Pour the egg whites into a bowl and mix with an electronic mixer until it forms white stiff peaks. \n3. Carefully fold in Xanthan gum, cinnamon and sweetener to taste. I use three packages of Truvia but any other sweetener will work.\n4. Use a tablespoon to place puffs onto the baking sheet.\n5. Bake for about 12 minutes or until they become slightly golden. Enjoy!', '_uploads/recipes/_image_uploads/4/3/2017', '29.png', '29-thumb.png', '', '2017-12-10', '22:05:42', '0', '0', '0', '', '2', '', '', '', 'f7926ce6b2d2b8a8f1512038f394e405e5d73bdf')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Simple Chili from Salsa', 2, 'en', 'Can be made in a slower cooker or in a saucepan.', 'Slow cooker Directions:\n1. Brown ground beef and onions. I use Kirkland Chicken Stock instead of oil and sauté mine. \n2. Place all the ingredients into a 2 quart slow cooker and mix well. \n3. Cook on high for 3-4 hours or high 6-7 hours.\n\nSaucepan Directions:\n1. Brown the ground beef and onions.\n2. Add the rest of the ingredients and mix well. Reduce the heat and let simmer for about an hour.', '_uploads/recipes/_image_uploads/2/3/2017', '30.png', '30-thumb.png', '', '2017-12-10', '22:33:13', '0', '0', '0', '', '1', '', '', '', 'fc87497bd30d5a3d415dafd6e502b6168410afa9')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Baked Chicken Breast with Dijon Mustard', 2, 'en', 'An easy and low calorie way to add lots of flavor to your chicken.', '1. Preheat oven to 400°F.\n>br /<2. In a bowl mix Lime Juice, Garlic, Pepper, Salt, Parsley, Dijon, and Yogurt.\n>br /<3. Coat the chicken with the mixture.\n>br /<4. Line an oven safe bowl with parchment paper or spray with non stick spray such as Pam.\n>br /<5 Place chicken in a single layer and bake for 35 minutes or until cooked through.', '_uploads/recipes/_image_uploads/2/3/2017', '31.png', '31-thumb.png', '', '2017-12-10', '22:52:40', '0', '0', '0', '', '1', '', '', '', 'e408f5e9cb56871045cbb8edae244f349b81a6d6')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'White Fish Stew', 2, 'en', 'I used flounder, but any white fish work.', '1. Place all the ingredients except the lemon in a 2 quart slow cooker.\n2. Cook on high for 3-4 hours or low for 6-7 hours.\n3. Squeeze the lemon over before serving.', '_uploads/recipes/_image_uploads/2/3/2017', '32.png', '32-thumb.png', '', '2017-12-10', '23:15:51', '6', '0', '0', '', '1', '', '', '', '2d1e6449d69df58623dd122bc2d10e6d4cef7b28')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Taco Inspired Chicken Breast', 2, 'en', 'Serve over a green salad or tortillas.', '1. Mix all the ingredients in a two quart slow cooker.\n2. Cook on high 3-4 hours or low 7-8 hours. You can shred the chicken half an hour before its ready, but I prefer mine as a whole chicken breast. \n3. Top with Greek Yogurt, Cheese or Cilantro. Or all three if you&#39;d like!\n', '_uploads/recipes/_image_uploads/2/3/2017', '33.png', '33-thumb.png', '', '2017-12-10', '23:27:41', '14', '0', '0', '', '1', '', '', '', '190cb83616d6bfda39bbb9c2419e27cf330554df')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Baked Egg White Casserole', 1, 'en', 'Easy to make, lean and tasty!', '1. Preheat oven to 375 F.\n2. Line a 7 times 11 inch baking pan or a 9.5 inch oven safe pie plate with parchment paper. If you do not have parchment paper, non stick spray will work too.\n3. Spread the vegetables on the bottom of your oven safe pan.\n5. Whisk egg whites with basil, salt and pepper to taste, and pour them over the vegetables. \n6. Top with red pepper flakes. \n7. Bake for around 35 minutes or until egg whites are done. It is done when the middle is moist, not liquid.\n8. Let the casserole rest for 5 minutes. \n9. Cut into two-four pieces and serve.', '_uploads/recipes/_image_uploads/1/3/2017', '34.png', '34-thumb.png', '', '2017-12-10', '23:44:54', '0', '0', '0', '', '2', '', '', '', '512ec3e69b893ba34789f2d4d665ed5b689d111e')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Vegetable Frittata', 1, 'en', 'This egg-based Italian dish is overflowing with vegetables for a healthy start to your day.', '1. Preheat oven to 350°.\n>br /<2. Line a 7 times 11 inch baking pan or a 9. 5 inch oven safe pie plate with parchment paper. If you do not have parchment paper, non stick spray will work too.\n>br /<3. Whisk egg whites, egg, half and half and seasonings in a bowl.\n>br /<4. Place the mushrooms in the oven safe dish and pour the egg mix over. \n>br /<5. Add all the other vegetables into the dish. \n>br /<6. Bake for around 35 minutes or until egg whites are done. It is done when the middle is moist, not liquid. \n>br /<7. Let the casserole rest for about 5 minutes before cutting into four pieces. \n>br /<', '_uploads/recipes/_image_uploads/1/3/2017', '35.png', '35-thumb.png', '', '2017-12-11', '00:36:43', '9', '0', '0', '', '2', '', '', '', '7cd7bde012faa1cab4ac00ea8a29104b16c0b7b6')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Hearty Fish Soup', 2, 'en', 'Exciting fish soup, overflowing with flavor! I use flounder in mine, but any white fish will do.', '1. Place all the ingredients into a slow cooker and mix well. \n2. Let cook for about 3-4 hours on high or 6-7 hours on low.\n3. When it is 30 minutes left on the cook time, chop the fish into 1 inch cubes and add into the slow cooker as well. \n4. Remove the bay leaf and serve. \n', '_uploads/recipes/_image_uploads/2/3/2017', '36.png', '36-thumb.png', '', '2017-12-11', '01:04:10', '24', '0', '0', '', '2', '', '', '', '69986242d65795d464dbe9b7ce83d2d5191b84ce')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 1, 'Proteinpannekaker med cottage cheese', 2, 'no', 'Mye proteiner i disse pannekakene. Perfekt før trening.', '1. Bland havregryn, bakepulver og proteinpulver.\n\n2. R?r inn egg, mager cottage cheese og lettmelk.\n\n3. Stek og server med lett syltet?y.', '', '', '', '', '2017-12-11', '11:40:57', '0', '0', '0', '', '1', '', '', '', 'd4ab202d93a629e04456c0b773ba2dc216ace590')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Simple White Fish Stew', 2, 'en', 'I use flounder but Cod or other white fish will work too! Goes well with fresh chopped parsley on top.', '1. Chop the potato, tomatoes and fish into one inch cubes.\n2. Add everything but the fish into a 2 quart slow cooker and mix.\n3. Cook on high for 3-4 hours or on low for 6-7 hours.\n4. 30 minutes before the cook time is up, add the diced fish and cover.\n5. Remove the bay leaf and serve.\n\nThis recipe can be adjusted for more servings. You can also add a tablespoon white wine for extra flavor.', '_uploads/recipes/_image_uploads/2/3/2017', '38.png', '38-thumb.png', '', '2017-12-11', '14:12:38', '0', '0', '0', '', '1', '', '', '', '44f34acdf3054691c73a2c9a2882bf867965dfc0')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooker Chicken Zucchini Soup', 2, 'en', 'Can be adjusted for more servings. Serve with bread or rice.', '1. Cut the Celery, Onion, Tomatoes, and Bell Pepper into one inch cubes.\n2. Cut the Zucchini into round circles.\n3. Mince the garlic.\n4. Place all the ingredients into a two quart slow cooker and mix.\n5. Cook on high for 3-4 hours or on low for 6-7 hours.\n6. Before serving, take out the chicken breast, cut into bite size pieces and mix it back into the soup.\n\nGoes well with a teaspoon Parmesan cheese as garnish!', '_uploads/recipes/_image_uploads/2/3/2017', '39.png', '39-thumb.png', '', '2017-12-11', '14:29:27', '0', '0', '0', '', '1', '', '', '', '6b9069e716ec7422d0c6106153ea3b307052be25')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Chicken Cabbage and Bean Sprouts Soup', 2, 'en', 'Can be adjusted for more servings', '1. Chop the vegetables into bite size pieces and mince the garlic.\n>br /<2. Place all the ingredients into a two quart slow cooker and mix.\n>br /<3. Cook on high for 3-4 hours or low for 7-8 hours.\n>br /<4. Remove the bay leaf. \n>br /<5. Transfer the chicken to a cutting board and shred or cut into pieces. \n>br /<6. Stir the chicken back into the soup and serve.', '_uploads/recipes/_image_uploads/2/3/2017', '40.png', '40-thumb.png', '', '2017-12-11', '14:58:45', '0', '0', '0', '', '1', '', '', '', 'c995ac80bb7d72f0fe8fe629b8755db65c47e31b')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Fish and Vegetable Soup', 2, 'en', 'A tasty and simple soup. I used flounder in mine, but any white fish like cod, halibut or haddock will work too.', '1. Cut all the vegetables into one inch cubes. \n2. Mince the garlic. \n3. Add everything but the fish into a two quart slow cooker and mix.\n4. Cook on high for 3-4 hours or low 6-7 hours.\n5. When it is 30 minutes left on the cook time, chop the fish into one inch cubes and add it to the slow cooker. \n6. Cover and let cook for the remaining time. \n7. Serve! \n', '_uploads/recipes/_image_uploads/2/3/2017', '41.png', '41-thumb.png', '', '2017-12-11', '15:14:05', '0', '0', '0', '', '1', '', '', '', '9110367b868534e31e17baff54c4c6c094008b2b')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Skinny Pasta Carbonara', 2, 'en', 'Using Tofu Shirataki Spaghetti makes it possible to enjoy Pasta Carbonara without the guilt!', '1. I used Kirklands precooked bacon, but if you are using raw bacon cook it according to its package. Dice the bacon. \n2. Use a strainer to rinse the noodles well, pat dry and microwave for a minute. \n3. Dice the garlic.\n4. Mix the egg yolk with Parmesan cheese, garlic salt and pepper in a small bowl. \n5. Add 1/4th cup of water and the noodles in a saucepan over medium heat.\n6. Lower the heat as you add the egg mixture, peas and bacon.\n7. Continuously stir so the eggs turn into a creamy sauce, but work fast so the egg yolk doesn&#39;t cook. \n8. Serve, garnish with fresh chopped parsley if desired.', '_uploads/recipes/_image_uploads/2/3/2017', '42.png', '42-thumb.png', '', '2017-12-11', '15:27:29', '9', '0', '0', '', '1', '', '', '', '20327a2e167fc0044f6e428abee59a02f0801ec1')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Chicken Potato Soup', 2, 'en', 'A hearty soup made in a slow cooker.', '1. If you are not using precooked bacon as I do, then cook the bacon according to the package. \n2. Chop the vegetables into one inch cubes.\n3. Add the onions on the bottom of a two quart slow cooker, then place the chicken breast over.\n4. Add all the other ingredients and stir to mix the spices.\n5. Cook on high for 4-6 hours, until the potatoes are soft.\n6. Transfer the chicken breast to a cutting board and shred or chop it.\n7. Stir the remaining soup vigorously to mash the potatoes and add back the chicken. \n8. Serve, goes well topped with fresh chopped parsley.', '_uploads/recipes/_image_uploads/2/3/2017', '43.png', '43-thumb.png', '', '2017-12-11', '15:52:50', '0', '0', '0', '', '1', '', '', '', 'dfea4afc930822bab1dcaadbc7528dd6458d222f')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Baked Portobello mushrooms', 2, 'en', 'Mushroom lovers unite!', '1. Preheat oven to 400 F.\n>br /<2. Cover a baking dish with parchment paper or use non stick spray.\n>br /<3. Mince garlic.\n>br /<4. Mix the Garlic, Soy Sauce, Balsamic Vinegar and Ginger in a small bowl.\n>br /<5. Pour the mixture over the mushrooms and let it marinade for about 15 minutes.\n>br /<6. Bake for 15 minutes, flip and spoon any remaining marinade over the mushrooms again. \n>br /<7. Bake another 15 minutes.\n>br /<8. Let the mushrooms rest for five minutes.\n>br /<9. Slice and serve!', '_uploads/recipes/_image_uploads/2/3/2017', '44.png', '44-thumb.png', '', '2017-12-11', '16:31:58', '0', '0', '0', '', '1', '', '', '', '5c1c10cf902ae6e1eef37d732ac0d7b699095814')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Cilantro Lime Marinade for Cold Shrimp', 2, 'en', 'Works well with lettuce wraps, tortillas, salads, or fajitas. I use the marinade over 3 oz Kirkland Signature Cooked Tail-On Shrimp.', '1. Mince the Cilantro and Garlic. I recommend using a food processor.\n2. In a bowl combine Cilantro, Garlic, Lime Juice, half a teaspoon water, Salt and Pepper.\n3. Cover your cooked and cooled shrimp in the mixture.\n4. You can serve immediately or place the shrimp back into the fridge to let it marinade for an hour for optimal flavor. \n\nMakes enough for 3-4 oz shrimp, but can be adjusted for more.', '_uploads/recipes/_image_uploads/2/3/2017', '45.png', '45-thumb.png', '', '2017-12-11', '16:56:10', '0', '0', '0', '', '1', '', '', '', 'c0d26c8fc19f17080f900476b0ae30b4f12f89c5')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Lower Calorie Burger Patty', 2, 'en', 'Mushroom and Ground Beef blended together is low in calories while still preserving a great meaty flavor!', '1. Finely chop mushrooms in a food processor. You can chop the mushroom by hand as well. \n>br /<2. Mix Salt, Pepper, Ground Beef and the chopped Mushrooms well.\n>br /<3. Form a patty using a Burger Press or by hand.\n>br /<4. Cook in a nonstick skillet over medium-high heat, about 3 minutes per side for medium rare. I saute mine in a tablespoon Kirkland Chicken Stock but you can use non stick spray or oil as well.\n>br /<5. Serve with your favorite toppings such as melted cheese or a poached egg.\n>br /<\n>br /<You can add garlic, seasoned salt or a bit soy sauce into your ground beef mixture.', '_uploads/recipes/_image_uploads/2/3/2017', '46.png', '46-thumb.png', '', '2017-12-11', '19:34:12', '0', '0', '0', '', '1', '', '', '', '7294b70e39115367c24ffb0d02b62d36286b88b8')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Apple Cake', 5, 'en', 'Inspired by my Norwegian heritage. Low in calories!', '1. Preheat the oven to 350 F.\n<br />2. Cover a 8,5 inch pie pan in parchment paper or non stick spray. \n<br />3. Peel, core and slice the apples in thin slices.\n<br />4. Beat the eggs, sugar or sugar substitute and salt with an electronic mixer until it forms a thick batter. \n<br />5. Sift the flour before adding it, baking powder and milk and mix until combined.\n<br />6. Add 2/3 of the apples to the batter and combine using a spatula.\n<br />7. Pour the batter into the pan.\n<br />8. Arrange the last apple slices over the top of the batter.\n<br />9. Sprinkle with cinnamon and the equivalent of a tablespoon sugar or sugar substitute. \n<br />10. Bake in the oven for 35 minutes or until the middle of the cake is done.\n<br />\n<br /> I use Truvia instead of sugar in my recipe, but any sweeter that is equal to 1/3rd cup, and a tablespoon for topping, of sugar will work. \n\nServe with a scoop of vanilla ice cream or some whipped cream.', '_uploads/recipes/_image_uploads/5/3/2017', '47.png', '47-thumb.png', '', '2017-12-11', '19:54:32', '23', '0', '0', '', '1', '', '', '', 'a5faf98fbbd4e67aae6cb8015e328c66f6a4a174')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Pumpkin Soup', 2, 'en', 'Delicious low calorie way to enjoy fall flavors!', '1. Combine the pumpkin puree, vegetable stock, curry powder and ginger into a small saucepan. \n2. Stir and cook over medium heat for 15 minutes.\n3. Stir in the coconut milk and serve.\n\nFor a spicy touch, top with crushed red peppers.', '_uploads/recipes/_image_uploads/2/3/2017', '48.png', '48-thumb.png', '', '2017-12-11', '21:29:22', '0', '0', '0', '', '1', '', '', '', '24de37bed48c598f3f5a3948e553527f6b39663f')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Rainbow Salad', 3, 'en', 'Goes well with cashew dressing. You can substitute the black beans for lentils or quinoa.', '1. Chop the vegetables into bite size pieces.\n>br /<2. Rinse the black beans and place on the bottom of your bowl.\n3. Top with the vegetables and serve.', '_uploads/recipes/_image_uploads/3/3/2017', '49.png', '49-thumb.png', '', '2017-12-11', '22:09:15', '0', '0', '0', '', '1', '', '', '', '97d79d812c58c4a2d758e8ee9ba6fbf9432b92b7')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooker Chicken and Root Vegetables Soup', 2, 'en', 'Makes one serving but can be adjusted for more.', '1. Chop the vegetables and mince the garlic.\n2. Place everything into a two quart slow cooker.\n3. Cover and cook on high for 3-4 hours or on low for 6-8 hours.\n4. Remove the bay leaf. \n5. Transfer the chicken breast to a cutting board, cut or shred into pieces and mix back into the soup.', '_uploads/recipes/_image_uploads/2/3/2017', '50.png', '50-thumb.png', '', '2017-12-11', '22:31:18', '0', '0', '0', '', '1', '', '', '', '7090f423dd4fbfcc567603d385579aa449617355')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooker Lean Steak Stew', 2, 'en', 'Makes one serving, but can be adjusted for more.', '1. Chop the vegetables and mince the garlic.\n>br /<2. Chop the beef into one inch cubes.\n>br /<3. Place everything into a two quart slow cooker and stir to mix.\n>br /<4. Cook on high for 3-4 hours or on low 7-8 hours.\n>br /<5. Remove bay leaf and serve.', '_uploads/recipes/_image_uploads/2/3/2017', '51.png', '51-thumb.png', '', '2017-12-11', '22:42:22', '0', '0', '0', '', '1', '', '', '', '83ead13d3d77b9708dc0972c162cbb551bbd3c88')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooked Mexican Inspired Chicken Soup', 2, 'en', 'Serves one. Can be topped with plain Greek yogurt, lemon juice and diced avocado.', '1. Chop the vegetables, Cilantro and mince the garlic.\n2. Add everything into a two quart slow cooker except half the chopped cilantro and lemon.\n3. Cook on high for 3-4 hours or on low for 7-8 hours.\n4. Take out the chicken breast and cut or shred it and mix back into the soup.\n', '_uploads/recipes/_image_uploads/2/3/2017', '52.png', '52-thumb.png', '', '2017-12-11', '22:53:36', '14', '0', '0', '', '2', '', '', '', 'd4941488340d6de891a2264a596ea4a3abd29ad6')
")
or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_recipes
(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password)
VALUES
(NULL, 3, 'Slow Cooked Chipotle Chili Chicken Soup', 2, 'en', 'Serve with cheese, Greek Yogurt or Sour Cream, Green Onions, and Diced Avocado. Only your imagination is the limit!', '1. Drain the beans.\n>br /<2. Chop the vegetables, cilantro and mince the garlic.\n>br /<3. Add everything to a two quart slow cooker and mix.\n>br /<4. Cook on high for 3-4 hours or on low for 6-8 hours.\n>br /<5. Transfer the chicken to a cutting board and cut or shred before returning to the soup.', '_uploads/recipes/_image_uploads/2/3/2017', '53.png', '53-thumb.png', '', '2017-12-11', '23:37:30', '14', '0', '0', '', '2', '', '', '', '0d830802a62d2fb971c2cff55c2ca55469f3c079')
")
or die(mysqli_error($link));
?>
