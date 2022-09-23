<?php
 
namespace App\Enums;
 
enum ProductCategory: string
{
    case Armi = 'weapon';
    case Magie = 'spell';
    case Oggetti = 'object';
    case Accessori = 'wearable';
}