<?php

require_once __DIR__.'/Autorotator.php';

class OffersAPI
{
    const SETTINGS_PATH = __DIR__.'/settings.json';
    const OFFER_DIR     = __DIR__.'/offers/';
    const REMOTE_URL    = 'https://dev2.api.smartmoney.best/offers/';
    const OFFER_URL     = 'https://smartmoney.best/storages/offers/';

    private $_token;
    private $_style;
    private $_idAutorotator;

    private $_autorotator = null;
    
    public function __construct()
    {
        $settings = $this->_getSettings();

        $this->_createDirs();

        $this->_token         = $settings['token'];
        $this->_style         = $settings['style'];
        $this->_idAutorotator = $settings['autorotator_id'];
    }

    private function _createDirs()
    {
        if (!file_exists(__DIR__.'/offers') || !is_dir(__DIR__.'/offers')) {
            mkdir(__DIR__.'/offers');
            chmod(__DIR__.'/offers', 0775);
        }

        if (!file_exists(__DIR__.'/cache') || !is_dir(__DIR__.'/cache')) {
            mkdir(__DIR__.'/cache');
            chmod(__DIR__.'/cache', 0775);

            file_put_contents(
                __DIR__.'/cache/offers.json',
                json_encode(array())
            );

            chmod(__DIR__.'/cache/offers.json', 0775);
        }
    }

    private function _getSettings()
    {
        if (
            !file_exists(static::SETTINGS_PATH) ||
            !is_file(static::SETTINGS_PATH)
        ) {
            throw new Exception('Offers API Settings File Is Not Exists'); 
        }

        $settings = file_get_contents(static::SETTINGS_PATH);
        $settings = (array) json_decode($settings, true);

        if (empty($settings) || !is_array($settings)) {
            throw new Exception('Offers API Settings Has Bad Format');
        }

        if (
            !array_key_exists('token', $settings) ||
            !is_scalar($settings['token'])
        ) {
            $errorMessage = 'Offers API Token Is Not Set Or Has Bad Format';
            throw new Exception($errorMessage);
        }

        if (
            !array_key_exists('style', $settings) ||
            !is_scalar($settings['style'])
        ) {
            $errorMessage = 'Offers API Style Is Not Set Or Has Bad Format';
            throw new Exception($errorMessage);
        }

        if (
            !array_key_exists('autorotator_id', $settings) ||
            !is_scalar($settings['autorotator_id'])
        ) {
            $settings['autorotator_id'] = -1;
        }

        $settings['autorotator_id'] = (int) $settings['autorotator_id'];

        return $settings;
    }

    public function displayOffers()
    {
        $offers = $this->_getOffers();

        $offersIDs    = $this->_getOffersIDs($offers);
        $minOffersIDs = $offersIDs;

        if (count($minOffersIDs) > 3) {
            $minOffersIDs = array_slice($offersIDs, 0, 3);
        }

        if ($this->_idAutorotator > 0 && !empty($offersIDs)) {
            $this->_autorotator = new Autorotator(
                $this->_idAutorotator,
                $offersIDs
            );

            $offersIDs = $this->_autorotator->getRemoteOffers();

            if (empty($offersIDs)) {
                $offersIDs = $minOffersIDs;
            }
        }

        foreach ($offersIDs as $idOffer) {
            $this->_displayOffer($idOffer);
        }
    }

    private function _getOffersIDs($offers)
    {
        $offersIDs = [];

        foreach ($offers as $offer) {
            $offersIDs[] = $offer['id_offer_group'];
        }

        return $offersIDs;
    }

    private function _displayOffer($idOffer)
    {
        $offerFile = sprintf(
            '%s/%s.php',
            static::OFFER_DIR,
            $idOffer
        );

        $offerURL = sprintf(
            '%s%s/%s.html',
            static::OFFER_URL,
            $this->_style,
            $idOffer
        );

        if (!file_exists($offerFile) || !is_file($offerFile)) {
            $offerContent = file_get_contents($offerURL);
            file_put_contents($offerFile, $offerContent);
        }

        include $offerFile;
    }

