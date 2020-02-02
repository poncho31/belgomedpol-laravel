<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rewritefunction as RF;
use App\Models\Tools;
use App\Models\Regex;
use App\Models\Lexicon;

class Theme extends Model
{
    public $fillable = ['theme', 'category', 'subcategory', 'explanation', 'theme_regex', 'category_regex', 'subcategory_regex'];

    public function testRegex(){
        $articles = Article::whereHas('politicians', function($q){})->get();
        // dd($articles);
        $themes = Theme::where('theme_regex', '<>', null)->get();
        foreach ($articles as $a) {
            foreach($themes as $t){
                // var_dump($t->theme_regex);
                preg_match_all("/$t->theme_regex/", $a->article, $matchesTheme);
                preg_match_all("/$t->category_regex/", $a->article, $matchesCategory);
                preg_match_all("/$t->subcategory_regex/", $a->article, $matchesSubcategory);
                if(!empty($matchesTheme[0]) && !empty($matchesCategory[0])){
                    dump($matchesTheme[0]);
                    dump($matchesCategory[0]);
                    dump($a->article);
                }
            }
        }
    }
    private function testConstructorRegex($string){
        return Regex::constructor($string);
        // $themes = Theme::get();
        // foreach($themes as $t){
        //     $regex = Regex::constructor($t->subcategory);
        // }
    }

