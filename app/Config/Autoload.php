<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 */
class Autoload extends AutoloadConfig
{
    /**
     * @var array<string, list<string>|string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
    ];

    /**
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * @var list<string>
     */
    public $files = [];

    /**
     * -------------------------------------------------------------------
     * Helpers (Adicionado 'url', 'form' e 'format')
     * -------------------------------------------------------------------
     * Os Helpers são carregados automaticamente em todas as requisições.
     * * @var list<string>
     */
    public $helpers = [
        'url',      // Para usar url_to()
        'form',     // NECESSÁRIO para usar form_open() em register.php e login.php
        'format',   // Para usar a função format_datetime() na View index.php
    ];
}
