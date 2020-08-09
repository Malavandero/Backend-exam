<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Util\EmployeeService;

class AddEmployeeCommand extends Command
{
    protected static $defaultName = 'app:add-employee';
    private $employeeService;


    public function __construct(EmployeeService $employeeService){
        $this->employeeService = $employeeService;
        parent::__construct();

    }

    protected function configure()
    {
        $this
            ->setDescription('Add a new employee to a company')
            ->addArgument('name', InputArgument::REQUIRED, 'Employee name')
            ->addArgument('hireDate', InputArgument::REQUIRED, 'Hire date')
            ->addArgument('companyId', InputArgument::REQUIRED, 'Company Id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');
        $hireDate = $input->getArgument('hireDate');
        $companyId = $input->getArgument('companyId');

        try {
            $this->employeeService->create(json_encode(['name' => $name, 'company'=> $companyId, 'hireDate'=> $hireDate]));
        } catch (\Throwable $th) {
            $io->error($th->getMessage());
            return 1;
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return 0;
    }
}
