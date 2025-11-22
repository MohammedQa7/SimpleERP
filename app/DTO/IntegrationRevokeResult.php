<?php

namespace App\DTO;

class IntegrationRevokeResult
{

    public function __construct(
        public readonly ?bool $status = null,
        public readonly ?string $code = null,
        public readonly ?string $message = null,
    ) {
    }
}