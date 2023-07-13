<?php
namespace App\Views\Composers;
use illuminate\View\View;
use App\Models\Section;


class ProductDataComposer {
    public function __construct() {
    }
// The compose function here handles the logic of binding data to the view
    public function compose(View $view) {
        $sections = Section::get();
// With method accepts two arguments, a key and a value
        $view->with('sections', $sections);
   }
}