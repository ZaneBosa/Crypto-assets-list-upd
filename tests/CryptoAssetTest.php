<?php

test('weather model', function () {
    $weather = new \App\Models\CryptoAsset(
        'Ethereum',
        'ETH',
        1550.743262273
    );

    expect($weather->getName())->toBe('Ethereum');
    expect($weather->getSymbol())->toBe('ETH');
    expect($weather->getPrice())->toBe(1550.743262273);
});