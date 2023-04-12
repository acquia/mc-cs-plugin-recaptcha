<?php

namespace MauticPlugin\MauticRecaptchaBundle\Tests;

use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticRecaptchaBundle\Integration\RecaptchaIntegration;
use MauticPlugin\MauticRecaptchaBundle\Service\RecaptchaClient;

class RecaptchaClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PHPUnit\Framework\MockObject\MockBuilder|IntegrationHelper
     */
    private $integrationHelper;

    /**
     * @var PHPUnit\Framework\MockObject\MockBuilder|RecaptchaIntegration
     */
    private $integration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->integrationHelper = $this->createMock(IntegrationHelper::class);
        $this->integration       = $this->createMock(RecaptchaIntegration::class);
    }

    public function testVerifyWhenPluginIsNotInstalled()
    {
        $this->integrationHelper->expects($this->once())
            ->method('getIntegrationObject')
            ->willReturn(null);

        $this->integration->expects($this->never())
            ->method('getKeys');

        $this->createRecaptchaClient()->verify('');
    }

    public function testVerifyWhenPluginIsNotConfigured()
    {
        $this->integrationHelper->expects($this->once())
            ->method('getIntegrationObject')
            ->willReturn($this->integration);

        $this->integration->expects($this->once())
            ->method('getKeys')
            ->willReturn(['site_key' => 'test', 'secret_key' => 'test']);

        $this->createRecaptchaClient()->verify('');
    }

    /**
     * @return RecaptchaClient
     */
    private function createRecaptchaClient()
    {
        return new RecaptchaClient(
            $this->integrationHelper
        );
    }
}
