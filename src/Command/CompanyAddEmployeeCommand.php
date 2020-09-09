<?php

namespace App\Command;

use App\Entity\Company;
use App\Service\CompanyService;
use Assert\AssertionFailedException;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CompanyAddEmployeeCommand extends Command
{
    protected static $defaultName = 'company:add-employee';

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * CompanyAddEmployeeCommand constructor.
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Command for add an employee to a company')
            ->addArgument('companyId', InputArgument::OPTIONAL, 'Company ID')
            ->addArgument('employeeId', InputArgument::OPTIONAL, 'EmployeeID');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $companyId = $input->getArgument('companyId');
        $employeeId = $input->getArgument('employeeId');

        if ($companyId) {
            $io->note(sprintf('You passed the companyId argument: %s', $companyId));
        }
        if ($employeeId) {
            $io->note(sprintf('You passed the employeeId argument: %s', $employeeId));
        }
        try {
            $this->companyService->addEmployeeToCompany($employeeId, $companyId);
        } catch (Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('Employee added to company');

        return Command::SUCCESS;
    }
}
