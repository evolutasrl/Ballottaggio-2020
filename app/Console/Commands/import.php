<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voter;
use Carbon\Carbon;

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
       * Execute the console command.
       *
       * @return mixed
       */
    public function handle()
    {
        $skips = [
            'COMUNE DI POSADA',
            'LISTA SEZIONALE',
            '---------------',
            'Nr.L.Generale  Anno/Fascicolo  Sezione',
            'ordine| Cognome/Nome',
            'Luogo di Nascita e Data',
            '| Atto di Nascita ',
            '        | Indirizzo   ',
            'eletto-',
            're ha votato.',
            '                          Pag',
            'Bollo    Visto: Il presidente della Commissione Elettorale Circondariale',
            'Atto n.'
        ];

        $handle = fopen(__DIR__.'/../../../storage/data5.txt', "r");
        if ($handle) {
            $r = 0;
            while (($line = fgets($handle)) !== false) {
                $s = 0;
                foreach ($skips as $skip) {
                    if (strpos($line, $skip) !== false) {
                        $s = 1;
                    }
                }
                if ($s == 0 && strlen($line) != 1 && $line != ''&& strpos($line, '|') !== false) {
                    //$this->comment(explode('|', $line)[2]);
                    $r++;

                    if ($r == 1) {
                        $voter = [];
                        $voter['sezione'] = preg_split('/ +/', trim(explode('|', $line)[2]))[3];
                    }
                    if ($r == 2) {
                        $nome = trim(explode('|', $line)[2]);
                        $voter['nome'] = $this->cognomeExtractor($nome)['nomi'];
                        $voter['cognome'] = $this->cognomeExtractor($nome)['cognomi'];
                    }
                    if ($r == 3) {
                        $voter['nato_a'] = trim($this->natoa(explode('|', $line)[2])[0]).")";
                        
                        preg_match('/\d{2}\/\d{2}\/\d{4}/', $line, $extractedDate);
                        $voter['nato_il'] = $extractedDate[0];
                    }
                    if ($r == 4) {
                        $voter['residente'] = trim(explode('|', $line)[2]);
                    }




                    if ($r == 4) {
                        $r = 0;
                        
                        var_dump($voter);

                        //$this->comment($voter['nom);


                        Voter::create(
                            [
                                'nome' => $voter['nome'],
                                'cognome' => implode(" ", $voter['cognome']),
                                'data_nascita' => Carbon::createFromFormat('d/m/Y', $voter['nato_il']),
                                'citta_nascita' => $voter['nato_a'],
                                'indirizzo_residenza' => $voter['residente'],
                                'sezione' => $voter['sezione'],
                            ]
                        );


                        $voter = null;
                        $this->comment('-------------------------------------');
                    }
                }
            }

            fclose($handle);
        } else {
            // error opening the file.
        }
    }

    public function natoa($val)
    {
        $ret = explode(')', $val);
        return $ret;
    }

    
    private function cognomeExtractor($nome)
    {
        $cognomi = [];

        $var = explode('Ved.', $nome);
        if (array_key_exists(1, $var)) {
            $cognomi[] = trim($var[1]);
        }

        $var = explode('Cgt.', $nome);
        if (array_key_exists(1, $var)) {
            $cognomi[] = trim($var[1]);
        }

        $var = explode(' ', $nome);
        $cognomi[] = trim($var[0]);

        return ["cognomi" => $cognomi, "nomi" => $var[1]];
    }
}
