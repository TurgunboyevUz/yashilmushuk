<?php

namespace App\Enums;

enum CriteriaEnum: int
{
    case ARTICLE_GLOBAL = 1;       // id = 1
    case ARTICLE_LOCAL = 2;        // id = 2
    case ARTICLE_THESIS_GLOBAL = 3; // id = 4
    case ARTICLE_THESIS_LOCAL = 4;  // id = 3
    case ARTICLE_SCOPUS = 5;        // id = 5

    case SCHOLARSHIP_INSTITUTE = 6;  // id = 6
    case SCHOLARSHIP_REGION = 7;     // id = 7
    case SCHOLARSHIP_REPUBLIC = 8;   // id = 8

    case INVENTION_INV = 13;          // id = 13
    case INVENTION_DGU = 15;         // id = 15
    case INVENTION_MODEL = 14;       // id = 14

    case GRAND = 24;                 // id = 24
    case ECONOMY = 23;               // id = 23

    case OLYMPIC_INSTITUTE = 9;     // id = 9
    case OLYMPIC_REGION = 10;        // id = 10
    case OLYMPIC_REPUBLIC = 11;      // id = 11
}
