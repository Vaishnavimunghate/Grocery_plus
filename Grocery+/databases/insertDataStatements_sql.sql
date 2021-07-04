insert into user values(
	"abc@gmail.com", "abc123456", "5896532147", "abc");
    
INSERT INTO xx_BLOB(ID,IMAGE) VALUES(1,LOAD_FILE('E:/Images/jack.jpg'));

-- change path to absolute path to store images 
 
insert into product values 
			('OGT0100001','Baby Wipes-Gentle baby(72pcs)',184.00,
             load_file('data/baby_care/name_himalaya_baby_wipes_gentle_baby_72pcs_brand_himalaya_baby_price_184_offer_0.png'),
             'Himalaya',14,2),
            ('OGT0100002','No more tears Baby Shampoo(500ml)',360.00,
             load_file('data/baby_care/name_johnsons_baby_no_more_tears_baby_shampoo_500ml_brand_johnsons_baby_price_360_offer_22_reduced_price_280.png'),
             'Johnsons baby',10,2), 
			('OGT0100003','Baby Cereal(300g)',264.00,
             load_file('data/baby_care/name_nestle_cerelac_baby_cereal_with_milk_multigrain_and_fruits_300g_brand_nestle_price_264_offer_0.png'),
             'Nestle',14,6),
            ('OGT0200001','Amul Butter(100g)',48.00,
             load_file('data/bakery_cakes_and_diary/name_amul_butter_100g_brand_amul_price_48_offer_1_reduced_price_47.52.png'),
             'Amul',14,6),
			('OGT0200002','Britannia bake rusk toast(72g)',10.00,
             load_file('data/bakery_cakes_and_diary/name_britannia_bake_rusk_toast_72g_brand_britannia_price_10_offer_0.png'),
             'Britannia',54,1),
            ('OGT0300001','Chocolate Health Drink(500g)',209.00,
             load_file('data/bevarges/name_bournvita_chocolate_health_drink_500g_brand_bournvita_price_209_offer_10_reduced_price_187.10.png'),
             'Bournvita',74,2),
			('OGT0300002','100% Natural Cocunut Water(12x200ml)',720.00,
             load_file('data/bevarges/name_raw_pressary_100_natural_cocunut_water_12x200ml_multipack_brand_raw_pressery_price_720_offer_0.png'),
             'Raw Pressary',154,10), 
             ('OGT0300003','Real, Cranberry Juice(1L)',115.00,
             load_file('data/bevarges/name_real_juice_fruit_power_cranberry_1l_brand_real_price_115_offer_11_reduced_price_101.97.png'),
             'Real',64,3),
			('OGT0300004','Red Label Tea(250g)',140.00,
             load_file('data/bevarges/name_red_label_tea_250g_brand_red_label_price_140_offer_0.png'),
             'Red Label',94,5),
             ('OGT0400001','Aashirvaad atta - Whole wheat(10kg)',490.00,
             load_file('data/food_grains_oil_and_masala/name_aashirvaad_atta_whole_wheat_10kg_pouch_brand_aashirvaad_price_490_offer_21_reduced_price_387.png'),
             'Aashirvaad',74,2),
			('OGT0400002','100% Sunflower Refined Oil(1L)',183.00,
             load_file('data/food_grains_oil_and_masala/name_fortune_sun_lite_sunflower_refined_oil_1l_pouch_brand_fortune_price_183_offer_7.6_reduced_price_169.png'),
             'Fortune',154,8), 
             ('OGT0400003','Real, Brown Chana(220g)',80.00,
             load_file('data/food_grains_oil_and_masala/name_tadaa_brown_chana_naturally_steamed_220g_brand_tadaa_price_80_offer_0.png'),
             'Tadaa',64,3), 
             ('OGT0500001','Banganapalli Mango(1kg)',125.00,
             load_file('data/fruits_and_vegetables/name_fresho_banganapalli_mango_1kg_brand_fresho_price_125_offer_20_reduced_price_100.png'),
             'Fresho',74,2),
			('OGT0500002','Onion(1kg)',28.75,
             load_file('data/fruits_and_vegetables/name_fresho_onion_1kg_brand_fresho_price_28.75_offer_35_reduced_price_18.81.png'),
             'Fresho',154,8), 
             ('OGT0500003','Palak(100g)',11.25,
             load_file('data//fruits_and_vegetables/name_fresho_palak_100g_brand_fresho_price_11.25_offer_20_reduced_price_9.png'),
             'Fresho',64,3),
             ('OGT0600001','Sweet Corn Kernels(150g)',50.00,
             load_file('data/snacks_and_branded_foods/name_supa_corn_sweet_corn_kernels_150g_brand_supa_corn_price_50_offer_0.png'),
             'Supa Corn',74,2) ;
 
select * from product; 
             