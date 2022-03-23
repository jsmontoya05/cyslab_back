<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class LaboratoryApiTest extends TestCase 
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    protected $laboratory  = [
        'name'          => \Illuminate\Support\Str::random(40),
        'maxUsersInLab' => '2',
        'usageQuota'    => 'PT2H',
        'template'      => '/subscriptions/438fe8a7-037b-4b33-987f-d5be719baa73/resourcegroups/cyslabgroup/providers/microsoft.labservices/labaccounts/8baf774b-640d-43cf-9fdc-3bc95eb64862/galleryimages/windows 10 pro, version 2004',
        'size'          => 'Basic',
        'userName'      => 'danieladmin',
        'password'      => 'danieladminR123',
    ];
    /**
     * @test
     */
    public function test_read_laboratories()
    {   
        $user = User::first();
        $this->response = $this->actingAs($user, 'api')->json('GET','/api/laboratories')->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_read_laboratory()
    {   
        $user = User::first();
        $laboratories = $this->actingAs($user, 'api')->json('GET','/api/laboratories');
        $this->response = $this->actingAs($user, 'api')->json('GET','/api/laboratories/'.$laboratories['data'][0]['name'])->assertStatus(200);
    }


    /**
     * @test
     */
 /*     public function test_create_laboratory()
    {   
        $user = User::first();
        $this->response = $this->actingAs($user, 'api')->json('POST','/api/laboratories/',$this->laboratory )
        ->assertStatus(200);
    }  */

    /**
     * @test
     */
    public function test_delete_laboratory()
    {   
        $user = User::first();
        $laboratories = $this->actingAs($user, 'api')->json('GET','/api/laboratories');
        $this->response = $this->actingAs($user, 'api')->json('DELETE','/api/laboratories/'.$this->laboratory['name'])->assertStatus(200);
    }



}
