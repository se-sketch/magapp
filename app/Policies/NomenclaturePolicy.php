<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Nomenclature;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class NomenclaturePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any nomenclatures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Gate::allows('nomenclature-settings');
    }

    /**
     * Determine whether the user can view the nomenclature.
     *
     * @param  \App\User  $user
     * @param  \App\Nomenclature  $nomenclature
     * @return mixed
     */
    public function view(User $user, Nomenclature $nomenclature)
    {
        return Gate::allows('nomenclature-settings');
    }

    /**
     * Determine whether the user can create nomenclatures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Gate::allows('nomenclature-settings');
    }

    /**
     * Determine whether the user can update the nomenclature.
     *
     * @param  \App\User  $user
     * @param  \App\Nomenclature  $nomenclature
     * @return mixed
     */
    public function update(User $user, Nomenclature $nomenclature)
    {
        return Gate::allows('nomenclature-settings');
    }

    /**
     * Determine whether the user can delete the nomenclature.
     *
     * @param  \App\User  $user
     * @param  \App\Nomenclature  $nomenclature
     * @return mixed
     */
    public function delete(User $user, Nomenclature $nomenclature)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the nomenclature.
     *
     * @param  \App\User  $user
     * @param  \App\Nomenclature  $nomenclature
     * @return mixed
     */
    public function restore(User $user, Nomenclature $nomenclature)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the nomenclature.
     *
     * @param  \App\User  $user
     * @param  \App\Nomenclature  $nomenclature
     * @return mixed
     */
    public function forceDelete(User $user, Nomenclature $nomenclature)
    {
        return false;
    }
}
