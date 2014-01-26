<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        // Truncate Table
        \Models\Category::truncate();

    	// $faker = \Faker\Factory::create();
        $categories = [
            'Appetizer',
            'Breakfast & Brunch',
            'Desserts',
            'Main Course',
            'Chicken',
            'Seafood',
            'Vegetarian',
            'Slow Cooker',
            'Holiday Treats',
            'Kids Meals',
            'One Dish Meals',
            'Pasta & Pizza',
            'Pies',
            'Pork',
            'Poultry',
            'Salads',            
            'Sandwiches & Wraps',
            'Sides',
            'Snacks',
            'Soups & Stews',
            'Beverages',
            'Beef',
            'Breads & Rolls',
            'Brownies, Bars & Candy',
            'Burgers, Brats, & Dogs',
            'Cakes & Cheesecake',
            'Cookies',
            'Dips, Spreads & Sauces',
            'Ethnic',
            'Fish & Seafood',
            'Grilling',
            'Healthy Eating',
        ]; 

        foreach($categories as $cat) {
            $tmp = array(
                'name' => $cat,
            );

            \Models\Category::create( $tmp );
        }
    	
    }
}