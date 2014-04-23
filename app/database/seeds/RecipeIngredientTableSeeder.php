<?php

class RecipeIngredientTableSeeder extends Seeder {

    public function run()
    {
    	$recipe = \Models\Recipe::first();
        $unitOfMeasures = \Models\UnitOfMeasure::take(5)->get();
        $ingredients = \Models\Ingredient::take(5)->get();
        
        for ($i = 0; $i < 5; $i++) {
            
                $ri = new \Models\RecipeIngredient();
                $ri->quantity = 3.5;
                $ri->setUnitOfMeasure( $unitOfMeasures[$i] );
                $ri->setIngredient( $ingredients[$i] );
                $ri->setRecipe( $recipe );
                $ri->save();            
        }
    }
}