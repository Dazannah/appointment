<?php

use App\Models\Event;
use App\Services\DateService;
use App\Services\SiteConfigService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

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

  public static function isFitTwoDateTimeDurationProvider() {
    return [
      ['2024-09-23T10:00', '2024-09-23T10:15', '15', true],
      ['2024-09-23T10:00', '2024-09-23T10:15', '0', true],
      ['2024-09-23T10:00','2024-09-23T10:15','30',false],
      ['2024-09-23T10:00','2024-09-23T10:00','30',false],
      ['2024-09-23T10:00','2024-09-23T09:00','30',false],
    ];
  }

  #[Test]
  #[DataProvider('isFitTwoDateTimeDurationProvider')]
  public function isFitTwoDateTimeDuration($firstDateTime, $nextDateTime, $duration, $result) {
    $this->assertEquals(
      $result,
      $this->dateService->isFitTwoDateTimeDuration($firstDateTime, $nextDateTime, $duration)
    );
  }

public static function isFitEndOfDayProvider(){
  return [
    ['2024-09-23T15:30','30',true],
    ['2024-09-23T15:00','30',true],
    ['2024-09-23T15:00','0',false],
    ['2024-09-23T15:00','-1',false],
    ['2024-09-23T20:00','30',false],
    ['2024-09-23T' . '16:00','0',false],/*$this->siteConfig['calendarTimes']['slotMaxTime'],*/
  ];
}

  #[Test]
  #[DataProvider('isFitEndOfDayProvider')]
  public function isFitEndOfDay($startDateTime, $duration, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->isFitEndOfDay($startDateTime, $duration),
      );

  }

  public static function isFitStartOfDayProvider() {
    return [
      ['2024-09-23T08:30','30',true],
      ['2024-09-23T09:00','0',false],
      ['2024-09-23T09:00','-1',false],
      ['2024-09-23T07:00','30',false],
      ['2024-09-23T' . '08:00','0',false],/* $this->siteConfig['calendarTimes']['slotMinTime']*/
    ];
  }

  #[Test]
  #[DataProvider('isFitStartOfDayProvider')]
  public function isFitStartOfDay($eventStartDateTime, $duration, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->isFitStartOfDay($eventStartDateTime, $duration)
      );
  }

  public static function IsEndAfterCloseProvider() {
    return [
      ['2024-09-24T16:00',false],
      ['2024-09-24T16:01',true],
      ['2024-09-24T15:59',false],
    ];
  }

  #[Test]
  #[DataProvider('IsEndAfterCloseProvider')]
  public function IsEndAfterClose($end, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->IsEndAfterClose($end)
      );
  }

  public static function IsStartBeforeOpenProvider() {
    return [
      ['2024-09-24T08:00',false],
      ['2024-09-24T07:59',true],
      ['2024-09-24T08:01',false],
    ];
  }

  #[Test]
  #[DataProvider('IsStartBeforeOpenProvider')]
  public function IsStartBeforeOpen($start, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->IsStartBeforeOpen($start)
      );
  }

  public static function GetMinutsFromDateDiffProvider() {
    return [
      [DateInterval::createFromDateString('1 day'),1440],
      [DateInterval::createFromDateString('0 day'),0],
      [DateInterval::createFromDateString('3 hour'),180],
    ];
  }

  #[Test]
  #[DataProvider('GetMinutsFromDateDiffProvider')]
  public function GetMinutsFromDateDiff($dateInterval, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->GetMinutsFromDateDiff($dateInterval),
      );
  }

  public static function IsStartAndEndDifferenceEqualWithEventDurationProvider() {
    return [
      ['2024-09-24T08:00','2024-09-24T08:30','30',true],
      ['2024-09-24T09:00','2024-09-24T08:30','30',false],
      ['2024-09-24T08:00','2024-09-24T08:30','31',false],
    ];
  }

  #[Test]
  #[DataProvider('IsStartAndEndDifferenceEqualWithEventDurationProvider')]
  public function IsStartAndEndDifferenceEqualWithEventDuration($start, $end, $duration, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->IsStartAndEndDifferenceEqualWithEventDuration($start, $end, $duration),
      );
  }

  public static function getNextEventDateProvider() {
    return [
      ['2024-09-24T08:00',['start' => '2024-09-24T12:00'],'2024-09-24T12:00'],
      ['2024-09-24T08:00',null,'2024-09-24T16:00'],
      ['2024-09-24T08:00',['start' => '2024-09-25T12:00'],'2024-09-24T16:00'],
      ['2024-09-24T08:00',['start' => '2024-09-23T12:00'],'2024-09-24T16:00'],
    ];
  }

  #[Test]
  #[DataProvider('getNextEventDateProvider')]
  public function getNextEventDate($startDate, $event, $result) {
      $this->assertEquals(
        $result,
        $this->dateService->getNextEventDate($startDate, $event),
      );
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
