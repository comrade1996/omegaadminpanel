<?php
use Illuminate\Support\Facades\App;
function changeLang()
{
     //get current language
     $locale = App::getLocale();

if ($locale=='en')
 {
    App::setLocale('ar');
}else
{
    App::setLocale('en');
}
return $locale;
}
