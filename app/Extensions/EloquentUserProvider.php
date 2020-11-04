<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider as CoreUserProvider;
use Illuminate\Support\Str;

class EloquentUserProvider extends CoreUserProvider
{
	/**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            Str::contains($this->firstCredentialKey($credentials), 'password'))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        \Log::debug("Loop de credenciais:");
        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password')) {
                continue;
            }

            \Log::debug(sprintf("%s => %s", $key, $value));

        	$document = \App\Document::where('number', $value)->first();

        	\Log::debug("--- documento encontrado: " . !is_null($document));

        	if($document)
        	{
                \Log::debug(json_encode($document->user));
        		return $document->user;
        	}

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }
}