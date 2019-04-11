<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocaleSwitchController extends AbstractController
{
    /**
     * @Route("/switchenglish", name="switch_language_english")
     */
    public function switchLanguageEnglishAction() {
        return $this->switchLanguage('en');
    }

    /**
     * @Route("/switchfrench", name="switch_language_french")
     */
    public function switchLanguageFrenchAction() {
        return $this->switchLanguage('fr');
    }

    private function switchLanguage($locale) {
        $this->get('session')->set('_locale', $locale);
        return $this->redirect($this->generateUrl('home'));
    }
}
