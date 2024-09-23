<?php

use App\Services\DateService;
use App\Services\SiteConfigService;
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
}
