<?php

namespace app\component\Parser\AutoRu;

use app\component\Parser\AutoRu\Interfaces\AutoParserServiceInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AutoParserService
 */
class AutoParserService implements AutoParserServiceInterface
{
    private $urls = [
        'https://auto.ru/htmlsitemap/mark_model_tech_1.html',
        'https://auto.ru/htmlsitemap/mark_model_tech_2.html',
        'https://auto.ru/htmlsitemap/mark_model_tech_3.html',
        'https://auto.ru/htmlsitemap/mark_model_tech_4.html',
        'https://auto.ru/htmlsitemap/mark_model_tech_5.html',
        'https://auto.ru/htmlsitemap/mark_model_tech_6.html',
    ];
    
    public function execute(): array
    {
        foreach ($this->urls as $url) {
            $html = file_get_contents($url);
            $crawler = new Crawler($html);
            $links = $crawler->filter('.sitemap div > a');
            $items = [];
            foreach ($links as $linkNode) {
                preg_match('/(?<mark>.*),(?<pokolenie>.*), (?<body>.*), (?<fuel>.*), (?<modif>.*)/', $linkNode->nodeValue, $matches);
                
                $mark = isset($matches['mark']) ? $this->getMark($matches['mark']) : null;
                if ($mark) {
                    $items[] = [
                        'mark'      => $mark,
                        'model'     => $this->getModel($matches['mark']),
                        'pokolenie' => $matches['pokolenie'],
                        'body'      => $matches['body'],
                        'fuel'      => $matches['fuel'],
                        'modif'     => $matches['modif'],
                    ];
                }
            }
            
            return $items;
        }
    }
    
    private function getMark(string $str): string
    {
        $customMarks = [
            'Alfa Romeo',
            'Great Wall',
            'BYD Auto',
            'Ssang Yong',
            'Land Rover',
        ];
        $data = array_map('trim', explode(' ', $str));
        if (in_array($data[0] . ' ' . $data[1], $customMarks)) {
            return $data[0] . ' ' . $data[1];
        }
        
        sort($data);
        
        return $data[0];
    }
    
    private function getModel(string $str): string
    {
        $customMarks = [
            'Alfa Romeo',
            'Great Wall',
            'BYD Auto',
            'Ssang Yong',
            'Land Rover',
        ];
        $data = array_map('trim', explode(' ', $str));
        if (in_array($data[0] . ' ' . $data[1], $customMarks)) {
            unset($data[0], $data[1]);
        } else {
            unset($data[0]);
        }
        sort($data);
        
        return implode(' ', $data);
    }
    
    /**
     * @param string $url
     */
    final public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}