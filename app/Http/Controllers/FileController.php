<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CsvController;

class FileController extends Controller
{
    //Load CSV FILE
    public function loadFile(){
      $file = 'price-table.csv';
      $head = true;
      $delimiter = ';';

       /** 
       * parm 1 = arquivo a ser enviado
       * parm 2 = habilita ou desabilita cabeçalho true/False
       * parm 3 = Separador do arquivo CSV
       */
      $csvFile = new CsvController($file,$head,$delimiter);
      $csvFile->readFile();

    }
}
