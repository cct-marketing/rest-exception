# REST Exception Handler

An exception handler using the decorator pattern to wrap the client requests from the REST lib and parse the server 
responses in correctly correctly form format exceptions based on api format

## Installation

```bash
composer require cct-marketing/rest-execption-handler
```

## Usage

```php
use CCT\Component\Rest\AbstractClient;
use CCT\Component\Rest\Config;

class RESTClient extends AbstractClient
{
    /**
     * @return ScrapeRequest
     */
    public function myAPI(): MyRequest
    {
        $config = clone $this->config;
        $modelClass = TestModel::class;

        $serializer = $this->getBuiltSerializer($config);
        if ($this->shouldUseDefaultResponseTransformers() && null !== $serializer) {
            $this->applyDefaultResponseTransformers($config, $serializer, $modelClass);
        }

        return $this->createRequestInstance(TestRequest::class, $config, null);
    }
}
```
