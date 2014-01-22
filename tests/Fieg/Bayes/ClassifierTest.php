<?php

use Fieg\Bayes\Classifier;
use Fieg\Bayes\Tokenizer\WhitespaceAndPunctuationTokenizer;

class ClassifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider classifyDataProvider
     */
    public function testClassify($expectedLabel, $string)
    {
        $classifier = new Classifier(new WhitespaceAndPunctuationTokenizer());

        $data = $this->trainingData();
        foreach ($data as $row) {
            list($label, $text) = $row;

            $classifier->train($label, $text);
        }

        $result = $classifier->classify($string);

        reset($result);

        $topMatch = key($result);

        $this->assertEquals($expectedLabel, $topMatch);
    }

    public function classifyDataProvider()
    {
        return array(
            array('en', 'scientific problems and the need'),
            array('fr', 'D\'icône de la cause des femmes à celui de renégate'),
            array('es', 'Un importante punto de inflexión en la historia de la ciencia filosófica primitiva'),
        );
    }

    public function trainingData()
    {
        return array(
            // fr
            array(
                'fr',
                "L'Italie a été gouvernée pendant un an par un homme qui n'avait pas été élu par le peuple. Dès la nomination de Mario Monti au poste de président du conseil, fin 2011, j'avais dit :Attention, c'est prendre un risque politique majeur. Par leur vote, les Italiens n'ont pas seulement adressé un message à leurs élites nationales, ils ont voulu dire : Nous, le peuple, nous voulons garder la maîtrise de notre destin. Et ce message pourrait être envoyé par n'importe quel peuple européen, y compris le peuple français.",
            ),
            array(
                'fr',
                "Il en faut peu, parfois, pour passer du statut d'icône de la cause des femmes à celui de renégate. Lorsqu'elle a été nommée à la tête de Yahoo!, le 26 juillet 2012, Marissa Mayer était vue comme un modèle. Elle montrait qu'il était possible de perforer le fameux plafond de verre, même dans les bastions les mieux gardés du machisme (M du 28 juillet 2012). A 37 ans, cette brillante diplômée de Stanford, formée chez Google, faisait figure d'exemple dans la Silicon Valley californienne, où moins de 5 % des postes de direction sont occupés par des femmes. En quelques mois, le symbole a beaucoup perdu de sa puissance.",
            ),
            array(
                'fr',
                "Premier intervenant de taille à SXSW 2013, Bre Pettis, PDG de la société Makerbot, spécialisée dans la vente d'imprimantes 3D, a posé une question toute simple, avant de dévoiler un nouveau produit qui l'est un peu moins. Voulez-vous rejoindre notre environnement 3D ?, a-t-il demandé à la foule qui débordait de l'Exhibit Hall 5 du Convention Center.",
            ),
            array(
                'fr',
                "Des milliers de manifestants ont défilé samedi 9 mars à Tokyo pour exiger l'abandon rapide de l'énergie nucléaire au Japon, près de deux ans jour pour jour après le début de la catastrophe de Fukushima.",
            ),

            // es
            array(
                'es',
                "El ex presidente sudafricano, Nelson Mandela, ha sido hospitalizado la tarde del sábado, según confirmó un hospital de Pretoria a CNN. Al parecer se trata de un chequeo médico que ya estaba previsto, relacionado con su avanzada edad, según explicó el portavoz de la presidencia Sudafricana Mac Maharaj.",
            ),
            array(
                'es',
                'Guerras continuas y otros problemas llevaron finalmente a un estado de disminución. Las invasiones napoleónicas de España llevaron al caos, lo que provocó los movimientos de independencia que destrozaron la mayor parte del imperio y abandonaron el país políticamente inestable',
            ),
            array(
                'es',
                'En el uso moderno, la "ciencia" a menudo se refiere a una forma de perseguir el conocimiento, no sólo el conocimiento mismo. También se suele restringirse a las ramas de estudio que tratan de explicar los fenómenos del universo material. [6] En los siglos 17 y 18 científicos cada vez más solicitados para formular el conocimiento en términos de las leyes de la naturaleza, tales como las leyes del movimiento de Newton. Y en el transcurso del siglo 19, la palabra "ciencia" se hizo cada vez más asociada con el método científico en sí, como una manera disciplinada para estudiar el mundo natural, incluyendo la física, la química, la geología y la biología',
            ),
            array(
                'es',
                'Un importante punto de inflexión en la historia de la ciencia filosófica primitiva fue el intento controversial pero exitoso por Sócrates para aplicar la filosofía al estudio de los seres humanos, incluyendo la naturaleza humana, la naturaleza de las comunidades políticas, y el conocimiento humano en sí. Criticó el tipo más antiguo de estudio de la física como demasiado puramente especulativo y carente de autocrítica. Se mostró especialmente preocupado de que algunos de los primeros físicos trataron la naturaleza como si pudiera ser asumido que no tenía orden inteligente, explicando las cosas sólo en términos de movimiento y la materia.',
            ),

            // en
            array(
                'en',
                "Other possible reasons have been proposed for the lengthy research in the progress of strong AI. The intricacy of scientific problems and the need to fully understand the human brain through psychology and neurophysiology have limited many researchers from emulating the function of the human brain into a computer hardware.",
            ),
            array(
                'en',
                "There have been many AI researchers that debate over the idea whether machines should be created with emotions. There are no emotions in typical models of AI and some researchers say programming emotions into machines allows them to have a mind of their own.",
            ),
        );
    }
}
