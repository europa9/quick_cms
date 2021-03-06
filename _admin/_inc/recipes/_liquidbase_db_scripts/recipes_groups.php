<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_groups.php
* Version 1.0.0
* Date 17:21 31.12.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

echo"


	<!-- $t_recipes_groups -->
	";
	$query = "SELECT * FROM $t_recipes_groups";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_groups: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_groups(
	  	 group_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(group_id), 
	  	   group_recipe_id INT,
	  	   group_title VARCHAR(50))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_recipes_groups (`group_id`, `group_recipe_id`, `group_title`) VALUES
(1, 1, 'Matrett'),
(4, 3, 'Ingredients'),
(8, 6, 'Matrett'),
(9, 7, 'Ingredients'),
(12, 10, 'Matrett'),
(13, 11, 'Matrett'),
(14, 12, 'Matrett'),
(18, 16, 'Ingredients'),
(19, 17, 'Broth'),
(20, 17, 'Ramen'),
(21, 18, 'Ingredients'),
(23, 20, 'Dish'),
(24, 21, 'Matrett'),
(31, 27, 'Ingredients'),
(32, 28, 'Ingredients'),
(33, 29, 'Ingredients'),
(34, 30, 'Ingredients'),
(35, 31, 'Ingredients'),
(37, 33, 'Ingredients'),
(38, 34, 'Ingredients'),
(40, 36, 'Ingredients'),
(41, 37, ''),
(44, 40, 'Stir fry'),
(48, 44, 'Ingredients'),
(49, 45, 'Ingredients'),
(50, 46, 'Ingredients'),
(51, 47, 'Ingredients'),
(52, 48, 'Ingredients'),
(57, 53, 'Ingredients'),
(61, 57, 'Ingredients'),
(66, 62, 'Stir fry'),
(75, 71, 'Ingredienser'),
(76, 72, 'Ingredienser'),
(77, 73, 'Ingredienser'),
(78, 74, 'Ingredienser'),
(80, 76, 'Ingredienser'),
(81, 76, 'Mai Tai'),
(82, 77, 'Ingredienser'),
(83, 77, 'HP'),
(84, 78, 'Ingredienser'),
(85, 79, 'Ingredienser'),
(86, 80, 'Ingredienser'),
(87, 81, 'Basic'),
(88, 81, 'Mix in Oatmeal'),
(89, 81, 'Topping'),
(91, 83, 'Ingredienser'),
(92, 84, 'Ingredienser'),
(93, 85, 'Ingredienser'),
(94, 86, 'Ingredienser'),
(95, 86, 'Pensel'),
(96, 87, 'Ingredienser'),
(97, 88, 'Ingredienser'),
(98, 89, 'Ingredients'),
(99, 90, 'Ingredienser'),
(100, 91, 'Ingredienser'),
(102, 93, 'Grunnlag'),
(103, 93, 'Miks i havregr&oslash;ten'),
(104, 93, 'P&aring; toppen'),
(105, 94, 'Ingredienser'),
(106, 94, 'Parmesansaus'),
(107, 95, 'Ingredienser'),
(108, 96, 'Ingredienser'),
(109, 97, 'Ingredienser'),
(110, 98, 'Ingredienser'),
(111, 99, 'Ingredienser'),
(112, 100, 'Ingredienser'),
(113, 101, 'Ingredienser'),
(115, 103, 'Ingredienser'),
(116, 104, 'Ingredienser'),
(117, 104, 'Urtesm&oslash;r'),
(118, 105, 'Ingredienser'),
(119, 105, 'Soyasaus'),
(120, 106, 'Ingredienser'),
(121, 107, 'Ingredienser'),
(122, 108, 'Ingredienser'),
(123, 109, 'Ingredienser'),
(124, 110, 'Ingredienser'),
(125, 111, 'Ingredienser'),
(126, 112, 'Kakebunn'),
(127, 112, 'Kakefyll'),
(128, 113, 'Ingredienser'),
(129, 114, 'Ingredienser'),
(130, 115, 'Ingredienser'),
(131, 116, 'Ingredienser'),
(132, 116, 'Til dypping'),
(133, 117, 'Ingredienser'),
(134, 116, 'Str&oslash;'),
(136, 119, 'Ingredients'),
(137, 120, 'Ingredients'),
(138, 121, 'Ingredients'),
(139, 122, 'Ingredients'),
(143, 125, 'Ingredients'),
(152, 132, 'Ingredients'),
(155, 134, 'Ingredients'),
(158, 136, 'Ingredients'),
(168, 142, 'Ingredients'),
(181, 153, 'Ingredients'),
(182, 154, 'Ingredients'),
(187, 62, 'Sauce'),
(189, 40, 'Sauce'),
(199, 166, 'Stir fry'),
(201, 168, 'Ingredients'),
(207, 174, 'Ingredienser'),
(208, 175, 'Ingredienser'),
(222, 185, 'Ingredienser'),
(232, 61, 'Ingredients'),
(233, 60, 'Ingredients'),
(234, 60, 'Mustard Sauce'),
(235, 193, 'Ingredients'),
(238, 9, 'Ingredients'),
(239, 43, 'Ground beef'),
(240, 43, 'Taco Spice Mix'),
(241, 14, 'Sauce'),
(242, 14, 'Ingredients'),
(243, 25, 'Ingredients'),
(244, 25, 'Spice mix'),
(245, 141, 'Ingredients'),
(246, 141, 'Sauce'),
(247, 4, 'Ingredients'),
(248, 195, 'Ingredients'),
(249, 35, 'Ingredients'),
(252, 32, 'Ingredients'),
(253, 32, 'Step 1 spice mix'),
(254, 32, 'Step 2 spice mix'),
(257, 8, 'Ingredients'),
(258, 8, 'Lemon Sauce'),
(259, 13, 'Ingredients'),
(260, 198, 'Ingredients'),
(261, 24, 'Ingredients'),
(262, 39, 'Ingredients'),
(263, 199, 'Ingredients'),
(264, 200, 'Ingredients'),
(265, 52, 'Ingredients'),
(266, 201, 'Ingredients'),
(267, 202, 'Ingredients'),
(268, 140, 'Ingredients'),
(269, 203, 'Ingredients'),
(270, 204, 'Ingredients'),
(272, 205, 'Ingredients'),
(274, 206, 'Ingredients'),
(275, 118, 'Ingredients'),
(276, 207, 'Ingredienser'),
(277, 207, 'Saus'),
(278, 208, 'Ingredienser'),
(282, 137, 'Ingredients'),
(283, 50, 'Ingredients'),
(284, 171, 'Ingredients'),
(285, 212, 'Ingredients'),
(286, 213, 'Ingredients'),
(287, 38, 'Ingredients'),
(288, 214, 'Ingredients'),
(290, 51, 'Ingredients'),
(293, 218, 'Ingredients'),
(297, 222, 'Ingredients'),
(298, 223, 'Ingredients'),
(300, 225, 'Ketchup'),
(301, 225, 'Sliders'),
(302, 225, 'Pineapple'),
(303, 225, 'Coleslaw'),
(305, 227, 'Ingredients'),
(306, 228, 'Ingredients'),
(307, 229, 'Ingredients'),
(308, 127, 'Ingredients'),
(309, 41, 'Chicken and Stir-Fry'),
(310, 230, 'Stir-Fry'),
(311, 231, 'Ingredients'),
(319, 126, 'Ingredients'),
(320, 237, 'Ingredients'),
(321, 41, 'Sauce'),
(322, 230, 'Chicken Marinade'),
(323, 230, 'Sauce'),
(326, 59, 'Ingredients'),
(328, 63, 'Ingredients'),
(329, 241, 'Ingredients'),
(330, 242, 'Ingredients'),
(331, 5, 'Ingredients'),
(332, 243, 'Ingredients'),
(333, 244, 'Ingredients'),
(334, 244, 'Batter'),
(335, 245, 'Ingredients'),
(336, 245, 'Sauce'),
(337, 246, 'Ingredients'),
(338, 247, 'Ingredienser'),
(339, 247, 'Sennepsaus'),
(342, 249, 'Ingredienser'),
(343, 250, 'Ingredienser'),
(344, 251, 'Ingredienser'),
(345, 252, 'Ingredienser'),
(346, 253, 'Ingredients'),
(347, 254, 'Ingredients'),
(348, 131, 'Ingredients'),
(349, 255, 'Ingredients'),
(350, 256, 'Ingredients'),
(351, 257, 'Ingredients'),
(352, 258, 'Ingredients'),
(353, 258, 'Spice Mix'),
(354, 259, 'Ingredients'),
(356, 261, 'Ingredients'),
(357, 261, 'Sauce'),
(358, 262, 'Ingredients'),
(359, 261, 'Pasta (Optional)'),
(360, 263, 'Ingredients'),
(361, 264, 'Ingredients'),
(362, 265, 'Ingredients'),
(363, 266, 'Ingredients'),
(364, 267, 'Ingredients'),
(365, 267, 'Sauce'),
(366, 268, 'Ingredients'),
(367, 269, 'Ingredients'),
(368, 270, 'Ingredients'),
(369, 271, 'Ingredients'),
(370, 272, 'Ingredients'),
(371, 273, 'Ingredients'),
(372, 274, 'Marinade'),
(373, 274, 'Tofu'),
(374, 275, 'Ingredients'),
(375, 276, 'Ingredients'),
(376, 277, 'Ingredients'),
(377, 278, 'Ingredients'),
(378, 279, 'Ingredients'),
(379, 280, 'Ingredients'),
(380, 281, 'Ingredients'),
(381, 282, 'Ingredients'),
(382, 283, 'Ingredients'),
(383, 284, 'Ingredients'),
(384, 285, 'Ingredients'),
(385, 286, 'Ingredients'),
(386, 287, 'Ingredients'),
(387, 288, 'Ingredients'),
(388, 289, 'Ingredients'),
(389, 290, 'Ingredients'),
(390, 291, 'Ingredients'),
(391, 292, 'Ingredients'),
(392, 293, 'Ingredients'),
(393, 293, 'Sauce'),
(394, 294, 'Ingredients'),
(395, 295, 'Ingredients'),
(396, 296, 'Ingredients'),
(397, 297, 'Ingredients'),
(398, 298, 'Ingredients'),
(399, 299, 'Ingredients'),
(400, 300, 'Ingredients'),
(401, 301, 'Ingredients'),
(402, 302, 'Ingredients'),
(403, 303, 'Ingredients'),
(404, 304, 'Ingredients'),
(405, 305, 'Ingredients'),
(406, 305, 'Sauce'),
(407, 306, 'Ingredienser'),
(408, 307, 'Ingredienser'),
(409, 308, 'Ingredienser'),
(410, 309, 'Ingredienser'),
(411, 310, 'Ingredienser'),
(412, 311, 'Ingredienser'),
(413, 312, 'Ingredienser'),
(414, 313, 'Ingredienser'),
(415, 314, 'Ingredienser'),
(416, 315, 'Ingredienser'),
(417, 316, 'Ingredienser'),
(418, 317, 'Ingredienser'),
(419, 318, 'Ingredienser'),
(420, 319, 'Ingredienser'),
(421, 320, 'Ingredienser'),
(422, 321, 'Ingredienser'),
(423, 322, 'Ingredienser'),
(424, 323, 'Ingredienser'),
(425, 324, 'Ingredienser'),
(426, 325, 'Ingredienser'),
(427, 325, 'Glasur'),
(428, 326, 'Ingredienser'),
(429, 327, 'Ingredienser'),
(430, 328, 'Ingredienser'),
(431, 329, 'Ingredienser'),
(432, 329, 'Ostekrem'),
(433, 330, 'Ingredienser'),
(434, 331, 'Ingredienser'),
(435, 332, 'Ingredienser'),
(436, 332, 'Tilbeh&oslash;r'),
(437, 333, 'Ingredients'),
(438, 334, 'Ingredients'),
(439, 335, 'Ingredients'),
(440, 335, 'Nacho Spice Mix'),
(441, 336, 'Ingredients'),
(443, 338, 'Ingredients'),
(444, 339, 'Ingredients'),
(446, 341, 'Ingredients'),
(451, 344, 'Ingredients'),
(452, 344, 'Yogurt topping'),
(453, 158, 'Oatmeal'),
(454, 158, 'Glaze'),
(455, 158, 'Butter Glaze'),
(456, 345, 'Ingredients'),
(457, 345, 'Nacho Spice Mix'),
(459, 347, 'Ingredients'),
(460, 348, 'Ingredients'),
(461, 348, 'Salted Brownie'),
(462, 349, 'Ingredients'),
(463, 350, 'Ingredients'),
(464, 351, 'Ingredients'),
(465, 352, 'Ingredients'),
(466, 353, 'Ingredients'),
(467, 354, 'Ingredients'),
(468, 355, 'Ingredients'),
(469, 356, 'Ingredients'),
(470, 357, 'Ingredients'),
(471, 358, 'Ingredients'),
(472, 359, 'Ingredients'),
(473, 360, 'Ingredients'),
(474, 361, 'Ingredients'),
(475, 362, 'Ingredients'),
(476, 363, 'Ingredients'),
(477, 364, 'Ingredients'),
(478, 365, 'Ingredients'),
(479, 366, 'Ingredients'),
(480, 366, 'Flatbread'),
(481, 366, 'Topping'),
(482, 367, 'Ingredients'),
(483, 368, 'Ingredients'),
(484, 369, 'Ingredients'),
(485, 370, 'Curry Ketchup'),
(486, 370, 'Sausage'),
(487, 371, 'Ingredients'),
(488, 372, 'Ingredients'),
(489, 373, 'Ingredients'),
(490, 374, 'Ingredients'),
(491, 375, 'Ingredients'),
(492, 376, 'Ingredients'),
(493, 377, 'Ingredients'),
(494, 162, 'Ingredients'),
(495, 378, 'Ingredients'),
(496, 378, 'Lemon dressing'),
(497, 379, 'Ingredients'),
(498, 379, 'Soup'),
(499, 380, 'Ingredients'),
(500, 381, 'Ingredients')")
		   or die(mysqli_error());
	

	}
	echo"
	<!-- //$t_recipes_groups -->

";
?>