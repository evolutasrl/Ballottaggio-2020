<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voter;
use Carbon\Carbon;

class json extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:json';

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
        $raw = file_get_contents(__DIR__.'/../../../storage/dataf.json');
        $data = \json_decode($raw);

        foreach ($data as $elem) {
            Voter::create(
                [
                        'nome' => $elem->nome,
                        'cognome' => $elem->cognome,
                        'data_nascita' => Carbon::createFromFormat('d/m/Y', $elem->dataNascita),
                        'citta_nascita' => $elem->luogoNascita,
                        'indirizzo_residenza' => property_exists($elem, 'indirizzo')?$elem->indirizzo:"",
                        'sezione' => $elem->sezione,
                        'sesso' => "f",
                        "attivo" => $elem->attivo
                    ]
            );
        }
    }
}
