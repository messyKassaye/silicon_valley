<?php

namespace TaylorNetwork\UsernameGenerator;

trait FindSimilarUsernames
{
    /**
     * Find similar usernames.
     *
     * This assumes you are using Eloquent with Laravel, if not, override this
     * function in your class.
     *
     * @param $username
     *
     * @return mixed
     */
    public function findSimilarUsernames($username)
    {
        if (count($data = static::where(config('username_generator.column', 'username'), $username)->get()) === 0) {
            return $data;
        }

        return static::where(config('username_generator.column', 'username'), 'LIKE', $username.'%')->get();
    }
}
