<?php

namespace App\Application\Service;

use App\Domain\Service\MessageServiceInterface;
use App\Entity\Translation;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;

class GCPMessageService implements MessageServiceInterface
{
    protected Topic $topic;

    public function __construct(string $gcp_topic, string $gcp_keyfile, string $project_dir)
    {
        $pubSub = new PubSubClient([
            'keyFilePath' => $project_dir.$gcp_keyfile
        ]);
        $this->topic = $pubSub->topic($gcp_topic);
    }

    public function publish(Translation $translation)
    {
        $this->topic->publish([
            'data' => json_encode([
                'Src' => $translation->getCountry(),
                'Val' => $translation->getValue(),
                'Key' => $translation->getCode(),
                'Acc' => $translation->getAccount()->getId(),
            ]),
        ]);
    }
}