<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class JobsAPITest extends TestCase
{
    use Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * @var App\User[]
     */
    private $users;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->users = factory(App\User::class, 2)->create();
    }

    /**
     * @test
     */
    public function it_gets_all_jobs()
    {
        $job = factory(App\Job::class)->create([
            'user_id' => $this->users[0]->id,
            'approved' => true,
        ]);

        $this->actingAs($this->users[1])
            ->get('/api/v1/jobs')
            ->see($job->id);
    }

    /**
     * @test
     */
    public function it_gets_watched_jobs()
    {
        $job = factory(App\Job::class)->create([
            'user_id' => $this->users[0]->id,
            'approved' => true,
        ]);
        $this->users[1]->watching()->attach($job);

        $this->actingAs($this->users[1])
            ->get("/api/v1/jobs/watching")
            ->see($job->id);
    }

    /**
     * @test
     */
    public function it_gets_owned_jobs()
    {
        $job = factory(App\Job::class)->create([
            'user_id' => $this->users[0]->id,
            'approved' => false,
        ]);

        $this->actingAs($this->users[0])
            ->get("/api/v1/jobs/owned")
            ->see($job->id);
    }

    /**
     * @test
     */
    public function it_gets_jobs_within_radius()
    {

    }
}