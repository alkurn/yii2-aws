AWS SDK for Yii2 - Use Amazon Web Services in your Yii2 project
===============================================================
This extension provides the AWS SDK 3 integration for the Yii2 framework

[![Latest Stable Version](https://poser.pugx.org/alkurn/yii2-aws/v/stable)](https://packagist.org/packages/alkurn/yii2-aws) [![Total Downloads](https://poser.pugx.org/alkurn/yii2-aws/downloads)](https://packagist.org/packages/alkurn/yii2-aws) [![Latest Unstable Version](https://poser.pugx.org/alkurn/yii2-aws/v/unstable)](https://packagist.org/packages/alkurn/yii2-aws) [![License](https://poser.pugx.org/alkurn/yii2-aws/license)](https://packagist.org/packages/alkurn/yii2-aws)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist alkurn/yii2-aws "*"
```

or add

```
"alkurn/yii2-aws": "*"
```

to the require section of your `composer.json` file.

```
Note: You can still use AWS version 2 if you specify alkurn/yii2-aws "1.*"
```

Usage
-----

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        's3' => [
            'class' => 'alkurn\aws\S3',
            'credentials' => [ //you can use a different method to grant access
                'key' => 'your-aws-key',
                'secret' => 'your-aws-secret',
            ],
            'region' => 'your-aws-region', //i.e.: 'us-east-1'
            'version' => 'your-aws-version', //i.e.: 'latest'
        ],
    ],
];
```

Getting all balancer names from AWS:

```php
$aws = Yii::$app->s3->getS3();
$elb = $aws->createElasticloadbalancing();
$load_balancers = $elb->describeLoadBalancers()->toArray();
if (isset($load_balancers['LoadBalancerDescriptions'])){
    foreach ($load_balancers['LoadBalancerDescriptions'] as $balancer){
        if (isset($balancer['LoadBalancerName'])){ 
            echo $balancer['LoadBalancerName'];
        }
    }
}
```

Download an object from S3:
```php
//specify the region if it is different than the main configuration region
Yii::$app->awssdk->region = 'sa-east-1';
$aws = Yii::$app->s3->getS3();

//use s3
$s3 = $aws->createS3();
$result = $s3->listObjects(['Bucket' => 'your-bucket-id',"Prefix" => "your-path"])->toArray();
//get the last object from s3
$object = end($result['Contents']);
$key = $object['Key'];
$file = $s3->getObject([
    'Bucket' => 'your-bucket-id',
    'Key' => $key
]);
//download the file
header('Content-Type: ' . $file['ContentType']);
echo $file['Body'];
```
