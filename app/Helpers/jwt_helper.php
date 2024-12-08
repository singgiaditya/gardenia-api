<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT($userId, $secretKey = "f33d773ecfe9c9d74eed06e22453de42564508cab45e16d35a3469c3dd7edc9a94ad508cfcab1452962ae14efa702d2bf665dabbd72e5f86a492b23eeb03d18edc503d26ea6b3f75c220a6610d0f8ce116cc7909ae3e6a28b4562ccec51ec4c26fbddf3f6a3195ae19ea6a91404e2d64ba7c0073475d0866c5b7aeaa66fa4252c44ebb0f7b2625b0ef1b77406aea828f982ad6f80be00991de647fcb7cb5f36dd8ad465efe9838ae794d7c0554f7ae809e90d3871cce9aa0e5a67a2d4fed4dea415850b849c4ccfca48b261bd8d90b30eb4f407f9bdc0ce0257cf0f5da346963abd7e494f7a970214ffa104a1f0a9e0de103672b7b16d02a54dd3feae7f39019", $expiry = 3600)
{
    $payload = [
        'sub' => $userId,
        'iat' => time(),
    ];

    return JWT::encode($payload, $secretKey, 'HS256');
}

function decodeJWT($token, $secretKey = "f33d773ecfe9c9d74eed06e22453de42564508cab45e16d35a3469c3dd7edc9a94ad508cfcab1452962ae14efa702d2bf665dabbd72e5f86a492b23eeb03d18edc503d26ea6b3f75c220a6610d0f8ce116cc7909ae3e6a28b4562ccec51ec4c26fbddf3f6a3195ae19ea6a91404e2d64ba7c0073475d0866c5b7aeaa66fa4252c44ebb0f7b2625b0ef1b77406aea828f982ad6f80be00991de647fcb7cb5f36dd8ad465efe9838ae794d7c0554f7ae809e90d3871cce9aa0e5a67a2d4fed4dea415850b849c4ccfca48b261bd8d90b30eb4f407f9bdc0ce0257cf0f5da346963abd7e494f7a970214ffa104a1f0a9e0de103672b7b16d02a54dd3feae7f39019")
{
    try {
        return JWT::decode($token, new Key($secretKey, 'HS256'));
    } catch (Exception $e) {
        return null; // Token tidak valid
    }
}
