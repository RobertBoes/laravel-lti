<?php

namespace RobertBoes\LaravelLti\ToolProvider;

use IMSGlobal\LTI\ToolProvider\ToolConsumer as LTIToolConsumer;
use RobertBoes\LaravelLti\Exceptions\ToolConsumerInvalidCallException;
use RobertBoes\LaravelLti\Exceptions\ToolConsumerNotSetException;

/**
 * RobertBoes\LaravelLti\ToolProvider\ToolConsumer
 *
 * @property string $name
 * @property string $secret
 * @property string $ltiVersion
 * @property string $consumerName
 * @property string $consumerVersion
 * @property string $consumerGuid
 * @property string $cssPath
 * @property boolean $protected
 * @property boolean $enabled
 * @property int $enableFrom
 * @property int $lastAccess
 * @property int $idScope
 * @property string $defaultEmail
 * @property array $settings
 * @property int $created
 * @property int $updated
 * @property int $id
 * @property string $key
 * @property boolean $settingsChanged
 * @property mixed $dataConnector
 *
 * @method boolean save()
 * @method boolean delete()
 * @method int getRecordId()
 * @method void setRecordId($id)
 * @method string getKey()
 * @method void setKey($key)
 * @method mixed getDataConnector()
 * @method boolean getIsAvailable()
 * @method string getSetting($name, $default = '')
 * @method void setSetting($name, $value = null)
 * @method array getSettings()
 * @method void setSettings($settings)
 * @method boolean saveSettings()
 * @method boolean hasToolSettingsService()
 * @method mixed getToolSettings($simple = true)
 * @method boolean setToolSettings($settings = array())
 * @method array signParameters($url, $type, $version, $params)
 * @method mixed addSignature($endpoint, $consumerKey, $consumerSecret, $data, $method = 'POST', $type = null)
 * @method \IMSGlobal\LTI\HTTPMessage doServiceRequest($service, $method, $format, $data)
 */
class ToolConsumer extends ToolBase
{
    /**
     * @var \IMSGlobal\LTI\ToolProvider\ToolConsumer
     */
    private $consumer;

    /**
     * Create a new LTI ToolConsumer
     * @param string $key
     * @return $this
     */
    public function create($key = '')
    {
        $this->consumer = new LTIToolConsumer($key, $this->dataConnector());
        return $this;
    }

    public function fromRecordId($id)
    {
        $this->consumer = LTIToolConsumer::fromRecordId($id, $this->dataConnector());
    }

    private function checkValidConsumerCall($property = null, $method = null)
    {
        if( !($this->consumer instanceof LTIToolConsumer) ) {
            throw new ToolConsumerNotSetException();
        }

        if( !is_null($property) && !property_exists($this->consumer, $property) ) {
            throw new ToolConsumerInvalidCallException();
        }

        if( !is_null($method) && !method_exists($this->consumer, $method) ) {
            throw new ToolConsumerInvalidCallException();
        }
    }

    public function __get($name)
    {
        $this->checkValidConsumerCall($name);
        return $this->consumer->{$name};
    }

    public function __set($name, $value)
    {
        $this->checkValidConsumerCall($name);
        $this->consumer->{$name} = $value;
    }

    public function __call($method, $parameters) {
        $this->checkValidConsumerCall(null, $method);
        return $this->consumer->$method(...$parameters);
    }
}
