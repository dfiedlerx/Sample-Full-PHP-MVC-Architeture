<?php namespace Tools\DATABASE;
/* Classe que é encarregada de encaminhar as querys para execução no banco.
* Essa classe é filha da classe DATABASE_CONNECTION e mãe da Classe DATABASE_TOOLS.
* Nao há necessidade de comunicação com outras calsses do sistema.
*
*/

/**
 * Class DATABASE_RUN
 * @package DATABASE
 */
abstract class DATABASE_RUN extends DATABASE_CONNECTION
{

	//Atributo que comportará uma determinada prepare.
	protected $DB_PREPARE;

    /**
     * Método de uso da propriedade query.
     * Esse método exige filtragem prévia dos dados e é melhor utilizada quando não for preciso multiplas consultas.
     * @param string $queryString
     * @return mixed
     */
	protected function runQuery (string $queryString) {

		return self::$DB_CONNECTION->query($queryString);

	}

	/*
	* Métodos de uso da propriedade Prepare.
	* É recomendado úsá-la sempre que possível, salvo em casos em que os dados já tenham sido filtrados e não haverá
	* múltiplas consultas.
	*
	*/

    /**
     * Função que inicia o prepare para ser usado;
     * @param string $prepareString
     * @return mixed
     */
	protected function initPrepare (string $prepareString) {

		$this->DB_PREPARE = self::$DB_CONNECTION->prepare($prepareString);
		return $this->DB_PREPARE;

	}

    /**
     * Função que executará algo no prepare. O parâmetro de ser um array.
     * @param array $execArrayParameters
     * @return bool
     */
	protected function runPrepare (array $execArrayParameters = []) :bool {

		if (is_array($execArrayParameters)){

			$this->DB_PREPARE->execute ($execArrayParameters);
			return $this->DB_PREPARE;

		}

		return false;

	}

    /**
     * Inicia um modo seguro em que todas as querys seguintes deverão executar com sucesso para serem validadas.
     * @return mixed
     */
	protected function beginTransaction () {

	    return self::$DB_CONNECTION->beginTransaction();

    }

    /**
     * Complemento da função beginTransaction que salva as querys.
     * @return mixed
     */
    protected function commit () {

	    return self::$DB_CONNECTION->commit ();

    }

    /**
     * Complemento da função beginTransaction que reverte as querys
     * @return mixed
     */
    protected function rollBack () {

        return self::$DB_CONNECTION->rollBack ();

    }

}