<?php
namespace App\ViewComposers;

use Illuminate\View\View;

class ExampleComposer{

    protected $example;
    public function __construct()
    {
        // TODO: integrate instance
    }

    public function compose(View $view)
    {
        // TODO: Bind data to view
    }
}