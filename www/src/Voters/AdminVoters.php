<?php


namespace App\Voters;


use App\Core\Interfaces\VoterInterface;

class AdminVoters implements VoterInterface
{

    /**
     * @return array
     */
    public function init(): array
    {
        return [
            "name" => "admin_voter",
            "namespace" => "App\Controllers\Admin"
        ];
    }

    /**
     * @return bool
     */
    public function run(): bool
    {
        // TODO: Definir l'impémentation
    }
}