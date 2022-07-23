<?php
namespace App\Controllers;

use App\Models\CryptoAsset;
use App\Views\TwigView;

class CryptoAssetController
{
    public function index(): TwigView
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: d757921a-fea5-446d-9304-d62437d79dac'
        ];
        $qs = http_build_query($parameters);
        $request = "{$url}?{$qs}";


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $request,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $response = curl_exec($curl);
        $assets = json_decode($response);
        curl_close($curl);

        $cryptoAssets = [];

        foreach ($assets->data as $asset) {
            $cryptoAssets[] = new CryptoAsset(
                $asset->name,
                $asset->symbol,
                $asset->quote->USD->price
            );
        }

        return new TwigView('crypto-assets-index.html', ['assets' => $cryptoAssets]);
    }
}