    public function insertTheme(){

        foreach($this->getCategoriesRegex() as $keyTheme => $theme){
            if(is_array($theme)){
                foreach($theme as $keyCategory => $category){
                    if(is_array($category)){
                        foreach($category as $subcategory){
                            // $themeRegex = explode('@',$keyTheme);
                            $themeRegex = $keyTheme;
                            // $categoryRegex = explode('@',$keyCategory);
                            $categoryRegex = $keyCategory;
                            // $subcategoryRegex = explode('@',$subcategory);
                            $subcategoryRegex = $subcategory;

                            $checkInDB = DB::table('themes')
                                            ->where('theme', RF::if($themeRegex))
                                            ->where('category', RF::if($categoryRegex))
                                            ->where('subcategory', RF::if($subcategoryRegex))
                                            ->first();
                            $regex = Regex::constructor($subcategory);
                            // dd("end");
                            if(!$checkInDB){
                                try {
                                    $themeEntity = new Theme();
                                    $themeEntity->theme = RF::if($themeRegex);
                                    $themeEntity->theme_regex = RF::if($themeRegex);
                                    $themeEntity->category = RF::if($categoryRegex);
                                    $themeEntity->category_regex = RF::if($categoryRegex);
                                    $themeEntity->subcategory = RF::if($subcategoryRegex);
                                    $themeEntity->subcategory_regex = RF::if($subcategoryRegex);
                                    $themeEntity->save();
                                } catch (\Throwable $th) {
                                    dd($th);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getCategoriesRegex(){
        return 
        [
            'famille'=>[
                'identités'=>[
                    'sanction administrative communale',
                    "cartes d\'identités", 
                    'actes et registres', 
                    'nationalité', 
                    'changements de noms', 
                    'transgenres'
                ], 
                'couples'=>[
                    'ménage de fait', 
                    'cohabitation légale', 
                    'mariage', 
                    'divorce', 
                    'séparation', 
                    'problèmes familiaux'
                ], 
                'enfants'=>[
                    'allocation familiales', 
                    'allocation de naissance', 
                    'adoption', 
                    'famille d\'accueil', 
                    'accompagnement', 
                    'crêche', 
                    'planning familial', 
                    'enfants disparus', 
                    'droits de l\'enfant'
                ], 
                'aide sociale'=>[
                    'cpas@[Cc]pas', 
                    'seniors@[Ss]eniors', 
                    'titres services', 
                    'handicap'
                ],
                'décès'=>[
                    'déclaration de décès', 
                    'inhumation', 
                    'incinération', 
                    'déclaration d\'impôts', 
                    'héritage', 
                    'disparus'
                ],
                'international'=>[
                    'documents de voyage', 
                    'à l\'étranger'
                ]
            ],
            'justice'=> [
                'sécurité'=>[
                    'précuations à prendre@', 
                    'evénements publics', 
                    'incivilités', 
                    'SAC', 
                    'sanction administrative communale', 
                    'criminalité', 
                    'armes', 
                    'terrorisme'
                ], 
                'respect de la vie privée'=>[
                    'secret professionnel', 
                    'protection des données personnelles', 
                    'surveillance caméra', 
                    'internet'
                ], 
                'organisation'=>[null],
                'victime'=>[
                    'plaintes', 
                    'déclarations de plaintes', 
                    'aides aux victimes', 
                    'assistance judiciaire', 
                    'aide financière'
                ],
                'témoin'=>['obligation de délcaration', 'témoignage anonyme', 'comparution en justice', 'audience', 'prestation de serment', 'indemnisation']
            ],
            'mobilité'=>[
                'sécurité routière'=>['code de la route', 'sécurité routière', 'accident de la route', 'dégâts du véhicule'], 
                'permis de conduire'=>['catégories permis de conduire', 'aptitude médicale', 'auto-écoles reconnues', 'centre d\'examen reconnus'], 
                'véhicules'=>['types', 'modalités techniques', 'conduite écologique', 'acheter', 'vendre', 'immatriculation', 'personnes handicapées', 'taxe de circulation', 'taxe d\'assurance'], 
                'piétons'=>[null], 
                'cycliste'=>[null],
                'transports en commun'=>['trains', 'tram', 'bus', 'métro', 'taxi', 'uber'],
                'transport de marchandises'=>['route', 'eau', 'airs', 'chemin de fer'],
                'avion'=>['aéroport', 'droits des passagers'],
                'bateau'=>['navigation de plaisance']
            ],
            'santé'=>[
                'soins de santé'=>['urgences', 'services médicaux', 'fin de vie', 'don d\'organe', 'don de sang', 'droits du patient'], 
                'coût des soins'=>['assurance obligatoire', 'remboursement de base', 'remboursements spécifiques', 'honoraire médicaux', 'maximum à facturer', 'assurances privées', 'dossier médical global'], 
                'vie saine'=>['alimentation', 'drogues', 'dépendances', 'habitat', 'champs éélectromagnétiques', 'vaccination'], 
                'handicap'=>[null],
                'médicaments'=>['pharmacies', 'génériques', 'homéopathie', 'mode d\'emploi', 'somnifères', 'calmants', 'antibiotiques','achat sur internet'],
                'voyage'=>['assurances', 'carte européenne', 'destination à risque', 'vaccins', 'pharmacie de voyage', 'précautions sur place', 'rapatriement', 'dépistages maladies'],
                'risque pour la santé'=>['épidémies', 'risques climatiques']
            ],
            'environnement'=>[
                'biodiversité'=>[null], 
                'nature'=>[null], 
                'changement climatique'=>[null],
                'consommagtion durable'=>['consommer malin', 'politique des produits', 'lables écologiques','économies d\'énergie', 'source d\'énergie', 'déchets'], 
                'climat'=>[null],
                'substances chimiques'=>['pesticides', 'biocides', 'engrais', 'amiante'], 
                'pollution'=>[null],
                'écologique'=>[null]
            ],
            'logement'=>[
                'construire|renover'=> ['permis d\'urbanisme', 'architecte', 'entrepreneur', 'normes', 'sécurité', 'primes', 'tva', 'revenu cadastral'], 
                'acheter|vendre'=>['contrat de vente', 'acte notarié', 'prêt hypothécaire', 'assurance habitation', 'précompte immobilier'], 
                'location'=>[null],
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
                'pensions|fin de carrière'=>[null],
                'travailler en belgique'=>['formalités', 'permis de travail', 'libre circulation des travailleurs', 'travailler comme indépendant', 'reconnaissance des diplômes', 'sécurité sociale', 'impôts']
            ],
            'politique'=>[
                'élection'=>[null],
                'polémique'=>[null],
                'test'=>[null]
            ]
            
        ];
    }

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

    public $themesBckup = 
    [
        'famille@[fF]amilles?'=>[
            'identités@[Ii]dentit[ée]s?'=>[
                "cartes d\'identités@[Cc]artes?[\w\'\s]{0,10}identit[ée]s?", 
                'actes et registres@[Aa]ctes?[\s]{0,10}registres?', 
                'nationalité@[Nn]ationalit[ée]s?', 
                'changements de noms@[Cc]hangements?[\w\'\s]{0,10}noms?', 
                'transgenres@[Tt]ransgenres?'
            ], 
            'couples@[Cc]ouples?'=>[
                'ménage de fait@[mMée]nages?', 
                'cohabitation légale@[Cc]ohabita[\w\s]{1,10}l[ée]ga[\w]{0,10}', 
                'mariage@[Mm]ariages?', 
                'divorce@[Dd]ivorc[\w]{0,10}', 
                'séparation@[Ss][ée]parations?', 
                'problèmes familiaux@[Pp]robl[èe]me[\w\s]{0,10}famil[\w]{0,10}'
            ], 
            'enfants@[Ee]nfants?'=>[
                'allocation familiales@[Aa]llocation[\w\s]{0,10}famil[\w]{0,10}', 
                'allocation de naissance@[Aa]llocation[\w\s]{0,10}naissance[\w]{0,10}', 
                'adoption@[Aa]doptions?', 
                'famille d\'accueil@[Ff]amille[\w\s\']{0,10}accuei[\w]{0,10}', 
                'accompagnement@[Aa]ccompagnements?', 
                'crêche@[Cc]r[eê]ches?', 
                'planning familial@[Pp]lanning[\w\s]{0,10}famil[\w]{0,10}', 
                'enfants disparus@[Ee]nfant[\w\s]{0,10}dispar[\w]{0,10}', 
                'droits de l\'enfant@[Dd]roit[\w\s\']{0,10}enfan[\w]{1,10}'
            ], 
            'aide sociale@[Aa]ide[\\s\']{0,10}social{0,10}'=>[
                'cpas@[Cc]pas', 
                'seniors@[Ss]eniors', 
                'titres services@[Tt]itres?[\w\s]{0,10}servic[\w]{1,10}', 
                'handicap@[Hh]andicap[\w]{1,10}'
            ],
            'décès@[Dd][ée]c[èe]s?'=>[
                'déclaration de décès@[Dd][ée]claration[\w\s]{1,10}d[ée]c[\w]{1,10}', 
                'inhumation@[Ii]nhum[ationes]{1,10}', 
                'incinération@[Ii]ncin[éerations]{1,10}', 
                'déclaration d\'impôts@[Dd][ée]claration[\w\s\']{0,10}imp[oô]t[\w]{0,10}', 
                'héritage@[Hh][ée]rit[agesint]{1,10}', 
                'disparus@[Dd]ispar[\w]{1,10}'
            ],
            'international'=>[
                'documents de voyage@[Dd]ocument[\w\s]{0,10}voyag[\w]{1,10}', 
                'a l\'étranger@[Aaà][\w\s]{1,10}[ée]trange[\w]{1,10}'
            ]
        ],
        'justice@[jJ]ustices?'=> [
            'sécurité@[Ss][ée]curit[aireés]{1,10}'=>[
                'précuations à prendre@', 
                'evénements publics', 
                'incivilités', 
                'SAC', 
                'sanction administrative communale', 
                'criminalité', 
                'armes', 
                'terrorisme'
            ], 
            'respect de la vie privée'=>[
                'secret professionnel', 
                'protection des données personnelles', 
                'surveillance caméra', 
                'internet'
            ], 
            'organisation'=>[null],
            'victime'=>[
                'plaintes', 
                'déclarations de plaintes', 
                'aides aux victimes', 
                'assistance judiciaire', 
                'aide financière'
            ],
            'témoin'=>['obligation de délcaration', 'témoignage anonyme', 'comparution en justice', 'audience', 'prestation de serment', 'indemnisation']
        ],
        'mobilité@[mM]obilités?'=>[
            'sécurité routière'=>['code de la route', 'sécurité routière', 'accident de la route', 'dégâts du véhicule'], 
            'permis de conduire'=>['catégories permis de conduire', 'aptitude médicale', 'auto-écoles reconnues', 'centre d\'examen reconnus'], 
            'véhicules'=>['types', 'modalités techniques', 'conduite écologique', 'acheter', 'vendre', 'immatriculation', 'personnes handicapées', 'taxe de circulation', 'taxe d\'assurance'], 
            'piétons'=>[null], 
            'cycliste'=>[null],
            'transports en commun'=>['trains', 'tram', 'bus', 'métro', 'taxi', 'uber'],
            'transport de marchandises'=>['route', 'eau', 'airs', 'chemin de fer'],
            'avion'=>['aéroport', 'droits des passagers'],
            'bateau'=>['navigation de plaisance']
        ],
        'santé@[sS]antés?'=>[
            'soins de santé'=>['urgences', 'services médicaux', 'fin de vie', 'don d\'organe', 'don de sang', 'droits du patient'], 
            'coût des soins'=>['assurance obligatoire', 'remboursement de base', 'remboursements spécifiques', 'honoraire médicaux', 'maximum à facturer', 'assurances privées', 'dossier médical global'], 
            'vie saine'=>['alimentation', 'drogues', 'dépendances', 'habitat', 'champs éélectromagnétiques', 'vaccination'], 
            'handicap'=>[null],
            'médicaments'=>['pharmacies', 'génériques', 'homéopathie', 'mode d\'emploi', 'somnifères', 'calmants', 'antibiotiques','achat sur internet'],
            'voyage'=>['assurances', 'carte européenne', 'destination à risque', 'vaccins', 'pharmacie de voyage', 'précautions sur place', 'rapatriement', 'dépistages maladies'],
            'risque pour la santé'=>['épidémies', 'risques climatiques']
        ],
        'environnement@[Ee]nvironnements?'=>[
            'biodiversité'=>[null], 
            'nature'=>[null], 
            'changement climatique'=>[null],
            'consommagtion durable'=>['consommer malin', 'politique des produits', 'lables écologiques','économies d\'énergie', 'source d\'énergie', 'déchets'], 
            'climat'=>[null],
            'substances chimiques'=>['pesticides', 'biocides', 'engrais', 'amiante'], 
            'pollution'=>[null],
            'écologique'=>[null]
        ],
        'logement@[Ll]ogements?'=>[
            'construire|renover'=> ['permis d\'urbanisme', 'architecte', 'entrepreneur', 'normes', 'sécurité', 'primes', 'tva', 'revenu cadastral'], 
            'acheter|vendre'=>['contrat de vente', 'acte notarié', 'prêt hypothécaire', 'assurance habitation', 'précompte immobilier'], 
            'location'=>[null],
            'déménagement' =>['résidence principale', 'changement d\'adresse', 'primes', 'aides financières', 'à l\'étranger', 'vers la belgique'],
            'logement social'=>['inscription', 'attribution', 'société de logement social', 'prêt social', 'sans-abri'],
            'problème de logement'=>['insalubrité', 'problème de voisinage', 'incendie', 'catastrophes naturelles', 'expropriation']
        ],
        'économie@[Eeé]conomies?'=>[
            'commerce|consommation'=>['protection du consommateur', 'pratiques du commerce', 'produits', 'services', 'propriété intellectuelle', 'réglementation sectorielle'], 
            'entreprise'=>['création', 'professions réglementées', 'fiscalité', 'comptabilité'], 
            'production durable'=>['développement durable', 'économie durable'], 
            'informations économiques'=>['produit national', 'produit national brut', 'statistiques', 'indice des prix', 'investissements', 'marchés publics']
        ],
        'impôts@[Ii]mp[oô]ts?'=>[
            'impôts sur les revenus'=>['particuliers', 'indépendants', 'sociétés'], 
            'tva'=> ['champ d\'application', 'base d\'imposition', 'taux', 'assujettissement', 'obligations', 'déductions', 'contrôle', 'régimes particuliers'], 
            'droits d\'enregistrement'=>['contrat de location', 'biens immobiliers'], 
            'succession'=>['blocage compte', 'blocage coffre', 'déclaration', 'calcul', 'paiement'],
            'donation'=>['calcul', 'paiement']
        ],
        'formation@[Ff]ormations?'=>[
            'enseignement'=>['maternel', 'primaire', 'secondaire', 'supérieur', 'spécialisé', 'jury central', 'apprentissage', 'droits et devoirs'], 
            'coût des études'=>['gratuité scolaire', 'bourses d\'études', 'prêts d\'études', 'frais d\'inscription'], 
            'formation'=>['promotion sociale', 'indépendants', 'chèques-formation', 'enseignement à distance', 'alphabétisation'],
            'internationnal'=>['étudier à l\'étranger', 'venir étudier en belgique', 'programmes européens', 'diplômes'],
            'enseignant'=>['aptitude', 'candidatures', 'formation continuée', 'formation en continu', 'programmes scolaires'],
            'autres'=>['disciplines artistiques', 'sport', 'organisations de jeunesse', 'documentation', 'information']
        ],
        'emploi@[Ee]mplois?'=>[
            'recherche d\'emploi|trouver un emploi'=>['job étudiant', 'mesure d\'aide', 'aide à l\'emploi', 'premier emploi', 'marché du travail', 'travailler dans lesecteur public', 'diversité', 'égalité des chances'], 
            'contrat de travail'=>['types de contrats', 'réglementation du travail', 'durée du travail', 'temps de repos', 'préavis', 'liscenciement', 'détachement', 'dialogue social'], 
            'congés|interuption de carrière'=>['jours fériés', 'vacances annuelles', 'congé d\'adoption', 'congé de maternité', 'congé de paternité', 'congé de co-parentalité', 'crédit-temps', 'interuption de carrière', 'congé de circonstance', 'congé politique', 'congé-éducation payé'], 
            'santé|bien-être'=>['bien-être au travail', 'sécurité au travail', 'prévention', 'harcèlement', 'incapacité de travail', 'maladies profesionnelles', 'accidents du travail'], 
            'chômage'=>['chômage complet', 'chômage temporaire', 'temps partiel', 'chômage avec complément d\'entreprise'], 
            'pensions|fin de carrière'=>[null],
            'travailler en belgique'=>['formalités', 'permis de travail', 'libre circulation des travailleurs', 'travailler comme indépendant', 'reconnaissance des diplômes', 'sécurité sociale', 'impôts']
        ],
        'politique@[Pp]olitiques?'=>[
            'élection'=>[null],
            'polémique'=>[null],
            'test'=>[null]
        ]
        
    ];
}
