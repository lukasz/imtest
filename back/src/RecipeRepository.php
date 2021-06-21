<?php

namespace RecipeApi;

class RecipeRepository
{
    /**
     * Connection to the SQLite Database.
     * @var \PDO
     */
    private $dbConncection;

    /**
     * RecipeRepository constructor.
     */
    public function __construct()
    {
        $this->dbConncection = new \PDO('sqlite:sqlite-data/data.sqlite');
    }

    public function getFullRecipes(int $offset, int $limit): array
    {
        $recipes = $this->getRecipes($offset, $limit);
        $ids = [];
        foreach ($recipes as $recipe) {
            $ids[] = $recipe['id'];
        }
        $instructions = $this->getInstructions($ids);
        $ingredients = $this->getIngredients($ids);
        $responseData = [];
        foreach ($recipes as $key => $recipe) {
            $responseData[$recipe['id']]['name'] = $recipe['name'];
            $responseData[$recipe['id']]['description'] = $recipe['description'];
            $responseData[$recipe['id']]['servings'] = $recipe['servings'];
            $responseData[$recipe['id']]['thumbnail'] = $recipe['thumb'];
            $responseData[$recipe['id']]['duration'] = $recipe['time'];

            $responseData[$recipe['id']]['ingredients'] = [];
            $responseData[$recipe['id']]['instructions'] = [];

            foreach ($instructions as $instruction) {
                if ($instruction['recipe_id'] == $recipe['id']) {
                    $responseData[$recipe['id']]['instructions'][$instruction['position']] = [
                        'text' => $instruction['text'],
                        'appliance' => $instruction['appliance'],
                        'temperature' => $instruction['temperature'],
                    ];
                }
            }
            foreach ($ingredients as $ingredient) {
                if ($ingredient['recipe_id'] == $recipe['id']) {
                    $responseData[$recipe['id']]['ingredients'][] = [
                        'name' => $ingredient['name'],
                        'unit' => $ingredient['unitName'],
                        'quantity' => (float) $ingredient['quantity'],
                        'display' => $ingredient['text']
                    ];
                }
            }
        }
        return $responseData;
    }

    public function getRecipes(int $offset, int $limit): array
    {
        $stmt = $this->dbConncection->prepare('SELECT * FROM recipes LIMIT :offset, :limit');
        $stmt->execute([':offset' => $offset, ':limit' => $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInstructions(array $ids): array
    {
        // Cast to integers
        foreach ($ids as $key => $val) {
            $ids[$key] = (int) $val;
        }

        $ids = implode(',', $ids);
        $stmt = $this->dbConncection->query("SELECT * FROM instructions WHERE recipe_id IN ({$ids})");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIngredients(array $ids): array
    {
        // Cast to integers
        foreach ($ids as $key => $val) {
            $ids[$key] = (int) $val;
        }

        $ids = implode(',', $ids);
        $stmt = $this->dbConncection->query("SELECT * FROM ingredients WHERE recipe_id IN ({$ids})");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
