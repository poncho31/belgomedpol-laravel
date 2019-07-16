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

    public $category = 
    [
        'famille'=>[
            'identité'=>['carte d\'identité', 'actes et registres', 'nationalité', 'changement de nom', 'transgenre'], 
            'couple'=>['ménage de fait', 'cohabitation légale', 'mariage', 'divorce', 'séparation', 'problèmes familiaux'], 
            'enfants'=>['allocation familiales', 'allocation de naissance', 'adoption', 'famille d\'accueil', 'accompagnement', 'crêche', 'planning familial', 'enfants disparus', 'droits de l\'enfant'], 
            'aide sociale'=>['cpas', 'seniors', 'titres services', 'handicap'],
            'décès'=>['déclaration de décès', 'inhumation', 'incinération', 'déclaration d\'impôts', 'héritage', 'disparus'],
            'international'=>['documents de voyage', 'a l\'étranger']
        ],
        'justice'=> [
            'sécurité'=>['précuations à prendre', 'evénements publics', 'incivilités', 'SAC', 'sanction administrative communale', 'criminalité', 'armes', 'terrorisme'], 
            'respect de la vie privée'=>['secret professionnel', 'protection des données personnelles', 'surveillance caméra', 'internet'], 
            'organisation', 
            'victime'=>['plaintes', 'déclarations de plaintes', 'aides aux victimes', 'assistance judiciaire', 'aide financière'],
            'témoin'=>['obligation de délcaration', 'témoignage anonyme', 'comparution en justice', 'audience', 'prestation de serment', 'indemnisation']
        ],
        'mobilité'=>[
            'sécurité routière'=>['code de la route', 'sécurité routière', 'accident de la route', 'dégâts du véhicule'], 
            'permis de conduire'=>['catégories permis de conduire', 'aptitude médicale', 'auto-écoles reconnues', 'centre d\'examen reconnus'], 
            'véhicules'=>['types', 'modalités techniques', 'conduite écologique', 'acheter', 'vendre', 'immatriculation', 'personnes handicapées', 'taxe de circulation', 'taxe d\'assurance'], 
            'piétons', 
            'cycliste',
            'transports en commun'=>['trains', 'tram', 'bus', 'métro', 'taxi', 'uber'],
            'transport de marchandises'=>['route', 'eau', 'airs', 'chemin de fer'],
            'avion'=>['aéroport', 'droits des passagers'],
            'bateau'=>['navigation de plaisance']
        ],
        'santé'=>[
            'soins de santé'=>['urgences', 'services médicaux', 'fin de vie', 'don d\'organe', 'don de sang', 'droits du patient'], 
            'coût des soins'=>['assurance obligatoire', 'remboursement de base', 'remboursements spécifiques', 'honoraire médicaux', 'maximum à facturer', 'assurances privées', 'dossier médical global'], 
            'vie saine'=>['alimentation', 'drogues', 'dépendances', 'habitat', 'champs éélectromagnétiques', 'vaccination'], 
            'handicap',
            'médicaments'=>['pharmacies', 'génériques', 'homéopathie', 'mode d\'emploi', 'somnifères', 'calmants', 'antibiotiques','achat sur internet'],
            'voyage'=>['assurances', 'carte européenne', 'destination à risque', 'vaccins', 'pharmacie de voyage', 'précautions sur place', 'rapatriement', 'dépistages maladies'],
            'risque pour la santé'=>['épidémies', 'risques climatiques']
        ],
        'environnement'=>[
            'biodiversité', 
            'nature', 
            'changement climatique',
            'consommagtion durable'=>['consommer malin', 'politique des produits', 'lables écologiques','économies d\'énergie', 'source d\'énergie', 'déchets'], 
            'climat',
            'substances chimiques'=>['pesticides', 'biocides', 'engrais', 'amiante'], 
            'pollution',
            'écologique'
        ],
        'logement'=>[
            'construire|renover'=> ['permis d\'urbanisme', 'architecte', 'entrepreneur', 'normes', 'sécurité', 'primes', 'tva', 'revenu cadastral'], 
            'acheter'=>['contrat de vente', 'acte notarié', 'prêt hypothécaire', 'assurance habitation', 'précompte immobilier'], 
            'vendre'=>['contrat de vente', 'acte notarié', 'prêt hypothécaire', 'assurance habitation', 'précompte immobilier'], 
            'location',
            'déménagement' =>['résidence principale', 'changement d\'adresse', 'primes', 'aides financières', 'à l\'étranger', 'vers la belgique'],
            'logement social'=>['inscription', 'attribution', 'société de logement social', 'prêt social', 'sans-abri'],
            'problème de logement'=>['insalubrité', 'problème de voisinage', 'incendie', 'catastrophes naturelles', 'expropriation']
        ],
        'économie'=>[
            'commerce|consommation'=>['protection du consommateur', 'pratiques du commerce', 'produits', 'services', 'propriété intellectuelle', 'réglementation sectorielle'], 
            'entreprise'=>['création', 'professions réglementées', 'fiscalité', 'comptabilité'], 
            'production durable'=>['développement durable', 'économie durable'], 
            'informations économiques'=>['produit national', 'produit national brut', 'statistiques', 'indice des prix', 'investissements', 'marchés publics']
        ],
        'impôts'=>[
            'impôts sur les revenus'=>['particuliers', 'indépendants', 'sociétés'], 
            'tva'=> ['champ d\'application', 'base d\'imposition', 'taux', 'assujettissement', 'obligations', 'déductions', 'contrôle', 'régimes particuliers'], 
            'droits d\'enregistrement'=>['contrat de location', 'biens immobiliers'], 
            'succession'=>['blocage compte', 'blocage coffre', 'déclaration', 'calcul', 'paiement'],
            'donation'=>['calcul', 'paiement']
        ],
        'formation'=>[
            'enseignement'=>['maternel', 'primaire', 'secondaire', 'supérieur', 'spécialisé', 'jury central', 'apprentissage', 'droits et devoirs'], 
            'coût des études'=>['gratuité scolaire', 'bourses d\'études', 'prêts d\'études', 'frais d\'inscription'], 
            'formation'=>['promotion sociale', 'indépendants', 'chèques-formation', 'enseignement à distance', 'alphabétisation'],
            'internationnal'=>['étudier à l\'étranger', 'venir étudier en belgique', 'programmes européens', 'diplômes'],
            'enseignant'=>['aptitude', 'candidatures', 'formation continuée', 'formation en continu', 'programmes scolaires'],
            'autres'=>['disciplines artistiques', 'sport', 'organisations de jeunesse', 'documentation', 'information']
        ],
        'emploi'=>[
            'recherche d\'emploi|trouver un emploi'=>['job étudiant', 'mesure d\'aide', 'aide à l\'emploi', 'premier emploi', 'marché du travail', 'travailler dans lesecteur public', 'diversité', 'égalité des chances'], 
            'contrat de travail'=>['types de contrats', 'réglementation du travail', 'durée du travail', 'temps de repos', 'préavis', 'liscenciement', 'détachement', 'dialogue social'], 
            'congés|interuption de carrière'=>['jours fériés', 'vacances annuelles', 'congé d\'adoption', 'congé de maternité', 'congé de paternité', 'congé de co-parentalité', 'crédit-temps', 'interuption de carrière', 'congé de circonstance', 'congé politique', 'congé-éducation payé'], 
            'santé|bien-être'=>['bien-être au travail', 'sécurité au travail', 'prévention', 'harcèlement', 'incapacité de travail', 'maladies profesionnelles', 'accidents du travail'], 
            'chômage'=>['chômage complet', 'chômage temporaire', 'temps partiel', 'chômage avec complément d\'entreprise'], 
            'pensions|fin de carrière',
            'travailler en belgique'=>['formalités', 'permis de travail', 'libre circulation des travailleurs', 'travailler comme indépendant', 'reconnaissance des diplômes', 'sécurité sociale', 'impôts']
        ],
        
    ];
}
