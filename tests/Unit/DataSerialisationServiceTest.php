<?php

use App\Models\ClosedDay;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Services\DataSerialisationService;
use App\Services\SiteConfigService;
use Illuminate\Database\Eloquent\Collection;

class DataSerialisationServiceTest extends TestCase {

  protected $dataSerialisationService;
  protected $siteConfigService;
  protected $siteConfig;

  public  function setUp(): void {
    $this->siteConfigService = app(SiteConfigService::class);
    $this->siteConfig = $this->siteConfigService->getConfig();
    $this->dataSerialisationService = $this->getMockBuilder(DataSerialisationService::class)
      ->setConstructorArgs(
        [$this->siteConfigService]
      )
      ->onlyMethods(['getUserId'])->getMock();

    $this->dataSerialisationService->method('getUserId')->willReturn(1);
  }

  #[Test]
  public function serialiseInputForCreateClosedDay() {
    $result = $this->dataSerialisationService->serialiseInputForCreateClosedDay(['startDate' => '2024-09-22T14:00', 'endDate' => '2024-09-22T14:00']);

    $this->assertEquals($result, ['start' => '2024-09-22T14:00', 'end' => '2024-09-22T14:00']);
  }

  #[Test]
  public function serialiseInputForEditEvent() {
    $event = new stdClass();
    $event->note = null;
    $event->admin_note = null;
    $event->status_id = null;

    $validated = [
      'userNote' => 'This is the user writen note.',
      'adminNote' => 'This is the admin writen note.',
      'status' => 1
    ];

    $this->dataSerialisationService->serialiseInputForEditEvent($validated, $event);

    $shouldBe = new stdClass();
    $shouldBe->note = 'This is the user writen note.';
    $shouldBe->admin_note = 'This is the admin writen note.';
    $shouldBe->status_id = 1;

    $this->assertEquals($event, $shouldBe);
  }

  #[Test]
  public function serialiseInputForEditUserIsNotAdmin() {
    $user = new stdClass();
    $user->name = null;
    $user->created_at = null;
    $user->updated_at = null;
    $user->email = null;
    $user->user_status_id = null;
    $user->updated_by = null;

    $validated = [
      'fullName' => 'Test Full Name',
      'createdAt' => '2024-09-22T14:38',
      'updatedAt' => '2024-09-22T15:00',
      'emailAddress' => 'test@test.test',
      'status' => 1,
    ];

    $shouldBe = new stdClass();
    $shouldBe->name = 'Test Full Name';
    $shouldBe->created_at = '2024-09-22T14:38';
    $shouldBe->updated_at = '2024-09-22T15:00';
    $shouldBe->email = 'test@test.test';
    $shouldBe->user_status_id = 1;
    $shouldBe->updated_by = 1;
    $shouldBe->is_admin = 0;

    $this->dataSerialisationService->serialiseInputForEditUser($validated, $user);

    $this->assertEquals($shouldBe, $user);
  }

  #[Test]
  public function serialiseInputForEditUserIsAdmin() {
    $user = new stdClass();
    $user->name = null;
    $user->created_at = null;
    $user->updated_at = null;
    $user->email = null;
    $user->user_status_id = null;
    $user->updated_by = null;

    $validated = [
      'fullName' => 'Test Full Name',
      'createdAt' => '2024-09-22T14:38',
      'updatedAt' => '2024-09-22T15:00',
      'emailAddress' => 'test@test.test',
      'status' => 1,
      'isAdmin' => 'on'
    ];

    $shouldBe = new stdClass();
    $shouldBe->name = 'Test Full Name';
    $shouldBe->created_at = '2024-09-22T14:38';
    $shouldBe->updated_at = '2024-09-22T15:00';
    $shouldBe->email = 'test@test.test';
    $shouldBe->user_status_id = 1;
    $shouldBe->updated_by = 1;
    $shouldBe->is_admin = 1;

    $this->dataSerialisationService->serialiseInputForEditUser($validated, $user);

    $this->assertEquals($shouldBe, $user);
  }

  #[Test]
  public function serialseClosedDaysForCalendar() {
    $inputClosedDays = new Collection(
      [
        new ClosedDay(['start' => '2024-09-22', 'end' => '2024-09-22', 'title' => null]),
        new ClosedDay(['start' => '2024-09-20', 'end' => '2024-09-20', 'title' => 'Test title']),
        new ClosedDay(['start' => '2024-09-18', 'end' => '2024-09-18', 'title' => null])
      ]
    );

    $resultClosedDays = $this->dataSerialisationService->serialseClosedDaysForCalendar($inputClosedDays);

    $shouldBe = new Collection(
      [
        new ClosedDay([
          'start' => '2024-09-22' . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'],
          'end' => '2024-09-22' . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'],
          'title' => $this->siteConfig['closedDays']['title']
        ]),
        new ClosedDay([
          'start' => '2024-09-20' . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'],
          'end' => '2024-09-20' . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'],
          'title' => 'Test title'
        ]),
        new ClosedDay([
          'start' => '2024-09-18' . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'],
          'end' => '2024-09-18' . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'],
          'title' => $this->siteConfig['closedDays']['title']
        ])
      ]
    );

    $this->assertEquals($shouldBe, $resultClosedDays);
  }
}
