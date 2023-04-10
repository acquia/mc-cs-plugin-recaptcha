<?php


namespace MauticPlugin\MauticRecaptchaBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Mautic\PluginBundle\Integration\AbstractIntegration;
use MauticPlugin\MauticRecaptchaBundle\Integration\RecaptchaIntegration;

class RecaptchaClient
{
    public const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var string
     */
    protected $siteKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * FormSubscriber constructor.
     */
    public function __construct(IntegrationHelper $integrationHelper)
    {
        $integrationObject = $integrationHelper->getIntegrationObject(RecaptchaIntegration::INTEGRATION_NAME);

        if ($integrationObject instanceof AbstractIntegration) {
            $keys            = $integrationObject->getKeys();
            $this->siteKey   = isset($keys['site_key']) ? $keys['site_key'] : null;
            $this->secretKey = isset($keys['secret_key']) ? $keys['secret_key'] : null;
        }
    }

    /**
     * @param string $response
     *
     * @return bool
     */
    public function verify($response)
    {
        $client   = new GuzzleClient(['timeout' => 10]);
        $response = $client->post(
            self::VERIFY_URL,
            [
                'form_params' => [
                    'secret'   => $this->secretKey,
                    'response' => $response,
                ],
            ]
        );

        $response = json_decode($response->getBody(), true);
        if (array_key_exists('success', $response) && true === $response['success']) {
            return true;
        }

        return false;
    }
}
