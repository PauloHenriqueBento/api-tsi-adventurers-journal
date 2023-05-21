<?php

namespace App\Policies;

use App\Models\Atividade;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AtividadePolicy
{

    public function view(User $user, Atividade $atividade)
    {
        // Verifica se o usuário é o dono da atividade
        if ($user->id === $atividade->idViajante) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Atividade $atividade): bool
    {
        return $user->id === $atividade->idViajante;
    }
}
