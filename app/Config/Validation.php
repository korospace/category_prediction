<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    
    public $entryValidate = [
		'id' => [
            'rules'  => 'is_unique[galert_entry.entry_id]',
            'errors' => [
                'is_unique' => 'id ({value}) sudah ada',
            ],
		],
    ];

    public $csvValidate = [ // App/Config/Mimes.php
        'slangcsv' => [
            'rules'  => 'uploaded[slangcsv]|ext_in[slangcsv,csv,xlsx]',
            'errors' => [
                'ext_in'  => 'your file must .csv/.xlsx file',
            ],
        ],
    ];

    public $nonBakuValidate = [
		'kata_nonbaku' => [
            'rules'  => 'required',
		],
        'kata_baku' => [
            'rules'  => 'required',
		],
    ];

    public $predictValidate = [
        'id_actual' => [
            'rules'  => 'required|is_not_unique[kategori.id]',
            'errors' => [
                'required'  => 'kategori harus diisi',
                'is_not_unique' => 'kategori tidak terdaftar',
            ],
		],
        'text' => [
            'rules'  => 'required',
            'errors' => [
                'required'  => 'text harus diisi',
            ],
		],
    ];
}
