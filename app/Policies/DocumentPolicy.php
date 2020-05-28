<?php

namespace App\Policies;

use App\Models\DocType;
use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return !$user->isAdmin();
    }

    /**
     * Determine whether the user can fill the docType
     *
     * @param User    $user
     * @param DocType $docType
     *
     * @return mixed
     */
    public function fill(User $user, DocType $docType)
    {
        return $docType->createRoles->contains($user->creator);
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        return $document->author->id == $user->employee->id;
    }

    /**
     * Determine whether the user can approve the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function approve(User $user, Document $document)
    {
        return $document->waiting->id == $user->employee->id;
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param User   $user
     * @param string $docType
     *
     * @return mixed
     */
    public function create(User $user, $docType)
    {
        return DocType::find($docType)->createRoles->contains($user->creator);
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        return $document->waiting->id == $user->employee->id;
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return $document->author->id == $user->employee->id;
    }

    /**
     * Determine whether the user can restore the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function restore(User $user, Document $document)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the document.
     *
     * @param User     $user
     * @param Document $document
     *
     * @return mixed
     */
    public function forceDelete(User $user, Document $document)
    {
        return $user->isAdmin();
    }
}
