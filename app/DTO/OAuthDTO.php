<?php

namespace App\DTO;

class OAuthDTO
{

    public function __construct(
        // 'slack', 'github', etc.
        public readonly string $provider,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $avatar = null,
        public readonly string $access_token,
        public readonly ?string $refresh_token = null,
        public readonly ?string $expires_at = null,

        // access, refresh, expires_at
        public readonly array $attributes = [],

    ) {
    }
}