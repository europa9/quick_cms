<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

// Mysql Setup
$mysql_config_file = "../_data/mysql_" . $server_name . ".php";
if(!(file_exists("$mysql_config_file"))){
	echo"Missing MySQL info.";
	die;
}


// Languages
mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Abkhazian', 'abkhazian', '?????', 'ab', 'abk', 'eritrea', 'windows-1252'), 
(NULL, 'Afar', 'afar', 'Qafara', 'aa', 'aar', 'eritrea', 'windows-1252'), 
(NULL, 'Afrikaans', 'afrikaans', 'Afrikaans', 'af', 'afr', 'south_africa', 'windows-1252'), 
(NULL, 'Akan', 'akan', 'macrolanguage', 'ak', 'aka', 'ghana', 'windows-1252'), 
(NULL, 'Albanian', 'albanian', 'Shqip', 'sq', 'alb/sqi', 'albania', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Amharic', 'amharic', '????', 'am', 'amh', 'ethiopia', 'windows-1252'), 
(NULL, 'Arabic', 'arabic', '???????', 'ar', 'ara', 'algeria', 'windows-1252'), 
(NULL, 'Aragonese', 'aragonese', 'Aragon?s', 'an', 'arg', 'spain', 'windows-1252'),
(NULL, 'Armenian', 'armenian', '??????? ?????', 'hy', 'arm/hye', 'armenia', 'windows-1252'), 
(NULL, 'Assamese', 'assamese', '???????', 'as', 'asm', 'india', 'windows-1252'), (NULL, 'Avaric', 'avaric', '???? ????, ???????? ????', 'av', 'ava', 'russian_federation', 'windows-1252'), (NULL, 'Avestan', 'avestan', 'avesta', 'ae', 'ave', 'russian_federation', 'windows-1252'), (NULL, 'Aymara', 'aymara', 'aymar aru', 'ay', 'aym', 'bolivia_plurinational_state_of', 'windows-1252'), (NULL, 'Azerbaijani', 'azerbaijani', 'Az?rbaycanca', 'az', 'aze', 'azerbaijan', 'windows-1252'), (NULL, 'Bambara', 'bambara', 'bamanankan', 'bm', 'bam', 'mali', 'windows-1252'), (NULL, 'Bashkir', 'bashkir', '??????? ????', 'ba', 'bak', 'russian_federation', 'windows-1252'), (NULL, 'Basque', 'basque', 'euskara', 'eu', 'baq/eus', 'spain', 'windows-1252'), (NULL, 'Belarusian', 'belarusian', '?????????? ????', 'be', 'bel', 'poland', 'windows-1252'), (NULL, 'Bengali', 'bengali', '?????', 'bn', 'ben', 'bangladesh', 'windows-1252'), (NULL, 'Bihari languages', 'bihari_languages', 'collection', 'bh', 'bih', 'fiji', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Bislama', 'bislama', 'Bislama', 'bi', 'bis', 'vanuatu', 'windows-1252'), 
(NULL, 'Bosnian', 'bosnian', 'bosanski jezik', 'bs', 'bos', 'bosnia_and_herzegovina', 'windows-1252'), 
(NULL, 'Breton', 'breton', 'brezhoneg', 'br', 'bre', 'france', 'windows-1252'), 
(NULL, 'Bulgarian', 'bulgarian', '????????? ????', 'bg', 'bul', 'bulgaria', 'windows-1252'), 
(NULL, 'Burmese', 'burmese', '????????', 'my', 'bur/mya', 'thailand', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Catalan, Valencian', 'catalan__valencian', 'catal? / valenci?', 'ca', 'cat', 'spain', 'windows-1252'), 
(NULL, 'Central Khmer', 'central_khmer', '?????????', 'km', 'khm', 'thailand', 'windows-1252'), 
(NULL, 'Chamorro', 'chamorro', 'Chamoru', 'ch', 'cha', 'guam', 'windows-1252'), 
(NULL, 'Chechen', 'chechen', '??????? ????', 'ce', 'che', 'russian_federation', 'windows-1252'), 
(NULL, 'Chichewa, Chewa, Nyanja', 'chichewa__chewa__nyanja', 'chiChewa, chinyanja', 'ny', 'nya', 'zambia', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES 
(NULL, 'Chinese', 'chinese', '?? (ZhongWen)', 'zh', 'chi/zho', 'china', 'windows-1252'), 
(NULL, 'Church Slavonic/Bulgarian', 'church_slavonic__church_slavic__old_church_slavonic__old_slavonic__old_bulgarian', '????? ??????????', 'cu', 'chu', 'russian_federation', 'windows-1252'), 
(NULL, 'Chuvash', 'chuvash', '????? ?????', 'cv', 'chv', 'russian_federation', 'windows-1252'), 
(NULL, 'Cornish', 'cornish', 'Kernewek', 'kw', 'cor', 'united_kingdom', 'windows-1252'), 
(NULL, 'Corsican', 'corsican', 'corsu, lingua corsa', 'co', 'cos', 'france', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Cree', 'cree', '???????', 'cr', 'cre', 'canada', 'windows-1252'), 
(NULL, 'Croatian', 'croatian', 'hrvatski jezik', 'hr', 'hrv', 'croatia', 'windows-1252'), 
(NULL, 'Czech', 'czech', 'ce?tina (substantive), cesky (adverb)', 'cs', 'cze/ces', 'czech_republic', 'windows-1252'), 
(NULL, 'Danish', 'danish', 'dansk', 'da', 'dan', 'denmark', 'windows-1252'), 
(NULL, 'Divehi, Dhivehi, Maldivian', 'divehi__dhivehi__maldivian', '?????????', 'dv', 'div', 'maldives', 'windows-1252'), 
(NULL, 'Dutch, Flemish', 'dutch__flemish', 'Nederlands', 'nl', 'dut/nld', 'netherlands', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Dzongkha', 'dzongkha', '??????', 'dz', 'dzo', 'bhutan', 'windows-1252'), 
(NULL, 'English', 'english', 'English', 'en', 'eng', 'united_kingdom', 'windows-1252'), 
(NULL, 'Esperanto', 'esperanto', 'Esperanto', 'eo', 'epo', 'china', 'windows-1252'), 
(NULL, 'Estonian', 'estonian', 'eesti keel', 'et', 'est', 'estonia', 'windows-1252'), 
(NULL, 'Ewe', 'ewe', '???gb?', 'ee', 'ewe', 'ghana', 'windows-1252'), 
(NULL, 'Faroese', 'faroese', 'f?royskt', 'fo', 'fao', 'faroe_islands', 'windows-1252'), 
(NULL, 'Fijian', 'fijian', 'vosa Vakaviti', 'fj', 'fij', 'fiji', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Finnish', 'finnish', 'suomi, suomen kieli', 'fi', 'fin', 'finland', 'windows-1252'), 
(NULL, 'French', 'french', 'fran?ais, langue fran?aise', 'fr', 'fre/fra', 'france', 'windows-1252'), 
(NULL, 'Fulah', 'fulah', 'Fulfulde, Pulaar, Pular', 'ff', 'ful', 'mauritania', 'windows-1252'), 
(NULL, 'Galician', 'galician', 'Galego', 'gl', 'glg', 'galicia', 'windows-1252'), 
(NULL, 'Ganda', 'ganda', 'Luganda', 'lg', 'lug', 'uganda', 'windows-1252'), 
(NULL, 'Georgian', 'georgian', '??????? ??? (kartuli ena)', 'ka', 'geo/kat', 'georgia', 'windows-1252'), 
(NULL, 'German', 'german', 'Deutsch', 'de', 'ger/deu', 'germany', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Greenlandic, Kalaallisut', 'greenlandic__kalaallisut', 'kalaallisut, kalaallit oqaasii', 'kl', 'kal', 'greenland', 'windows-1252'), 
(NULL, 'Guarani', 'guarani', 'Ava?e?', 'gn', 'grn', 'argentina', 'windows-1252'), 
(NULL, 'Gujarati', 'gujarati', '???????', 'gu', 'guj', 'india', 'windows-1252'), 
(NULL, 'Haitian Creole, Haitian', 'haitian_creole__haitian', 'Krey?l ayisyen', 'ht', 'hat', 'haiti', 'windows-1252'), 
(NULL, 'Hausa', 'hausa', 'Hausanci, ??????', 'ha', 'hau', 'benin', 'windows-1252'), 
(NULL, 'Hebrew', 'hebrew', '????????, ?????', 'he', 'heb', 'israel', 'windows-1252'), 
(NULL, 'Herero', 'herero', 'Otjiherero', 'hz', 'her', 'namibia', 'windows-1252'), 
(NULL, 'Hindi', 'hindi', '??????', 'hi', 'hin', 'india', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Hiri Motu', 'hiri_motu', 'Hiri Motu', 'ho', 'hmo', 'papua_new_guinea', 'windows-1252'), 
(NULL, 'Hungarian', 'hungarian', 'magyar', 'hu', 'hun', 'hungary', 'windows-1252'), 
(NULL, 'Icelandic', 'icelandic', '?slenska', 'is', 'ice/isl', 'iceland', 'windows-1252'), 
(NULL, 'Ido', 'ido', 'Ido', 'io', 'ido', 'germany', 'windows-1252'), 
(NULL, 'Igbo', 'igbo', 'Igbo', 'ig', 'ibo', 'nigeria', 'windows-1252'), 
(NULL, 'Indonesian', 'indonesian', 'Bahasa Indonesia', 'id', 'ind', 'indonesia', 'windows-1252'), 
(NULL, 'Interlingua', 'interlingua_international_auxiliary_language_association', 'interlingua', 'ia', 'ina', 'france', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Interlingue, Occidental', 'interlingue__occidental', 'Interlingue', 'ie', 'ile', 'germany', 'windows-1252'), 
(NULL, 'Inuktitut', 'inuktitut', '??????', 'iu', 'iku', 'canada', 'windows-1252'), 
(NULL, 'Inupiaq', 'inupiaq', 'I?upiaq, I?upiatun', 'ik', 'ipk', 'united_states', 'windows-1252'), 
(NULL, 'Irish', 'irish', 'Gaeilge', 'ga', 'gle', 'ireland', 'windows-1252'), 
(NULL, 'Italian', 'italian', 'italiano', 'it', 'ita', 'italy', 'windows-1252'), 
(NULL, 'Japanese', 'japanese', '??? (????)', 'ja', 'jpn', 'japan', 'windows-1252'), 
(NULL, 'Javanese', 'javanese', 'basa Jawa (????)', 'jv', 'jav', 'indonesia', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Kannada', 'kannada', '?????', 'kn', 'kan', 'india', 'windows-1252'), 
(NULL, 'Kanuri', 'kanuri', 'macrolanguage', 'kr', 'kau', 'niger', 'windows-1252'), 
(NULL, 'Kashmiri', 'kashmiri', '?????, ?????', 'ks', 'kas', 'india', 'windows-1252'), 
(NULL, 'Kazakh', 'kazakh', '????? ????', 'kk', 'kaz', 'kazakhstan', 'windows-1252'), 
(NULL, 'Kikuyu, Gikuyu', 'kikuyu__gikuyu', 'Gikuyu', 'ki', 'kik', 'kenya', 'windows-1252'), 
(NULL, 'Kinyarwanda', 'kinyarwanda', 'Ikinyarwanda', 'rw', 'kin', 'rwanda', 'windows-1252'), 
(NULL, 'Kirghiz, Kyrgyz', 'kirghiz__kyrgyz', '?????? ????', 'ky', 'kir', 'kyrgyzstan', 'windows-1252'), 
(NULL, 'Komi', 'komi', '???? ???', 'kv', 'kom', 'russian_federation', 'windows-1252'), 
(NULL, 'Kongo', 'kongo', 'Kikongo', 'kg', 'kon', 'republic_of_the_congo', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Korean', 'korean', '??? (???), ??? (???)', 'ko', 'kor', 'korea__republic_of', 'windows-1252'), 
(NULL, 'Kuanyama, Kwanyama', 'kuanyama__kwanyama', '', 'kj', 'kua', 'namibia', 'windows-1252'), 
(NULL, 'Kurdish', 'kurdish', 'Kurd?', 'ku', 'kur', 'turkey', 'windows-1252'), 
(NULL, 'Lao', 'lao', '???????', 'lo', 'lao', 'laos', 'windows-1252'), 
(NULL, 'Latin', 'latin', 'latine, lingua Latina', 'la', 'lat', 'vatican_city', 'windows-1252'), 
(NULL, 'Latvian', 'latvian', 'latvie?u valoda', 'lv', 'lav', 'latvia', 'windows-1252'), 
(NULL, 'Limburgish, Limburger, Limburgan', 'limburgish__limburger__limburgan', 'Limburgs', 'li', 'lim', 'netherlands', 'windows-1252'), 
(NULL, 'Lingala', 'lingala', 'lingala', 'ln', 'lin', 'congo__the_democratic_republic_of_the', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Lithuanian', 'lithuanian', 'lietuviu kalba', 'lt', 'lit', 'lithuania', 'windows-1252'), 
(NULL, 'Luba-Katanga', 'luba-katanga', '', 'lu', 'lub', 'congo__the_democratic_republic_of_the', 'windows-1252'), 
(NULL, 'Luxembourgish, Letzeburgesch', 'luxembourgish__letzeburgesch', 'L?tzebuergesch', 'lb', 'ltz', 'luxembourg', 'windows-1252'), 
(NULL, 'Macedonian', 'macedonian', '?????????? ?????', 'mk', 'mac/mkd', 'republic_of_macedonia', 'windows-1252'), 
(NULL, 'Malagasy', 'malagasy', 'Malagasy fiteny', 'mg', 'mlg', 'madagascar', 'windows-1252'), 
(NULL, 'Malayalam', 'malayalam', '??????', 'ml', 'mal', 'india', 'windows-1252'), 
(NULL, 'Malay', 'malay', 'bahasa Melayu, ???? ?????', 'ms', 'may/msa', 'malaysia', 'windows-1252'), 
(NULL, 'Maltese', 'maltese', 'Malti', 'mt', 'mlt', 'malta', 'windows-1252'), 
(NULL, 'Manx', 'manx', 'Gaelg, Manninagh', 'gv', 'glv', 'isle_of_man', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Maori', 'maori', 'te reo Maori', 'mi', 'maomri', 'new_zealand', 'windows-1252')") or die(mysqli_error($link));


mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Marathi', 'marathi', '?????', 'mr', 'mar', 'india', 'windows-1252'), 
(NULL, 'Marshallese', 'marshallese', 'Kajin Majel', 'mh', 'mah', 'marshall_islands', 'windows-1252'), 
(NULL, 'Modern Greek', 'modern_greek_1453', '', 'el', 'greell', 'greece', 'windows-1252'), 
(NULL, 'Mongolian', 'mongolian', '', 'mn', 'mon', 'mongolia', 'windows-1252')") or die(mysqli_error($link));


mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Nauruan', 'nauruan', 'Ekakairu Naoero', 'na', 'nau', 'nauru', 'windows-1252'), 
(NULL, 'Navajo, Navaho', 'navajonavaho', 'Din bizaad, Dinkehj', 'nv', 'nav', 'united_states', 'windows-1252'), 
(NULL, 'Ndonga', 'ndonga', 'Owambo', 'ng', 'ndo', 'namibia', 'windows-1252'), 
(NULL, 'Nepali', 'nepali', '', 'ne', 'nep', 'nepal', 'windows-1252')") or die(mysqli_error($link));


mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Northern Ndebele', 'northern_ndebele', 'isiNdebele', 'nd', 'nde', 'zimbabwe', 'windows-1252'), 
(NULL, 'Northern Sami', 'northern_sami', 'sami, samegiella', 'se', 'sme', 'northern_sami', 'windows-1252'), 
(NULL, 'Norwegian Bokm&aring;l', 'norwegian_bokmaal', 'bokmal', 'nb', 'nob', 'norway', 'windows-1252'), 
(NULL, 'Norwegian Nynorsk', 'norwegian_nynorsk', 'nynorsk', 'nn', 'nno', 'norway', 'windows-1252'), 
(NULL, 'Norwegian', 'norwegian', 'norsk', 'no', 'nor', 'norway', 'windows-1252'), 
(NULL, 'Occitan', 'occitan_1500', 'Occitan', 'oc', 'oci', 'france', 'windows-1252'), 
(NULL, 'Ojibwa', 'ojibwa', 'Anishinaabemowin', 'oj', 'oji', 'canada', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES
(NULL, 'Oriya', 'oriya', '', 'or', 'ori', 'india', 'windows-1252'), 
(NULL, 'Oromo', 'oromo', 'Afaan Oromoo', 'om', 'orm', 'ethiopia', 'windows-1252'), 
(NULL, 'Ossetian, Ossetic', 'ossetian ossetic', '', 'os', 'oss', 'russian_federation', 'windows-1252'), 
(NULL, 'Pali', 'pali', '', 'pi', 'pli', 'cambodia', 'windows-1252'), 
(NULL, 'Pashto language, Pashto', 'pashto_language__pashto', '????', 'ps', 'pus', 'afghanistan', 'windows-1252'), 
(NULL, 'Persian', 'persian', '?????', 'fa', 'per/fas', 'iran__islamic_republic_of', 'windows-1252'), 
(NULL, 'Polish', 'polish', 'polski', 'pl', 'pol', 'poland', 'windows-1252'), 
(NULL, 'Portuguese', 'portuguese', 'portugu?s', 'pt', 'por', 'portugal', 'windows-1252'), 
(NULL, 'Punjabi, Panjabi', 'punjabi__panjabi', '??????, ??????', 'pa', 'pan', 'india', 'windows-1252'), 
(NULL, 'Quechua', 'quechua', 'Runa Simi, Kichwa', 'qu', 'que', 'peru', 'windows-1252'), 
(NULL, 'Romanian', 'romanian', 'rom?na', 'ro', 'rum/ron', 'romania', 'windows-1252'), 
(NULL, 'Romansh', 'romansh', 'rumantsch grischun', 'rm', 'roh', 'switzerland', 'windows-1252'), 
(NULL, 'Rundi', 'rundi', 'Rundi', 'rn', 'run', 'burundi', 'windows-1252'), 
(NULL, 'Russian', 'russian', '??????? ????', 'ru', 'rus', 'russian_federation', 'windows-1252'), 
(NULL, 'Samoan', 'samoan', 'gagana faa Samoa', 'sm', 'smo', 'samoa', 'windows-1252'), 
(NULL, 'Sango', 'sango', 'y?ng? t? s?ng?', 'sg', 'sag', 'chad', 'windows-1252'), 
(NULL, 'Sanskrit', 'sanskrit', '?????????', 'sa', 'san', 'india', 'windows-1252'), 
(NULL, 'Sardinian', 'sardinian', 'sardu', 'sc', 'srd', 'italy', 'windows-1252'), 
(NULL, 'Scottish Gaelic, Gaelic', 'scottish_gaelic__gaelic', 'G?idhlig', 'gd', 'gla', 'united_kingdom', 'windows-1252'), 
(NULL, 'Serbian', 'serbian', '?????? ?????, srpski jezik', 'sr', 'srp', 'serbia', 'windows-1252'), 
(NULL, 'Shona', 'shona', 'chiShona', 'sn', 'sna', 'zimbabwe', 'windows-1252'), 
(NULL, 'Sichuan Yi, Nuosu', 'sichuan_yi__nuosu', '??', 'ii', 'iii', 'china', 'windows-1252'), 
(NULL, 'Sindhi', 'sindhi', '????? ?????, ??????', 'sd', 'snd', 'pakistan', 'windows-1252'), 
(NULL, 'Sinhalese, Sinhala', 'sinhalese__sinhala', '?????', 'si', 'sin', 'sri_lanka', 'windows-1252'), 
(NULL, 'Slovak', 'slovak', 'slovencina', 'sk', 'slo/slk', 'slovakia', 'windows-1252'), 
(NULL, 'Slovenian', 'slovenian', 'sloven?cina', 'sl', 'slv', 'slovenia', 'windows-1252'), 
(NULL, 'Somali', 'somali', 'Soomaaliga, af Soomaali', 'so', 'som', 'somalia', 'windows-1252'), 
(NULL, 'Southern Ndebele', 'southern_ndebele', 'isiNdebele', 'nr', 'nbl', 'south_africa', 'windows-1252'), 
(NULL, 'Southern Sotho', 'southern_sotho', 'Sesotho', 'st', 'sot', 'lesotho', 'windows-1252'), 
(NULL, 'Spanish', 'spanish', 'espanol', 'es', 'spa', 'spain', 'windows-1252'), 
(NULL, 'Sundanese', 'sundanese', 'basa Sunda', 'su', 'sun', 'indonesia', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Swahili', 'swahili', 'Kiswahili', 'sw', 'swa', 'burundi', 'windows-1252'), (NULL, 'Swati', 'swati', 'siSwati', 'ss', 'ssw', 'swaziland', 'windows-1252'), (NULL, 'Swedish', 'swedish', 'svenska', 'sv', 'swe', 'sweden', 'windows-1252'), (NULL, 'Tagalog', 'tagalog', 'Wikang Tagalog, ????? ??????', 'tl', 'tgl', 'philippines', 'windows-1252'), (NULL, 'Tahitian', 'tahitian', 'te reo Tahiti, te reo Maohi', 'ty', 'tah', 'french_polynesia', 'windows-1252'), (NULL, 'Tajik', 'tajik', '??????, ??????', 'tg', 'tgk', 'tajikistan', 'windows-1252'), (NULL, 'Tamil', 'tamil', '?????', 'ta', 'tam', 'india', 'windows-1252'), (NULL, 'Tatar', 'tatar', '???????, tatar?a, ???????', 'tt', 'tat', 'russian_federation', 'windows-1252'), (NULL, 'Telugu', 'telugu', '??????', 'te', 'tel', 'india', 'windows-1252'), (NULL, 'Thai', 'thai', '???????', 'th', 'tha', 'thailand', 'windows-1252'), (NULL, 'Tibetan', 'tibetan', '???????', 'bo', 'tib/bod', 'china', 'windows-1252'), (NULL, 'Tigrinya', 'tigrinya', '????', 'ti', 'tir', 'eritrea', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Tonga (Tonga Islands)', 'tonga_tonga_islands', 'faka-Tonga', 'to', 'ton', 'tonga', 'windows-1252'), (NULL, 'Tsonga', 'tsonga', 'Xitsonga', 'ts', 'tso', 'mozambique', 'windows-1252'), (NULL, 'Tswana', 'tswana', 'Setswana', 'tn', 'tsn', 'botswana', 'windows-1252'), (NULL, 'Turkish', 'turkish', 'T?rk?e', 'tr', 'tur', 'turkey', 'windows-1252'), (NULL, 'Turkmen', 'turkmen', '???????', 'tk', 'tuk', 'turkmenistan', 'windows-1252'), (NULL, 'Twi', 'twi', '', 'tw', 'twi', 'ghana', 'windows-1252'), (NULL, 'Uighur, Uyghur', 'uighur__uyghur', 'Uy?urq?, Uygur?e, ???????', 'ug', 'uig', 'china', 'windows-1252'), (NULL, 'Ukrainian', 'ukrainian', '?????????? ????', 'uk', 'ukr', 'ukraine', 'windows-1252'), (NULL, 'Urdu', 'urdu', '????', 'ur', 'urd', 'pakistan', 'windows-1252'), (NULL, 'Uzbek', 'uzbek', 'Ozbek, ?????, ??????', 'uz', 'uzb', 'uzbekistan', 'windows-1252'), (NULL, 'Venda', 'venda', 'Tshiven?a', 've', 'ven', 'south_africa', 'windows-1252'), (NULL, 'Vietnamese', 'vietnamese', 'Ti?ng Vi?t', 'vi', 'vie', 'viet_nam', 'windows-1252')") or die(mysqli_error($link));

mysqli_query($link, "INSERT INTO $t_languages
(language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset) 
VALUES(NULL, 'Volap?k', 'volap?k', 'Volap?k', 'vo', 'vol', 'germany', 'windows-1252'), (NULL, 'Walloon', 'walloon', 'walon', 'wa', 'wln', 'belgium', 'windows-1252'), 
(NULL, 'Welsh', 'welsh', 'Cymraeg', 'cy', 'wel/cym', 'wales', 'windows-1252'), (NULL, 'Western Frisian', 'western_frisian', 'frysk', 'fy', 'fry', 'netherlands', 'windows-1252'), 
(NULL, 'Wolof', 'wolof', 'Wolof', 'wo', 'wol', 'senegal', 'windows-1252'), (NULL, 'Xhosa', 'xhosa', 'isiXhosa', 'xh', 'xho', 'south_africa', 'windows-1252'), 
(NULL, 'Yiddish', 'yiddish', '??????', 'yi', 'yid', 'united_states', 'windows-1252'), (NULL, 'Yoruba', 'yoruba', 'Yor?b?', 'yo', 'yor', 'nigeria', 'windows-1252'), 
(NULL, 'Zhuang, Chuang', 'zhuang__chuang', 'Sa? cue??, Saw cuengh', 'za', 'zha', 'china', 'windows-1252'), (NULL, 'Zulu', 'zulu', 'isiZulu', 'zu', 'zul', 'south_africa', 'windows-1252') 
") or die(mysqli_error($link));

// -> Update correct language 
$language_mysql = quote_smart($link, $language);
$query = "SELECT language_id, language_name, language_slug, language_native_name, language_iso_two, language_iso_three, language_flag, language_charset FROM $t_languages WHERE language_iso_two=$language_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_language_id, $get_language_name, $get_language_slug, $get_language_native_name, $get_language_iso_two, $get_language_iso_three, $get_language_flag, $get_language_charset) = $row;

mysqli_query($link, "INSERT INTO $t_languages_active
(language_active_id, language_active_name, language_active_slug, language_active_native_name, language_active_iso_two, language_active_iso_three, language_active_flag, language_active_charset, language_active_default) 
VALUES
(NULL, '$get_language_name', '$get_language_slug', '$get_language_native_name', '$get_language_iso_two', '$get_language_iso_three', '$get_language_flag', '$get_language_charset', '1')
") or die(mysqli_error($link));


// Header
header("Location: index.php?page=03_d_database_insert_into_tables_stats_user_agents&language=$language&process=1");
exit;


?>
