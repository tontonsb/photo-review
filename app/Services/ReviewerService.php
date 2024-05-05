<?php

namespace App\Services;

class ReviewerService
{
    protected const sessionKey = 'reviewer_token';
    protected const cookieKey = 'reviewer_token';

    public function cookieKey(): string
    {
        return static::cookieKey;
    }

    public function getCurrentToken(): string
    {
        if (session()->missing(static::sessionKey))
            $this->setToken();

        return session()->get(static::sessionKey);
    }

    protected function setToken(): void
    {
        session()->put(
            static::sessionKey,
            $this->getTokenFromCookie() ?? $this->newToken(),
        );
    }

    protected function getTokenFromCookie(): string|null
    {
        return request()->cookie(static::cookieKey);
    }

    protected function newToken(): string
    {
        return (string) \Str::uuid();
    }
}
