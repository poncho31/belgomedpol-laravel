<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public $fillable = ['category', 'theme', 'category', 'subcategory', 'explanation'];

    // https://nesetweb.eu/fr/policy-themes/
    public $liste = [
        'Financement et gouvernance de l’éducation et de la formation',
        'Contenu des programmes d’éducation et de formation, développement de compétences clés',
        'Groupes vulnérables dans l’enseignement et la formation',
        'Genre, identités sexuelles',
        'Handicap/besoins particuliers, éducation inclusive',
        'Enseignement et migration',
        'Origine ethnique et non-discrimination',
        'Décrochage scolaire',
        "Accroître la participation à l'enseignement supérieur",
        'Implication parentale et soutien familial',
        "Suivi pour l’équité dans l’enseignement et la formation",
        "Enseignement et formation de la main-d’œuvre professionnelle",
        "Travail interdisciplinaire",
        "Enseignement et formation professionnels, transitions vers l’emploi",
        "Équité et qualité dans l’enseignement des adultes"
    ];
    // http://www.veritepolitique.fr/themes/
    public $themes = [
        "élections",
        "économie",
        'polémique',
        'immigration',
        'union européenne',
        'société',
        'politique intérieur',
        'institutions',
        'fiscalité',
        'emplois',
        'marché du travail',
        'sécurité',
        'écologie',
        'justice',
        'politique étrangère',
        'social',
        'éducation',
        'enseignement',
        'formation',
        'santé',
        'défense',
        'religion',
        'énergie',
        'administration',
        'financement',
        'budget',
        'dépenses publiques',
        'état',
        'logement',
        'culture',
        'tourisme',
        'consommation',
        'sport',
        'environnement',
        'changement climatique',
        'recherche et innovation',
        'technologies'
    ];
    public $categoryPrecise;
}
