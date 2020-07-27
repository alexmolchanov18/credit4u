<?php

class Autorotator
{
    const API_TOKEN  = "702601a103e074162cfd49e3e1e16024";
    const REMOTE_URL = "https://api.smartmoney.best/autorotator/%s/offers/statistics/%s/";
    const OPTION_ID_STATISTICS = "tid1";
    const HIDE_CLASS = "hide_block";
    
    private $_url;
    private $_offers;
    private $_idSettings;
    private $_remoteOffers;
    
    public function __construct($idSettings, $offers, $url = null)
    {
        if (!$idSettings) {
            throw new Exception("ID Settings Must be Not Empty");
        }
        
        if (!$offers) {
            throw new Exception("Offers Must be Not Empty");
        }
        
        if (!$url) {
            $url = static::REMOTE_URL;
        }
        
        $this->_url = $url;
        $this->_offers = $offers;
        $this->_idSettings = $idSettings;
        
        $this->sendRequest();
    } // end __construct
    
    public function sendRequest()
    {
        $idStatistics = $this->_getStatisticsID();
        
        if (!$idStatistics) {
            return false;
        }
        
        $url = sprintf($this->_url, $this->_idSettings, $idStatistics);
        
        $data = array(
            'offers' => $this->_offers
        );
        $query = http_build_query($data);
        $url .="?".$query;
        
        $opts = array(
            'http' => array(
                'method'  => 'GET',
                'header'  => 'Access-Token: '.static::API_TOKEN
            )
        );
        
        $context = stream_context_create($opts);
        
        $result = file_get_contents($url, false, $context);
        
        if (!$result) {
            return null;
        }
        
        $resultData = json_decode($result, true);
        
        if (empty($resultData['offers'])) {
            return null;
        }
        
        $offers = $resultData['offers'];

        $this->_remoteOffers = $offers;
        
        return $offers;
    } // end sendRequest
    
    public function displayHideClass($offerCode)
    {
        if ($this->_remoteOffers && !in_array($offerCode ,$this->_remoteOffers)) {
            echo static::HIDE_CLASS;
            return;
        }
        return;
    } //end displayHideClass
    
    private function _getStatisticsID()
    {
        if (!empty($_REQUEST[static::OPTION_ID_STATISTICS])) {
            return $_REQUEST[static::OPTION_ID_STATISTICS];
        }
        
        return null;
    } // end _getStatisticsID
}