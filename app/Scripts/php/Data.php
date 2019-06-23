<?php
namespace App\Scripts\php;

class Data {

    public static function feeds(){
        return $feeds = 
        [
            //LA LIBRE
        'http://www.lalibre.be/rss/section/actu/politique-belge.xml',
        'http://www.lalibre.be/rss.xml',
        'http://www.lalibre.be/rss/dossier/5b34c7ba55324d3f130abf58.xml',
        'http://www.lalibre.be/rss/section/regions/namur.xml',
        'http://www.lalibre.be/rss/section/network.xml',
        'http://www.lalibre.be/rss/section/actu.xml',
        'http://www.lalibre.be/rss/section/actu/international.xml',
        'http://www.lalibre.be/rss/section/actu/belgique.xml',
        'http://www.lalibre.be/rss/section/actu/politique-belge.xml',
        'http://www.lalibre.be/rss/section/actu/sciences-sante.xml',
        'http://www.lalibre.be/rss/section/actu/planete.xml',
        'http://www.lalibre.be/rss/section/actu/planete/inspire.xml',
        'http://www.lalibre.be/rss/section/actu/personnalite.xml',
        'http://www.lalibre.be/rss/section/economie.xml',
        'http://www.lalibre.be/rss/section/economie/immo.xml',
        'http://www.lalibre.be/rss/section/economie/digital.xml',
        'http://www.lalibre.be/rss/section/economie/libre-entreprise.xml',
        'http://www.lalibre.be/rss/section/economie/emploi.xml',
        'http://www.lalibre.be/rss/section/economie/conjoncture.xml',
        'http://www.lalibre.be/rss/section/economie/eco-debats.xml',
        'http://www.lalibre.be/rss/section/economie/placements.xml',
        'http://www.lalibre.be/rss/section/economie/auto.xml',
        'http://www.lalibre.be/rss/section/culture.xml',
        'http://www.lalibre.be/rss/section/culture/cinema.xml',
        'http://www.lalibre.be/rss/section/culture/musique.xml',
        'http://www.lalibre.be/rss/section/culture/arts.xml',
        'http://www.lalibre.be/rss/section/culture/medias-tele.xml',
        'http://www.lalibre.be/rss/section/culture/livres-bd.xml',
        'http://www.lalibre.be/rss/section/culture/serie-tv.xml',
        'http://www.lalibre.be/rss/section/culture/scenes.xml',
        'http://www.lalibre.be/rss/section/culture/politique.xml',
        'http://www.lalibre.be/rss/section/sports.xml',
        'http://www.lalibre.be/rss/section/debats.xml',
        'http://www.lalibre.be/rss/section/regions.xml',
        'http://www.lalibre.be/rss/section/regions/bruxelles.xml',
        'http://www.lalibre.be/rss/section/regions/brabant.xml',
        'http://www.lalibre.be/rss/section/regions/flandre.xml',
        'http://www.lalibre.be/rss/section/regions/liege.xml',
        'http://www.lalibre.be/rss/section/regions/hainaut.xml',
        'http://www.lalibre.be/rss/section/regions/namur.xml',
        'http://www.lalibre.be/rss/infos/belga.xml',
        'http://www.lalibre.be/rss/infos/afp.xml',
        'http://www.lalibre.be/rss/dossiers.xml',
        'http://www.lalibre.be/rss/dossiers.xml',

        // LE SOIR
        'http://www.lesoir.be/rss/81851/cible_principale_gratuit',
        'http://www.lesoir.be/rss/81862/cible_principale_gratuit',
        'http://www.lesoir.be/rss/31868/cible_principale',
        'http://www.lesoir.be/rss/31867/cible_principale',
        'http://www.lesoir.be/rss/81864/cible_principale_gratuit',
        'http://www.lesoir.be/rss/31871/cible_principale',
        'http://www.lesoir.be/rss/31872/cible_principale',
        'http://www.lesoir.be/rss/31873/cible_principale',
        'http://www.lesoir.be/rss/31874/cible_principale',
        'http://www.lesoir.be/rss/81863/cible_principale_gratuit',
        'http://www.lesoir.be/rss/31875/cible_principale',
        'http://www.lesoir.be/rss/31876/cible_principale',
        'http://www.lesoir.be/rss/81866/cible_principale_gratuit',
        'http://www.lesoir.be/rss/81906/cible_principale_gratuit',
        'http://www.lesoir.be/rss/81907/cible_principale_gratuit',
        'http://www.lesoir.be/rss/81867/cible_principale_gratuit',
        'http://www.lesoir.be/rss/12/cible_principale',
        'http://www.lesoir.be/rss/81868/cible_principale_gratuit',
        'http://www.lesoir.be/rss/31895/cible_principale',
        'http://www.lesoir.be/rss/16/cible_principale',
        'http://www.lesoir.be/rss/23/cible_principale',
        'http://www.lesoir.be/rss/31920/maga_cible_principale_gratuit',
        //LA DH
        'http://www.dhnet.be/rss/section/actu.xml',
        'http://www.dhnet.be/rss.xml',
        'http://www.dhnet.be/rss/section/actu.xml',
        'http://www.dhnet.be/rss/section/actu/faits.xml',
        'http://www.dhnet.be/rss/section/actu/belgique.xml',
        'http://www.dhnet.be/rss/section/actu/societe.xml',
        'http://www.dhnet.be/rss/section/actu/monde.xml',
        'http://www.dhnet.be/rss/section/actu/economie.xml',
        'http://www.dhnet.be/rss/section/actu/new-tech.xml',
        'http://www.dhnet.be/rss/section/actu/sexualite.xml',
        'http://www.dhnet.be/rss/section/actu/sante.xml',
        'http://www.dhnet.be/rss/section/sports.xml',
        'http://www.dhnet.be/rss/section/regions.xml',
        'http://www.dhnet.be/rss/section/regions/bruxelles.xml',
        'http://www.dhnet.be/rss/section/regions/brabant.xml',
        'http://www.dhnet.be/rss/section/regions/namur.xml',
        'http://www.dhnet.be/rss/section/regions/luxembourg.xml',
        'http://www.dhnet.be/rss/section/regions/liege.xml',
        'http://www.dhnet.be/rss/section/regions/charleroi.xml',
        'http://www.dhnet.be/rss/section/regions/mons.xml',
        'http://www.dhnet.be/rss/section/regions/centre.xml',
        'http://www.dhnet.be/rss/section/regions/tournai-ath-mouscron.xml',
        'http://www.dhnet.be/rss/section/medias.xml',
        'http://www.dhnet.be/rss/section/medias/television.xml',
        'http://www.dhnet.be/rss/section/medias/cinema.xml',
        'http://www.dhnet.be/rss/section/medias/musique.xml',
        'http://www.dhnet.be/rss/section/medias/jeux-video.xml',
        'http://www.dhnet.be/rss/section/medias/livresbd.xml',
        'http://www.dhnet.be/rss/section/medias/dh-radio.xml',
        'http://www.dhnet.be/rss/section/medias/divers.xml',
        'http://www.dhnet.be/rss/section/medias/series.xml',
        'http://www.dhnet.be/rss/section/buzz.xml',
        'http://www.dhnet.be/rss/section/conso.xml',

        //RTL INFO
        'http://feeds.feedburner.com/rtlinfo/belgique?format=xml',
        'http://feeds.feedburner.com/Rtlinfo/VotreRegion?format=xml',
        'https://feeds.feedburner.com/Rtlinfos-ALaUne',
        'https://feeds.feedburner.com/rtlinfo/france',
        'https://feeds.feedburner.com/Rtlinfo/VotreRegion',
        'https://feeds.feedburner.com/RTLInternational',
        'https://feeds.feedburner.com/RTLEconomie',
        'https://feeds.feedburner.com/RTLSports',
        'https://feeds.feedburner.com/rtlsport/football',
        'https://feeds.feedburner.com/rtlinfo/people',
        'https://feeds.feedburner.com/rtlpeople/royaute',
        'https://feeds.feedburner.com/rtlpeople/buzz',
        'https://feeds.feedburner.com/rtlsport/footballetranger',

        //L'ECHO
        'https://www.lecho.be/rss/actualite.xml',
        'https://www.lecho.be/rss/politique_europe.xml',
        'https://www.lecho.be/rss/politique_belgique.xml',
        'https://www.lecho.be/rss/fonds.xml',
        'https://www.lecho.be/rss/mon_argent_energie.xml',
        'https://www.lecho.be/rss/mon_argent_impots.xml',
        'https://www.lecho.be/rss/mon_argent_budget.xml',
        'https://www.lecho.be/rss/mon_argent.xml',
        'https://www.lecho.be/rss/mon_argent_credit.xml',
        'https://www.lecho.be/rss/mon_argent_succession.xml',
        'https://www.lecho.be/rss/mon_argent_voyages.xml',
        'https://www.lecho.be/rss/mon_argent_immobilier.xml',
        'https://www.lecho.be/rss/mon_argent_assurances.xml',
        'https://www.lecho.be/rss/mon_argent_epargner.xml',
        'https://www.lecho.be/rss/sabato_art.xml',
        'https://www.lecho.be/rss/sabato_mode.xml',
        'https://www.lecho.be/rss/sabato_gastronomie.xml',
        'https://www.lecho.be/rss/sabato_filmsettv.xml',
        'https://www.lecho.be/rss/sabato_design.xml',
        'https://www.lecho.be/rss/sabato_general.xml',
        'https://www.lecho.be/rss/entreprises.xml',
        'https://www.lecho.be/rss/entreprises_banques.xml',
        'https://www.lecho.be/rss/top_stories.xml',
        'https://www.lecho.be/rss/politique_belgique.xml',
        'https://www.lecho.be/rss/politique_economie.xml',
        'https://www.lecho.be/rss/politique_europe.xml',
        'https://www.lecho.be/rss/politique_internationale.xml',
        // 'http://blogs.lecho.be/fairtrade/rss.xml',
        'https://www.lecho.be/rss/les_cracks_en_action.xml',
        // 'http://blogs.lecho.be/monargent/rss.xml',
        // 'http://blogs.lecho.be/tzine/rss.xml',
        'https://www.lecho.be/rss/debats.xml',

        //LE VIF
        'https://www.levif.be/actualite/feed.rss',

        //LA RTBF
        'http://rss.rtbf.be/article/rss/highlight_rtbfinfo_info-accueil.xml',
        'http://rss.rtbf.be/media/rss/audio/lapremiere_recent.xml',
        //SUDINFO
        'http://www.sudinfo.be/rss/2023/cible_principale_gratuit'
        ];
    }

