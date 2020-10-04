<?php

namespace App\Command;

use App\Application\Company\AddEmployee\AddEmployeeUseCase;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddEmployeeToCompany extends Command
{
    protected static $defaultName = 'exam:company:add-employee';

    protected $useCase;

    /**
     * AddEmployeeToCompany constructor.
     * @param AddEmployeeUseCase $useCase
     */
    public function __construct(AddEmployeeUseCase $useCase)
    {
        parent::__construct();
        $this->useCase = $useCase;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Add an existing employee to an existing company')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp(
                'This command add an employee to a company'
            )
            ->addArgument('companyId', InputArgument::REQUIRED, 'companyId')
            ->addArgument('employeeId', InputArgument::REQUIRED, 'employeeId');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $companyId = $input->getArgument('companyId');
        $employeeId = $input->getArgument('employeeId');

        try {
            $this->useCase->__invoke($companyId, $employeeId);
            $output->writeln("<info>Employee Added To Company</info>");
            return 0;
        }catch(Exception $e) {
            $output->writeln(
                [
                    '<error>Fail executing adding employee to company</error>',
                    '<error>' . $e->getMessage() . '</error>',
                    '<error> code: ' . $e->getCode() . '</error>'
                ]
            );
            return 1;
        }

    }
}