    private function _getOffers()
    {
        $offers = $this->_getOffersFromSourceCache();

        try {
            if (!empty($offers)) {
                return $offers;
            }

            $requestOptions  = $this->_getRequestOptions();

            $curl = curl_init();
            curl_setopt_array($curl, $requestOptions);

            $response     = (string) curl_exec($curl);
            $curlError    = (string) curl_error($curl);
            $responseCode = (int)    curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if (!empty($curlError)) {
                throw new Exception($curlError);
            }

            if ($responseCode != 200) {
                $responseCode = (string) $responseCode;

                $errorMessage = 'Remote Server Error #'.$responseCode;

                if (!empty($response)) {
                    $errorMessage = $errorMessage.' Response Message: '.
                                    $response;
                }

                throw new Exception($errorMessage);
            }

            if (empty($response)) {
                throw new Exception('Remote Server Has Bad Response');
            }

            $response = (array) json_decode($response, true);

            if (!array_key_exists('content', $response)) {
                throw new Exception('Empty Content');
            }

            $response = $response['content'];

            if (!is_array($response)) {
                throw new Exception('Empty Content');
            }

            if (!array_key_exists('offers', $response)) {
                throw new Exception('Offers');
            }

            $offers = $response['offers'];
            $offers = (array) json_decode($offers, true);

            if (empty($offers)) {
                throw new Exception('Offers');
            }

        } catch (Exception $e) {
            return $this->_getOffersFromCache();
        }

        $source = $this->_getSource();

        if (empty($source)) {
            $source = 'source';

            unlink(__DIR__.'/cache/offers.json');
            file_put_contents(
                __DIR__.'/cache/offers.json',
                json_encode($offers)
            );
        }

        if (
            file_exists(__DIR__.'/cache/'.$source.'.json') &&
            is_file(__DIR__.'/cache/'.$source.'.json')
        ) {
            unlink(__DIR__.'/cache/'.$source.'.json');        
        }

        $offersData = array(
            'time'   => time(),
            'offers' => $offers
        );

        $offersData = json_encode($offersData);

        file_put_contents(__DIR__.'/cache/'.$source.'.json', $offersData);

        return $offers;
    }

    private function _getOffersFromCache()
    {
        $offers = file_get_contents(__DIR__.'/cache/offers.json');

        return (array) json_decode($offers, true);
    }

    private function _getOffersFromSourceCache()
    {
        $source = $this->_getSource();

        if (empty($source)) {
            $source = 'source';
        }

        if (
            !file_exists(__DIR__.'/cache/'.$source.'.json') ||
            !is_file(__DIR__.'/cache/'.$source.'.json')
        ) {
            return array();
        }

        $offersData = file_get_contents(__DIR__.'/cache/'.$source.'.json');
        $offersData = (array) json_decode($offersData, true);

        if (!$this->_isValidOffersCache($offersData)) {
            return array();
        }

        return (array) $offersData['offers'];
    }

    private function _isValidOffersCache($offersData)
    {
        if (!is_array($offersData)) {
            return false;
        }

        if (!array_key_exists('time', $offersData)) {
            return false;
        }

        if (!array_key_exists('offers', $offersData)) {
            return false;
        }

        $time   = $offersData['time'];
        $offers = $offersData['offers'];

        if ($time < time() - 60 * 60 * 8) {
            return false;
        }

        if (empty($offers)) {
            return false;
        }

        if (!is_array($offers)) {
            return false;
        }

        return true;
    }

    private function _getRequestOptions()
    {
        return array(
            CURLOPT_URL            => static::REMOTE_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $this->_getPreparedRequestValues(),
            CURLOPT_HTTPHEADER     => $this->_getHTTPHeaders()
        );
    }

    private function _getPreparedRequestValues()
    {
        return array(
            'access-token' => $this->_token,
            'source'       => $this->_getSource()
        );
    }

    private function _getHTTPHeaders()
    {
        return array(
            "Content-Type: multipart/form-data",
            "cache-control: no-cache"
        );
    }

    private function _getSource()
    {
        if (
            array_key_exists('source', $_GET) &&
            is_scalar($_GET['source']) &&
            !empty($_GET['source'])
        ) {
            return $this->_escapeInput($_GET['source']);
        }

        if (
            array_key_exists('utm_source', $_GET) &&
            is_scalar($_GET['utm_source']) &&
            !empty($_GET['utm_source'])
        ) {
            return $this->_escapeInput($_GET['utm_source']);
        }

        return null;
    }

    private function _escapeInput($input) {
        return preg_replace('/([^a-zA-Z0-9-_]+)/su', '', $input);
    }
}