    function updateMediaName($em){
    $updateTable =
                [
                    "UPDATE media SET nom = 'rtl' where nom like '%rtl%'
                                or nom like 'feedproxy.google.com'
                    ",
                    "UPDATE media SET nom = 'dh' where nom like '%dh%'",
                    "UPDATE media SET nom = 'lecho' where nom like '%lecho%'
                                or nom like '%fair trade%' 
                                or nom like '%t-zine%'
                                or nom like '%tijd%'
                                or nom like '%cracks%'
                    ",
                    "UPDATE media SET nom = 'lesoir' where nom like '%lesoir%'",
                    "UPDATE media SET nom = 'lalibre' where nom like '%lalibre%'",
                    "UPDATE media SET nom = 'levif' where nom like '%vif%'",
                    "UPDATE media SET nom = 'rtbf' where nom like '%rtbf%'",
                    "UPDATE media SET nom = 'rtbf' where nom like '%la Première%'",
                    "UPDATE media SET nom = 'sudinfo' where nom like '%sudinfo%'"
                ];
        try {
            foreach ($updateTable as $key) {
                $stmt = $em->getConnection()->prepare($key);
                $stmt->execute();
            }
            return "Success";
        } catch (\Exception $e) {
            return "Error";
        }
    }

    public static function mediasTag(){
        return [
            "sudinfo" => ".gr-article-content",
            "rtbf"=> ".rtbf-paragraph",
            "rtl"=> ".w-content-details-article-body",
            "dh"=>".article-text",
            "lalibre"=> ".article-text",
            "lecho"=> ".ac_paragraph",
            "lesoir"=> ".gr-article-content",
            "levif"=> "#article-body"
        ];
    }
}