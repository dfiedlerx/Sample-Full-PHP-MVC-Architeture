<?php namespace Tools\DATABASE;
/*
* Essa classe é encarregada de gerar as strings que serão usadas
* nas consultas ao Banco de Dados.
* Classe Filha da Classe DATABASE_RUN e mãe da Classe DATABASE_TOOLS.
*
*/

/**
 * Class DATABASE_QUERY_GENERATE
 * @package DATABASE
 * @author Daniel Fiedler
 */
abstract class DATABASE_QUERY_GENERATE extends DATABASE_RUN{

	/*
	* Os métodos desta primeira parte são direcionados a classe query();
	*
---------------------------------------------------------------------------------------------------------*/

	/* Classe que irá implementar nas strings as tabelas alvo. Deverão ser passados em um array.
	* Ex: array ('work', 'aluno', 'sem_ideias', 'etc') gera work,aluno,sem_ideias,etc;
	* Servirá para o nome das tabelas, os atributos delas, Order By e Limit By.
	* O segundo parametro é o conector que ficará entre os termos. Nesse caso o padrão sera o ','
	*
	*/
    /**
     * Gera os termos separados por algo. Virgula por DEFAULT
     * @param array $tableTerms
     * @param string $intoTerms
     * @return string
     */
	protected function generateTerms(array $tableTerms, string $intoTerms = ',') :string {

		return implode ($intoTerms,$tableTerms);

	}

    /**
     * Função que retorna possíveis itens adicionais que foram solicitados. Sendo eles: Order, Limit e WHERE
     * @param array $conditionTerms
     * @param array $orderTerms
     * @param array $limitTerms
     * @return string
     */
    protected function additionalTerms (array $conditionTerms = [],
                                        array $orderTerms = [],
                                        array $limitTerms = []) :string {

        $additionalTerms = "";

        if (!empty($conditionTerms)) {

            $additionalTerms .= " WHERE ".self::generateConditionTerms($conditionTerms);

        }

        if (!empty($orderTerms)) {

            $additionalTerms .= " ORDER BY ".self::generateTerms($orderTerms, ' ');

        }

        if (!empty($limitTerms)) {

            $additionalTerms .= " LIMIT ".$limitTerms[0]." OFFSET ". $limitTerms[1];

        }

        return $additionalTerms;

    }

    /**
     * Função que irá gerar os termos de um where.
     * Será passada uma matriz em que:
     * A chave dessa matriz fará referência ao Nome do primeiro termo.
     * O conteúdo desta chave será dois valores no qual o primeiro diz referência à condição de igualdade com o primeiro termo e
     * o segundo é o conectivo com o próximo sendo ele 'AND', 'OR', etc.
     * EX:
     * array (
     *  array ('chave1','=','cavalo', 'AND'),
     *  array ('chave2,'=','Mula', 'OR'),
     *  array ('chave3','=','Louco', '')
     * );
     * O resultado sairá: chave1 = cavalo AND chave2 = Mula OR chave3 = Louco
     * Note que o último termo tem conectivo vazio já que não haverá mais com o que conectar.
     *
     * @param array $terms
     * @return string
     */
    protected function generateConditionTerms (array $terms) :string {

        $preString = '';

        if (!empty($terms)){

            foreach ($terms as $currentTerm) {

                $preString .= ' '.self::generateTerms($currentTerm, ' ');

       		}

        }

        return $preString;

    }

}
