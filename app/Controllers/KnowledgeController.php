<?php

namespace App\Controllers;

use App\Models\IKSModel;

class KnowledgeController
{
    private $iksModel;

    public function __construct()
    {
        $this->iksModel = new IKSModel();
    }

    public function iks()
    {
        // Fetch items categorized for the view
        $predictionItems = $this->iksModel->getItemsByCategory('prediction');
        $weatherItems = $this->iksModel->getItemsByCategory('weather');
        $preventionItems = $this->iksModel->getItemsByCategory('prevention');

        $title = 'Indigenous Knowledge System (IKS)';
        
        ob_start();
        include __DIR__ . '/../Views/iks.php';
        $content = ob_get_clean();
        
        include __DIR__ . '/../Views/layout.php';
    }
}
