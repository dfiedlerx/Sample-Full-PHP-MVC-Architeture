<?php namespace ModelTools;
/*
*Classe com o intuito de gerar as criptografias do sistema. 
*Também fará comparações de criptografia.
*/

/**
 * Class Crypto
 * @package ModelTools
 */
class Crypto
{

    /**
     * Função privada que irá gerar uma chave aleatória para senhas de usuários.
     * Utiliza-se um Md5 sobre o tempo em milesegundos concatenado com um random de 10000 a 99999
     *
     * @return string
     */
	private static function hashKeyGenerator (){

		return md5 (microtime().rand(10000,99999));

	}

    /**
     * Função publica que ira gerar a senha criptografada
     * Padrão usado: Bcrypt;
     *
     * @param string $contentToConvert
     * @return string
     */
	public static function passwordHashGenerator (string $contentToConvert){

		return crypt($contentToConvert,'$2a$'.'08'.'$'.self::hashKeyGenerator().'$');

	}


    /**
     * Função publica que ira gerar uma chave própria para cada sistema
     * Padrão usado: MD5;
     *
     * @return string
     */
	public static function systemHashGenerator (){

		return
            md5(Filter::externalFilter(

                4,
                'HTTP_USER_AGENT').Filter::externalFilter(

                    4,
                    'REMOTE_ADDR'

                )

            );

	}

    /**
     * Função publica que ira comparar a senha informada com a senha no banco
     * Padrão usado: Bcrypt;
     *
     * @param string $targetString
     * @param string $hashKey
     * @return bool
     */
	public static function hashComparer (string $targetString, string $hashKey){
            
            return crypt($targetString, $hashKey) == $hashKey;

	}


}