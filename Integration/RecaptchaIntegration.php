<?php


namespace MauticPlugin\MauticRecaptchaBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class RecaptchaIntegration.
 */
class RecaptchaIntegration extends AbstractIntegration
{
    public const INTEGRATION_NAME = 'Recaptcha';

    public function getName()
    {
        return self::INTEGRATION_NAME;
    }

    public function getDisplayName()
    {
        return 'reCAPTCHA';
    }

    public function getAuthenticationType()
    {
        return 'none';
    }

    public function getRequiredKeyFields()
    {
        return [
            'site_key'   => 'mautic.integration.recaptcha.site_key',
            'secret_key' => 'mautic.integration.recaptcha.secret_key',
        ];
    }
}
