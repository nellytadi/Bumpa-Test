<?php

return [
    'publicKey' => getenv('PAYSTACK_PUBLIC_KEY'),
    'secretKey' => getenv('PAYSTACK_SECRET_KEY'),
    'baseUrl' => getenv('PAYSTACK_PAYMENT_URL'),
];
