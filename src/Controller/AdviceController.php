<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\RaceManager;

/**
 * Class AdviceController
 *
 */
class AdviceController extends AbstractController
{
    public function show($id = null)
    {
        $races = new RaceManager();
        if ($id === null) {
            $firstRace = $races->selectFirstRace();
            $id = $firstRace['id'];
        }

        $allInAnimals = $races->selectAllInAnimals();
        $race = $races->selectOneById($id);

        foreach ($allInAnimals as $animal) {
            $groupedAnimals[$animal['animal']][$animal['category']][] =
                ['race_name' => $animal['race_name'], 'animal_id' => $animal['id']];
        }

        return $this->twig->render('Advice/show.html.twig', [
            'groupedAnimals' => $groupedAnimals ?? [],
            'race' => $race ?? []
        ]);
    }
}
