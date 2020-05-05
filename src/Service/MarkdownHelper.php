<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownHelper
{
    private $cache;
    private $markdown;
    private $logger;
    private $isDebug;
    private $security;

    public function __construct(AdapterInterface $cache, 
                                MarkdownInterface $markdown, 
                                LoggerInterface $markdownLogger, 
                                bool $isDebug, 
                                Security $security)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
        $this->security=$security;
    }

    public function parse(string $source): string
    {
        if (stripos($source, 'bacon') !== false) {
            //Unrelated to security, every method on the logger, 
            //like info(), debug() or alert(), has two arguments. 
            //The first is the message string. The second is an optional array called a "context". 
            //This is just an array of any extra info that you want to include with the log message.
            $this->logger->info('They are talking about bacon again!',[
                'user'=> $this->security->getUser()
            ]);
        }

        // skip caching entirely in debug
        if ($this->isDebug) {
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_'.md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
