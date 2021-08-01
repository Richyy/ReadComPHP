<?php


namespace App\Command;


use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use React\Socket\TcpConnector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestSocketCommand extends Command
{
    protected static $defaultName = 'test:socket';
    private $tcpConnector;
    private $loop;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->loop = Factory::create();
        $this->tcpConnector = new TcpConnector($this->loop);
    }

    protected function configure()
    {
        $this
            ->setDescription('Test the socket connection');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Socket testing');
        $io->text([
            'Connecting to the socket...',
        ]);

        $this->tcpConnector->connect("127.0.0.1:8888")->then(function (ConnectionInterface $connection) use ($io) {
            $io->success([
                'Successfully connected to the socket',
            ]);
            $connection->on('data', function ($data) use ($io) {
                $io->text('[FROM SERVER]: '.$data);
            });
            $connection->on('close', function () use ($io) {
                $io->text('[CLOSED]');
            });
            $msg = 'Test from client<EOF>';
            $io->text('[TO SERVER]: '.$msg);
            $connection->write($msg);
        }, function (\RuntimeException $error) use ($io) {
            $io->error($error->getMessage());
        });
        $this->loop->run();

        return Command::SUCCESS;
    }
}
