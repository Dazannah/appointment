<?php

use App\Models\Event;
use App\Models\WorkTypes;
use App\Services\DateService;
use App\Services\UserService;
use App\Services\EventService;
use PHPUnit\Framework\TestCase;
use App\Services\SiteConfigService;
use PHPUnit\Framework\Attributes\Test;

class EventServiceTest extends TestCase {

  protected EventService $eventServiceMock;

  public function setUp(): void {
    $siteConfigService = new SiteConfigService();

    $dateService = new DateService($siteConfigService);

    $userService = new UserService;

    $this->eventServiceMock =
      $this
      ->getMockBuilder(EventService::class)
      ->setConstructorArgs([
        $dateService,
        $userService
      ])
      ->onlyMethods(['getEventWhere'])
      ->getMock();
  }

  #[Test]
  public function getNextAvailableEventTime() {
    $worktype = new WorkTypes([
      'name' => 'Test work',
      'duration' => '30',
      'price_id' => 1
    ]);

    $day = '2024-09-25T08:00';

    $this->eventServiceMock->method('getEventWhere')->willReturn(
      new Event(
        [
          'start' => '2024-09-25T09:00',
          'end' => '2024-09-25T09:30',
          'title' => 'This is the title',
          'user_id' => 1,
          'work_type_id' => 1,
          'note' => '',
          'status_id' => 1
        ]
      )
    );

    $result = $this->eventServiceMock->getNextAvailableEventTime($worktype, $day);

    $shouldBe = [
      'start' => '2024-09-25T08:00',
      'end' => '2024-09-25T08:30',
    ];

    //$this->assertEquals($shouldBe, $result);
  }
}
