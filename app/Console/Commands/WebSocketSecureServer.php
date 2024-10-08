<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\WebsocketController;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\SecureServer;
use React\Socket\Server;

class WebSocketSecureServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocketsecure:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $loop   = Factory::create();
        $webSock = new SecureServer(
            new Server('0.0.0.0:8091', $loop),
            $loop,
            array(
                'local_cert'        => 'C:/xampp/apache/conf/ssl.crt/server.crt', // path to your cert
                'local_pk'          => 'C:/xampp/apache/conf/ssl.key/server.key', // path to your server private key
                'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)
                'verify_peer' => FALSE
            )
        );

        // Ratchet magic
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WebsocketController()
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
