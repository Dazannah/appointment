<?php

use App\Models\Event;
use App\Services\DateService;
use App\Services\SiteConfigService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DateServiceTest extends TestCase {

  protected $dateService;
  protected $siteConfig;

  public function setUp(): void {
    $siteConfig = app(SiteConfigService::class);

    $this->siteConfig =  $siteConfig->getConfig();

    $this->siteConfig['calendarTimes']['slotMinTime'] = '08:00';
    $this->siteConfig['calendarTimes']['slotMaxTime'] = '16:00';

    $this->dateService = new DateService($siteConfig);
  }

  #[Test]
  public function getOpenTimeFromDate() {
    $dateTime = $this->dateService->getOpenTimeFromDate('2024-09-22');

    $this->assertEquals([
      'start' => '2024-09-22' . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'],
      'end' => '2024-09-22' . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'],
    ], $dateTime);
  }

  #[Test]
  public function isFitTwoDateTimeDuration() {
    $testCases = [
      [
        'firstDateTime' => '2024-09-23T10:00',
        'nextDateTime' => '2024-09-23T10:15',
        'duration' => '15',
        'result' => true
      ],
      [
        'firstDateTime' => '2024-09-23T10:00',
        'nextDateTime' => '2024-09-23T10:15',
        'duration' => '0',
        'result' => true
      ],
      [
        'firstDateTime' => '2024-09-23T10:00',
        'nextDateTime' => '2024-09-23T10:15',
        'duration' => '30',
        'result' => false
      ],
      [
        'firstDateTime' => '2024-09-23T10:00',
        'nextDateTime' => '2024-09-23T10:00',
        'duration' => '30',
        'result' => false
      ],
      [
        'firstDateTime' => '2024-09-23T10:00',
        'nextDateTime' => '2024-09-23T09:00',
        'duration' => '30',
        'result' => false
      ]
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->isFitTwoDateTimeDuration($case['firstDateTime'], $case['nextDateTime'], $case['duration']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function isFitEndOfDay() {
    $testCases = [
      [
        'startDateTime' => '2024-09-23T15:30',
        'duration' => '30',
        'result' => true
      ],
      [
        'startDateTime' => '2024-09-23T15:00',
        'duration' => '30',
        'result' => true
      ],
      [
        'startDateTime' => '2024-09-23T15:00',
        'duration' => '0',
        'result' => false
      ],
      [
        'startDateTime' => '2024-09-23T15:00',
        'duration' => '-1',
        'result' => false
      ],
      [
        'startDateTime' => '2024-09-23T20:00',
        'duration' => '30',
        'result' => false
      ],

      [
        'startDateTime' => '2024-09-23T' . $this->siteConfig['calendarTimes']['slotMaxTime'],
        'duration' => '0',
        'result' => false
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->isFitEndOfDay($case['startDateTime'], $case['duration']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function isFitStartOfDay() {
    $testCases = [
      [
        'eventStartDateTime' => '2024-09-23T08:30',
        'duration' => '30',
        'result' => true
      ],
      [
        'eventStartDateTime' => '2024-09-23T09:00',
        'duration' => '0',
        'result' => false
      ],
      [
        'eventStartDateTime' => '2024-09-23T09:00',
        'duration' => '-1',
        'result' => false
      ],
      [
        'eventStartDateTime' => '2024-09-23T07:00',
        'duration' => '30',
        'result' => false
      ],
      [
        'eventStartDateTime' => '2024-09-23T' . $this->siteConfig['calendarTimes']['slotMinTime'],
        'duration' => '0',
        'result' => false
      ]
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->isFitStartOfDay($case['eventStartDateTime'], $case['duration']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function IsEndAfterClose() {
    $testCases = [
      [
        'end' => '2024-09-24T16:00',
        'result' => false
      ],
      [
        'end' => '2024-09-24T16:01',
        'result' => true
      ],
      [
        'end' => '2024-09-24T15:59',
        'result' => false
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->IsEndAfterClose($case['end']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function IsStartBeforeOpen() {
    $testCases = [
      [
        'start' => '2024-09-24T08:00',
        'result' => false
      ],
      [
        'start' => '2024-09-24T07:59',
        'result' => true
      ],
      [
        'start' => '2024-09-24T08:01',
        'result' => false
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->IsStartBeforeOpen($case['start']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function GetMinutsFromDateDiff() {
    $testCases = [
      [
        'dateInteval' => DateInterval::createFromDateString('1 day'),
        'result' => 1440
      ],
      [
        'dateInteval' => DateInterval::createFromDateString('0 day'),
        'result' => 0
      ],
      [
        'dateInteval' => DateInterval::createFromDateString('3 hour'),
        'result' => 180
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->GetMinutsFromDateDiff($case['dateInteval']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function IsStartAndEndDifferenceEqualWithEventDuration() {
    $testCases = [
      [
        'start' => '2024-09-24T08:00',
        'end' => '2024-09-24T08:30',
        'duration' => '30',
        'result' => true
      ],
      [
        'start' => '2024-09-24T09:00',
        'end' => '2024-09-24T08:30',
        'duration' => '30',
        'result' => false
      ],
      [
        'start' => '2024-09-24T08:00',
        'end' => '2024-09-24T08:30',
        'duration' => '31',
        'result' => false
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->IsStartAndEndDifferenceEqualWithEventDuration($case['start'], $case['end'], $case['duration']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function getNextEventDate() {
    $testCases = [
      [
        'startDate' => '2024-09-24T08:00',
        'event' => ['start' => '2024-09-24T12:00'],
        'result' => '2024-09-24T12:00'
      ],
      [
        'startDate' => '2024-09-24T08:00',
        'event' => null,
        'result' => '2024-09-24T16:00'
      ],
      [
        'startDate' => '2024-09-24T08:00',
        'event' => ['start' => '2024-09-25T12:00'],
        'result' => '2024-09-24T16:00'
      ],
      [
        'startDate' => '2024-09-24T08:00',
        'event' => ['start' => '2024-09-23T12:00'],
        'result' => '2024-09-24T16:00'
      ],
    ];

    foreach ($testCases as $index => $case) {
      $this->assertEquals(
        $case['result'],
        $this->dateService->getNextEventDate($case['startDate'], $case['event']),
        "Test case {$index} failed."
      );
    }
  }

  #[Test]
  public function replaceTInStartEnd() {

    $appointments = new Collection(
      [
        new Event([
          'start' => '2024-09-24T10:00',
          'end' => '2024-09-24T10:30',
          'title' => 'This is the title',
          'user_id' => 1,
          'work_type_id' => 1,
          'note' => '',
          'status_id' => 1
        ]),
        new Event([
          'start' => '2024-09-24 10:00',
          'end' => '2024-09-24 10:30',
          'title' => 'This is the title',
          'user_id' => 1,
          'work_type_id' => 1,
          'note' => '',
          'status_id' => 1
        ])
      ]
    );

    $result = new Collection(
      [
        new Event([
          'start' => '2024-09-24 10:00',
          'end' => '2024-09-24 10:30',
          'title' => 'This is the title',
          'user_id' => 1,
          'work_type_id' => 1,
          'note' => '',
          'status_id' => 1
        ]),
        new Event([
          'start' => '2024-09-24 10:00',
          'end' => '2024-09-24 10:30',
          'title' => 'This is the title',
          'user_id' => 1,
          'work_type_id' => 1,
          'note' => '',
          'status_id' => 1
        ])
      ]
    );

    $this->dateService->replaceTInStartEnd($appointments);

    $this->assertEquals($result, $appointments);
  }
}
