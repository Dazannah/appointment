<?php

namespace Tests\Unit;

use App\Interfaces\IDataSerialisation;
use Tests\TestCase;
use App\Interfaces\IDate;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\IEvent;
use App\Models\ClosedDayMock;
use App\Interfaces\ISiteConfig;
use App\Services\ClosedDayService;
use PHPUnit\Framework\Attributes\Test;

class ClosedDayServiceTest extends TestCase {

    protected $dateServiceMock;
    protected $eventServiceMock;
    protected $siteConfigServiceMock;
    protected $closedDayServiceMock;
    protected $holidays;
    protected $closedDayMock;
    protected $dataSerialisationMock;

    public function setUp(): void {
        parent::setUp();

        $this->dateServiceMock =  $this->createMock(IDate::class);
        $this->eventServiceMock =  $this->createMock(IEvent::class);
        $this->siteConfigServiceMock =  $this->createMock(ISiteConfig::class);
        $this->closedDayMock =  $this->getMockBuilder(ClosedDayMock::class)->onlyMethods(['create'])->getMock();
        $this->dataSerialisationMock =  $this->createMock(IDataSerialisation::class);

        $this->siteConfigServiceMock->method('getConfig')
            ->willReturn(['calendarTimes' => ['slotMinTime' => '08:00', 'slotMaxTime' => '18:00']]);

        $this->closedDayServiceMock = $this->getMockBuilder(ClosedDayService::class)
            ->setConstructorArgs(
                [
                    $this->siteConfigServiceMock,
                    $this->dateServiceMock,
                    $this->eventServiceMock,
                    $this->closedDayMock,
                    $this->dataSerialisationMock
                ]
            )->onlyMethods(['isClosedDay', 'getClosedDayByInput'])->getMock();

        $this->holidays = [
            ['name' => 'Húsvét', 'date' => '2024-03-31', 'type' => 2],
            ['name' => 'Újév', 'date' => '2024-01-01', 'type' => 1],
            ['name' => '1848-as forradalom ünnepe', 'date' => '2024-03-15', 'type' => 1],
            ['name' => 'Nagypéntek', 'date' => '2024-03-29', 'type' => 1],
            ['name' => 'Húsvét', 'date' => '2024-03-31', 'type' => 1],
            ['name' => 'Húsvét', 'date' => '2024-03-31', 'type' => 2],
            ['name' => 'Test Case', 'date' => '2024-04-25', 'type' => 2]
        ];
    }

    #[Test]
    public function handleHolidaysFalse() {
        $this->closedDayServiceMock->method('isClosedDay')->willReturn(false);
        $this->closedDayMock->expects($this->exactly(4))->method('create')->willReturn(true);

        $this->closedDayMock
            ->method('create')
            ->with($this->logicalOr(
                [
                    'title' => 'Újév',
                    'start' => '2024-01-01',
                    'end' => '2024-01-01'
                ],
                [
                    'title' => '1848-as forradalom ünnepe',
                    'start' => '2024-03-15',
                    'end' => '2024-03-15'
                ],
                [
                    'title' => 'Nagypéntek',
                    'start' => '2024-03-29',
                    'end' => '2024-03-29'
                ],
                [
                    'title' => 'Húsvét',
                    'start' => '2024-03-31',
                    'end' => '2024-03-31'
                ]
            ));

        $this->closedDayServiceMock->handleHolidays($this->holidays, 2024);
    }

    #[Test]
    public function handleHolidaysTrue() {
        $this->closedDayServiceMock->method('isClosedDay')->willReturn(true);

        $this->closedDayMock->expects($this->exactly(0))->method('create')->willReturn(true);

        $this->closedDayServiceMock->handleHolidays($this->holidays, 2024);
    }

    #[Test]
    function validateIfCanSaveIsItWorkDayWillReturnFalse() {
        $this->dateServiceMock->method('isItWorkDay')->willReturn(false);

        $result = $this->closedDayServiceMock
            ->validateIfCanSave(['startDate' => '2024-09-22', 'endDate' => '2024-09-22']);

        $this->assertEquals($result, ['canSave' => false, 'message' => "Start on weekend. Can't save it."]);
    }

    #[Test]
    function validateIfCanSaveIsItWorkDayWillReturnTrueGetClosedDayByInputReturnCountBigerThan0() {
        $this->dateServiceMock->method('isItWorkDay')->willReturn(true);
        $this->closedDayServiceMock->method('getClosedDayByInput')->willReturn(new Collection('this is one element in collection'));

        $result = $this->closedDayServiceMock
            ->validateIfCanSave(['startDate' => '2024-09-22', 'endDate' => '2024-09-22']);

        $this->assertEquals($result, ['canSave' => false, 'message' => "Can't save on this date.<br>There is already closed day on this date."]);
    }

    #[Test]
    function validateIfCanSaveIsItWorkDayWillReturnTrueGetClosedDayByInputReturnCount0GetAllEventOnTheDayCountBiggerThan0() {
        $this->dateServiceMock->method('isItWorkDay')->willReturn(true);
        $this->closedDayServiceMock->method('getClosedDayByInput')->willReturn(new Collection());
        $this->eventServiceMock->method('getAllEventOnTheDay')->willReturn(new Collection('this is one element in collection'));

        $result = $this->closedDayServiceMock
            ->validateIfCanSave(['startDate' => '2024-09-22', 'endDate' => '2024-09-22']);

        $this->assertEquals($result, ['canSave' => false, 'message' => "Can't save on this date.<br>There is reserved events on the dates."]);
    }

    #[Test]
    function validateIfCanSaveIsItWorkDayWillReturnTrueGetClosedDayByInputReturnCount0GetAllEventOnTheDayCountIs0() {
        $this->dateServiceMock->method('isItWorkDay')->willReturn(true);
        $this->closedDayServiceMock->method('getClosedDayByInput')->willReturn(new Collection());
        $this->eventServiceMock->method('getAllEventOnTheDay')->willReturn(new Collection());
        $result = $this->closedDayServiceMock
            ->validateIfCanSave(['startDate' => '2024-09-22', 'endDate' => '2024-09-22']);

        $this->assertEquals($result, ['canSave' => true]);
    }
}
