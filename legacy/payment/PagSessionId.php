<?php
require_once 'PagSeguroLibrary/PagSeguroLibrary.php';

class PagSeguroUtil
{
  public static function getSessionId()
  {
    try {
      return PagSeguroSessionService::getSession(PagSeguroConfig::getAccountCredentials());
    } catch (PagSeguroServiceException $e) {
      return false;
    }
  }
}