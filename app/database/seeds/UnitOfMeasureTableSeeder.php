<?php

class UnitOfMeasureTableSeeder extends Seeder {

    public function run()
    {
    	$units_of_measure = array(
    		array('name' => 'teaspoon', 'alias' => 't, tsp', 'preferred_alias' => 'tsp'),
    		array('name' => 'tablespoon', 'alias' => 'T, tbl, tbs, tbsp', 'preferred_alias' => 'tbsp'),
    		array('name' => 'fluid ounce', 'alias' => 'fl oz', 'preferred_alias' => 'fl oz'),
    		array('name' => 'gill', 'alias' => 'about 1/2 cup', 'preferred_alias' => '1/2 cup'),
    		array('name' => 'cup', 'alias' => 'c', 'preferred_alias' => 'cup'),
    		array('name' => 'pint', 'alias' => 'p, pt, fl pt', 'preferred_alias' => 'pint'),
    		array('name' => 'quart', 'alias' => 'q, qt, fl qt, qrt', 'preferred_alias' => 'quart'),
    		array('name' => 'gallon', 'alias' => 'g, gal', 'preferred_alias' => 'gal'),
    		array('name' => 'ml', 'alias' => 'milliliter, millilitre, cc, mL', 'preferred_alias' => 'ml'),
    		array('name' => 'l', 'alias' => 'liter, litre, L', 'preferred_alias' => 'l'),
    		array('name' => 'dl', 'alias' => 'deciliter, decilitre, dL', 'preferred_alias' => 'dl'),
    		array('name' => 'pound', 'alias' => 'lb, #', 'preferred_alias' => 'lb'),
    		array('name' => 'ounce', 'alias' => 'oz', 'preferred_alias' => 'oz'),
    		array('name' => 'μg', 'alias' => 'microgram, microgramme, mcg, ug', 'preferred_alias' => 'μg'),
    		array('name' => 'mg', 'alias' => 'milligram, milligramme', 'preferred_alias' => 'mg'),
    		array('name' => 'g', 'alias' => 'gram, gramme', 'preferred_alias' => 'g'),
    		array('name' => 'kg', 'alias' => 'kilogram, kilogramme', 'preferred_alias' => 'kg'),
    		array('name' => 'mm', 'alias' => 'millimeter, millimetre', 'preferred_alias' => 'mm'),
    		array('name' => 'cm', 'alias' => 'centimeter, centimetre', 'preferred_alias' => 'cm'),
    		array('name' => 'm', 'alias' => 'meter, metre', 'preferred_alias' => 'm'),
    		array('name' => 'inch', 'alias' => 'in', 'preferred_alias' => 'in'),
    		array('name' => 'pinch', 'alias' => '', 'preferred_alias' => 'pinch'),
    	);

    	foreach($units_of_measure as $unit) {
	    	$tmp = array(
				'name'            => $unit["name"],
				'alias'           => $unit["alias"],
				'preferred_alias' => $unit["preferred_alias"],
	    	);

	    	$uom = new \Models\UnitOfMeasure( $tmp );
	    	$uom->save();
    	}
    }
}