<?php

namespace App\Application\Service;

use App\Domain\Service\MessageServiceInterface;
use App\Entity\Translation;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;

class GCPMessageService implements MessageServiceInterface
{
    protected ?Topic $topic = null;

    public function __construct(string $gcp_topic, string $gcp_keyfile, string $project_dir)
    {
        try {
            $pubSub = new PubSubClient([
                'keyFilePath' => $project_dir.$gcp_keyfile,
            ]);
            $this->topic = $pubSub->topic($gcp_topic);
        } catch (GoogleException $exception) {
            // don't do anything yet ;)
            // todo log error
        }
    }

    public function publish(Translation $translation)
    {
        $this->topic?->publish([
            'data' => json_encode([
                'language' => $translation->getCountry(),
                'value' => $translation->getValue(),
                'code' => $translation->getCode(),
                'account' => $translation->getAccount()->getId(),
            ]),
        ]);
    }
}
