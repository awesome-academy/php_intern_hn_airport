<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\Agency\RequestController;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreRequestPost;
use App\Models\HostDetail;
use App\Models\Request;
use App\Models\User;
use App\Notifications\RequestNotification;
use App\Repositories\HostDetail\HostDetailRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCase;

class RequestControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $requestMock;
    protected $viewShareMock;
    protected $requestDestinationMock;
    protected $requestController;
    protected $hostDetailMock;
    protected $userMock;

    public function setUp(): void
    {
        /** @var RequestRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
        $this->requestMock = Mockery::mock(RequestRepositoryInterface::class);
        /** @var RequestDestinationRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
        $this->requestDestinationMock = Mockery::mock(RequestDestinationRepositoryInterface::class);
        /** @var ViewShareController|PHPUnit_Framework_MockObject_MockObject */
        $this->viewShareMock = Mockery::mock(ViewShareController::class);
        /** @var HostDetailRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
        $this->hostDetailMock = Mockery::mock(HostDetailRepositoryInterface::class);
        /** @var UserRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
        $this->userMock = Mockery::mock(UserRepositoryInterface::class);
        $this->requestController = new RequestController(
            $this->requestMock,
            $this->requestDestinationMock,
            $this->viewShareMock,
            $this->hostDetailMock,
            $this->userMock
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->requestController);
        Mockery::close();
        parent::tearDown();
    }

    public function testIndexFunction()
    {
        $this->requestMock
            ->shouldReceive('getRequestNew')
            ->once()
            ->andReturn(new Collection());
        $this->requestMock
            ->shouldReceive('getRequestCancel')
            ->once()
            ->andReturn(new Collection);

        $result = $this->requestController->index();
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('agency.listRequest.index', $result->getName());
        $this->assertArrayHasKey('requestNew', $data);
        $this->assertArrayHasKey('requestCancel', $data);
    }

    public function testCreateFunction()
    {
        $result = $this->requestController->create();
        $this->assertEquals('agency.createRequest.index', $result->getName());
    }

    public function testStoreFunction()
    {
        Notification::fake();
        $this->faker = Faker::create();
        $request = new Request();
        $request->id = config('constance.const.one');

        $hosts = new Collection();
        $host = new HostDetail();
        $hosts->push($host);

        $user = new User();
        $user->id = config('constance.const.one');

        $this->requestMock
            ->shouldReceive('create')
            ->once()
            ->andReturn($request);

        $this->requestDestinationMock
            ->shouldReceive('create')
            ->twice()
            ->andReturn(true);

        $this->hostDetailMock
            ->shouldReceive('filterHostDetail')
            ->once()
            ->andReturn($hosts);

        $this->userMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($user);

        Notification::assertNothingSent();

        $data = [
            'car_type_id' => config('constance.const.one'),
            'province_airport_id' => config('constance.const.one'),
            'pickup' => Carbon::now(),
            'budget' => rand(),
            'pickup_location' => array($this->faker->text(10)),
            'dropoff_location' => array($this->faker->text(10)),
        ];
        $storeRequest = new StoreRequestPost($data);
        $result = $this->requestController->store($storeRequest);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testStoreFunctionFail()
    {
        $this->faker = Faker::create();
        $request = new Request();
        $request->id = config('constance.const.one');
        $this->requestMock
            ->shouldReceive('create')
            ->once()
            ->andReturn(false);

        $data = [
            'car_type_id' => config('constance.const.one'),
            'province_airport_id' => config('constance.const.one'),
            'pickup' => Carbon::now(),
            'budget' => rand(),
            'pickup_location' => array($this->faker->text(10)),
            'dropoff_location' => array($this->faker->text(10)),
        ];
        $storeRequest = new StoreRequestPost($data);
        $result = $this->requestController->store($storeRequest);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testShowFunction()
    {
        $this->requestMock
            ->shouldReceive('find')
            ->once()
            ->andReturn(true);
        $id = rand();
        $result = $this->requestController->show($id);
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('agency.requestDetail.index', $result->getName());
        $this->assertArrayHasKey('requestDetail', $data);
    }

    public function testShowFunctionFail()
    {
        $this->requestMock
            ->shouldReceive('find')
            ->once()
            ->andThrow(new Exception());
        $id = rand();
        $result = $this->requestController->show($id);
        $this->assertEquals('404', $result->getName());
    }

    public function testUpdateFunction()
    {
        $this->faker = Faker::create();
        $this->requestMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $this->requestDestinationMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $this->requestDestinationMock
            ->shouldReceive('create')
            ->twice()
            ->andReturn(true);

        $data = [
            'car_type_id' => config('constance.const.one'),
            'province_airport_id' => config('constance.const.one'),
            'pickup' => Carbon::now(),
            'budget' => rand(),
            'pickup_location' => array($this->faker->text(10)),
            'dropoff_location' => array($this->faker->text(10)),
        ];
        $storeRequest = new StoreRequestPost($data);
        $id = rand();
        $result = $this->requestController->update($storeRequest, $id);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testUpdateFunctionFail()
    {
        $this->faker = Faker::create();

        $this->requestMock
            ->shouldReceive('update')
            ->once()
            ->andThrow(new Exception());
        $data = [
            'car_type_id' => config('constance.const.one'),
            'province_airport_id' => config('constance.const.one'),
            'pickup' => Carbon::now(),
            'budget' => rand(),
            'pickup_location' => array($this->faker->text(10)),
            'dropoff_location' => array($this->faker->text(10)),
        ];
        $storeRequest = new StoreRequestPost($data);
        $id = rand();
        $result = $this->requestController->update($storeRequest, $id);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testDestroyFunction()
    {
        $this->requestMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        $id = rand();
        $result = $this->requestController->destroy($id);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function testDestroyFunctionFail()
    {
        $this->requestMock
            ->shouldReceive('delete')
            ->once()
            ->andThrow(new Exception());
        $id = rand();
        $result = $this->requestController->destroy($id);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
