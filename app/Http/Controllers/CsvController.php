<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsvController extends Controller
{

    public $fileName;
    public $head;
    public $delimiter;

    public function __construct($f,$h,$d){
        $this->fileName = $f;
        $this->head = $h;
        $this->delimiter = $d;
    }
    //$fileName, $head = true, $delimiter = ','
    public function readFile(){

        $fileName  = $this->fileName;
        $head      = $this->head;
        $delimiter = $this->delimiter;

         //Valida se existe a varivel de PATH_TO_FILE.
        if(env('PATH_TO_FILE')){
            $file = env('PATH_TO_FILE').$fileName;
            //Valida se existe o arquivo
            if(file_exists($file)){
                $dataFile = [];

                $csv = fopen($file,'r');
                //head file csv
                $headFile = $head ? fgetcsv($csv,0,$delimiter) : [];
    
                //Loop FILE
                $cont = 0;
                //Abre bloco para transação
                DB::beginTransaction();

                while($line = fgetcsv($csv,0,$delimiter)){

                    //Guarda o cabeçalho do arquivo, para indexar o array
                    $dataFile[] = $head ? array_combine($headFile,$line) : $line;

                    //Pega os valores do arquivo CSV
                    $fromPostCode = $this->cleanCep($dataFile[$cont]['from_postcode']);
                    $toPostCode   = $this->cleanCep($dataFile[$cont]['to_postcode']);
                    $fromWeight   = $this->cleanDecimal($dataFile[$cont]['from_weight']);
                    $toWeight     = $this->cleanDecimal($dataFile[$cont]['to_weight']);
                    $cost         = $this->cleanDecimal($dataFile[$cont]['cost']);

                   
                    /** Grava os arquivo na tabela
                     * parm1 = Cep envio
                     * parm2 = Cep Destino
                     * parm3 = Peso declarado
                     * parm4 = Peso real
                     * parm5 = custo
                     */
                    $this->writeDate($fromPostCode,$toPostCode,$fromWeight,$toWeight,$cost);

                    //Contador
                    $cont++;
                }
                //Comita o bloco de insert
                DB::commit();
                //Limpa iterador e fecha o arquivo
                unset($line);
                fclose($csv);
                
                echo "<b>Done!! Rows inserted in table: </b>".$cont;
            }else{
                echo "File not exists!";
            }
        }else{
            echo "Erro, set path to file in .env file.";
        }
        
    }
   function cleanCep($cep){
        return !empty($cep) ? preg_replace('/\D/','',$cep): '';
   }
   function cleanDecimal($number){
       $number = floatval(str_replace(',', '.', str_replace('.', '', $number)));
        return $number;
   }
   function writeDate($fromPostCode, $toPostCode, $fromWeight, $toWeight, $cost){
        $insert = ['from_postcode'=>$fromPostCode
                   ,'to_postcode'=>$toPostCode
                   ,'from_weight'=>$fromWeight
                   ,'to_weight'=>$toWeight
                   ,'cost'=>$cost];
        DB::table('locale_ship')->insert($insert);    
   }
}
