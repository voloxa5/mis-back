<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DictYesNosTableSeeder::class);
        $this->call(DictPostsTableSeeder::class);
        $this->call(DictRanksTableSeeder::class);
        $this->call(DictSexesTableSeeder::class);
        $this->call(DictSecrecyDegreeTableSeeder::class);
        $this->call(ProgramsTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(SupervisionsTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(AssignmentRanksTableSeeder::class);
        $this->call(AssignmentPostsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ActualEmployeesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(GroupGroupsTableSeeder::class);
        $this->call(ShiftInstructionsTableSeeder::class);
        $this->call(TimeSheetsTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(FormsTableSeeder::class);
        $this->call(TemplatesTableSeeder::class);
        $this->call(DocumentDefinitionsTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(GroupDocumentsTableSeeder::class);
    }
}
